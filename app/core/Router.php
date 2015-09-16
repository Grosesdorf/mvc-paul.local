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
        // �������� ������ �������
        $uri = $this->getUri();

        // ��������� ������� ������ ������� � routes.php
        foreach ($this->routers as $uriPattern => $path) {

            // ���������� $uriPattern & $path
            if(preg_match("~$uriPattern~", $uri)){
                // ���������� controller � action

                $element = explode("/", $path);

                $controllerName = ucfirst(array_shift($element) . 'Controller');
                $actionName = 'action' . ucfirst(array_shift($element));

                // ��������� ���� �����������
                $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';

                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }

                //������� ������, �������� action
                $controllerObject = new $controllerName;
                if($controllerObject->$actionName()){
                    break;
                }
            }
        }

    }
}