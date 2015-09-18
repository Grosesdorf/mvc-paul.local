<?php

class Router{
    private $routers;

    public function __construct(){
        $routesPath = ROOT . '/app/config/routes.php';
        $this->routers = include($routesPath);
    }

    /**
     * Returns request string
     * @return string
     */
    private function getUri(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){
        // Получаем строку запроса
        $uri = $this->getUri();

        // Проверяем наличие такого запроса в routes.php
        foreach ($this->routers as $uriPattern => $path) {

            // Сравниваем $uriPattern & $path
            if(preg_match("~$uriPattern~", $uri)){

                // Получаем внутренний путь из внешнего
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
//                echo $internalRoute;

                // Определяем controller и action

                $element = explode("/", $internalRoute);

                $controllerName = ucfirst(array_shift($element) . 'Controller');
                $actionName = 'action' . ucfirst(array_shift($element));

                $parameters = $element;
//                echo '<pre>';
//                print_r($parameters);

                // Подкючаем файл контроллера
                $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }

                //Создаем объект, вызываем action
                $controllerObject = new $controllerName;

                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

//                if($controllerObject->$actionName()){
//                    break;
//                }
            }
        }

    }
}