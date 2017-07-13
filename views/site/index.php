<?php

/* @var $this yii\web\View */

$this->title = 'ToDO';
?>
<section class="todoapp">
    <header class="header">
        <h1>todos</h1>
        <input class="new-todo" placeholder="What needs to be done?" autofocus>
    </header>
    <section class="main">
        <input id="toggle-all" class="toggle-all" type="checkbox">
        <label for="toggle-all">Mark all as complete</label>
        <ul class="todo-list">
        </ul>
        <footer class="footer">
            <span class="todo-count"><strong>0</strong> item left</span>
            <ul class="filters">
                <li>
                    <a class="selected" href="#/">All</a>
                </li>
                <li>
                    <a href="#/active">Active</a>
                </li>
                <li>
                    <a href="#/completed">Completed</a>
                </li>
            </ul>
            <button class="clear-completed">Clear completed</button>
            <p>Double-click to edit a todo</p>
        </footer>
    </section>
</section>
<input id="info" type="hidden" data-type="All" data-time="0">

