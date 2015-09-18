<?php

include_once ROOT . '/app/models/News.php';

class NewsController{

    public function actionIndex(){
        echo 'Список новостей';
        return true;
    }

    public function actionView($category, $id){
        echo '<br />'.$category;
        echo '<br />'.$id;
    }


}