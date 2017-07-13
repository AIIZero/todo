<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="css/app.css?v=<? echo time();?>">
    </head>
    <body>
    <?= $content ?>
    <footer class="info">
        <p>
            <?php  if (Yii::$app->user->isGuest){ ?>
                <a href="/?r=site/signup">Registration</a> <a  href="/?r=site/login">Login</a>
            <?php }else{?>
                <?php echo Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                            'Logout (' . Yii::$app->user->identity->username . ')',
                            ['class' => 'btn btn-link logout'])
                            . Html::endForm(); ?>

            <?php }?>
        </p>
        <p>Created by <a href="http://todomvc.com">Sergey</a></p>
        <p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Scripts here. Don't remove ↓ -->
    <script src="node_modules/todomvc-common/base.js"></script>
    <script src="js/app.js?v=<? echo time();?>"></script>
    <div id="message"></div>
    </body>
    </html>
<?php $this->endPage() ?>