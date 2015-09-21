<?php

include_once ROOT . '/app/models/News.php';

class NewsController{

    public function actionIndex(){
        $newsList = News::getNewsList();

        require_once(ROOT . '/app/views/news/newsListView.php');

        return true;
    }

    public function actionView($id){
        if($id){
            $newsItem = News::getNewsItemById($id);

            require_once(ROOT . '/app/views/news/newsItemView.php');
        }

        return true;
    }


}