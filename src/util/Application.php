<?php

function __autoload($class) {
    if (file_exists('src/util/' . $class . '.php')) {
        require_once 'src/util/' . $class . '.php';
    }
}

/**
 * Classe carrega a Aplicação
 * 
 * @author tutocury
 */
class Application {

    protected $method;
    protected $ctrl;

    private function loadRoute() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->ctrl = isset($_REQUEST['ctrl']) ? $_REQUEST['ctrl'] : 'Home';
    }

    public function dispatch() {
        $this->loadRoute();

        //verificando se o arquivo de controle existe
        $controller_file = 'src/controllers/' . $this->ctrl . 'Controller.php';
        if (file_exists($controller_file)) {
            require_once $controller_file;
        } else {
            throw new Exception('Arquivo ' . $controller_file . ' nao encontrado');
        }

        //verificando se a classe existe
        $class = $this->ctrl . 'Controller';
        if (class_exists($class)) {
            $classObj = new $class($this->method);
        } else {
            throw new Exception("Classe '$class' nao existe no arquivo '$controller_file'");
        }        
    }

    static function redirect($uri) {
        header("Location: $uri");
    }

}
