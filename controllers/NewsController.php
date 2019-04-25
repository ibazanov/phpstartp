<?php

class NewsController
{
    public function actionIndex(){
        echo '<br>Список новостей';
        return true;
    }
    public function actionView(){
        echo '<br>Просмотр одной новости';
        return true;
    }
}