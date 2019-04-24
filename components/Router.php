<?php
/**
 * Created by PhpStorm.
 * User: ilabananov
 * Date: 2019-04-22
 * Time: 17:43
 */

class Router
{
    private $routers;

    public function __construct()
    {
        $routerPath = ROOT . '/config/routes.php';
        $this->routers = include($routerPath);
    }

    /*
     * Method return request string
     * @return string
     * */

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            //return trim($_SERVER['REQUEST_URI'],'/');
            return str_replace('/phpstartp/',NULL,$_SERVER['REQUEST_URI']);
        }
    }

    public function run()
    {
            $uri = $this->getUri();

            foreach ($this->routers as $uriPattern => $path){
                if (preg_match("~$uriPattern~",$uri)){
                    $segment = explode('/',$path);
                    $controllerName = array_shift($segment).'Controller';
                    $controllerName = ucfirst($controllerName);

                    $actionName = 'action'.ucfirst(array_shift($segment));

                    $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
                    if (file_exists($controllerFile)){
                        include_once ($controllerFile);
                    }
                    $controllerObject = new $controllerName;
                    $result = $controllerObject -> $actionName();
                    if ($result != null) {
                        echo "Упешно! ".$controllerName.'->'.$actionName;
                        break;
                    }
                }
            }
    }
}