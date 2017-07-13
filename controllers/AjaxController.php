<?php

namespace app\controllers;

use app\models\ToDo;
use app\models\TodoRules;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AjaxController extends Controller
{
    public function actionUsers(){
        echo json_encode(User::find()
            ->where(sprintf('id <> %d'),Yii::$app->user->id)
            ->asArray()
            ->all());

    }

    public function actionShare(){
        $rules = new TodoRules();
        $rules->user_id = \Yii::$app->request->get('user_id');
        $rules->todo_id = \Yii::$app->request->get('todo_id');
        $rules->edit = \Yii::$app->request->get('edit');
        $rules->save();
    }

    public function actionSendtodo(){
        $this->isAjax();
        if(\Yii::$app->request->get('id')){
            $todo = ToDo::findOne(\Yii::$app->request->get('id'));
            if($todo){
                $todo->target = \Yii::$app->request->get('message');
                $todo->microtime = time();
                $todo->save();
                $this->returnTime();
            }
        }else{
            $todo = new ToDo();
            $todo->user_id = 0;
            if (!Yii::$app->user->isGuest) {
                $todo->user_id = Yii::$app->user->id;
            }
            $todo->target = \Yii::$app->request->get('message');
            $todo->microtime = time();
            $todo->status = 0;
            $todo->save();
            if($todo->id) {
                if (!Yii::$app->user->isGuest) {
                    $rules = new TodoRules();
                    $rules->user_id = $todo->user_id;
                    $rules->todo_id = $todo->id;
                    $rules->edit = 1;
                    $rules->save();
                }
                $this->returnTime();
            }
        }
    }

    public function actionTimelist(){
        $this->isAjax();
        echo json_encode(array('time' => ToDo::find()->orderBy(['microtime'=>SORT_DESC])->one()->microtime));
    }

    public function actionList()
    {
        $this->isAjax();
        switch (\Yii::$app->request->get('type')){
            case 'Active':$status = '0';
                break;
            case 'Completed':$status = '1';
                break;
            default: $status = '0,1';

        }

        echo json_encode(array(
            'time' => ToDo::find()->orderBy(['microtime'=>SORT_DESC])->one()->microtime,
            'list' => ToDo::find()
                ->select(['id', 'target', 'status','edit','todo.user_id'])
                ->joinWith('todoRules')
                ->where($this->userCondition(false).sprintf(' AND status in(%s)', $status))
                ->orderBy(['microtime'=>SORT_DESC])
                ->asArray()
                ->all(),
            'left' => ToDo::find()
                ->select(['id', 'target'])
                ->joinWith('todoRules')
                ->where($this->userCondition().sprintf(' AND status = -1 ', $status))
                ->count()
        ));
    }

    public function actionRemove(){
        $this->isAjax();
        $model = $this->getTodo();
        if($model){
            $model->status = -1;
            $model->microtime = time();
            $model->save();
            $this->returnTime();
        }
    }


    public function actionUpdate(){
        $this->isAjax();
        $model = $this->getTodo();
        if($model && $model->status >=0){
            $model->status = \Yii::$app->request->get('status');
            $model->microtime = time();
            $model->save();
            $this->returnTime();
        }
    }

    public function actionUpdateall(){
        $list =  ToDo::find()
            ->select(['id', 'target', 'status'])
            ->joinWith('todoRules')
            ->where($this->userCondition().' AND status = 0')
            ->all();
        foreach ($list as $model){
            $model->status = 1;
            $model->microtime = time();
            $model->save();
        }
        $this->returnTime();
    }

    public function actionClear(){
        $list =  ToDo::find()
            ->select(['id', 'target', 'status'])
            ->joinWith('todoRules')
            ->where($this->userCondition().' AND status = 1')
            ->all();
        foreach ($list as $model){
            $model->status = -1;
            $model->microtime = time();
            $model->save();
        }
        $this->returnTime();
    }

    private function getTodo(){
        return ToDo::find()
            ->joinWith('todoRules')
            ->where($this->userCondition(). sprintf(' AND id = %d',\Yii::$app->request->get('id')))
            ->One();
    }

    private function isAjax(){
        if(!\Yii::$app->request->isAjax && !YII_ENV_DEV){
            exit('Error');
        }
    }

    private function returnTime(){
        echo json_encode(array('time' => microtime()));
    }

    private function userCondition($edit = true){
        if (Yii::$app->user->isGuest) {
            return ' todo.user_id = 0 ';
        }else{
            return sprintf(' todo_rules.user_id = %d ',Yii::$app->user->id).$edit?' edit = 1 ':'';
        }
    }
}