<?php

/**
 * Controller para a Home da Agenda
 *
 * @author tutocury
 */
class HomeController {
    
    public function __construct($httpMethod) {
        if($httpMethod == "GET") {
            $this->showHome();
        } else {
            $this->showError();
        }
    }

    private function showHome() {
        $view = new View('src/views/home.html');
        $view->showContents();
    }
    
    private function showError() {
        http_response_code(HTTPStatusCode::$METHOD_NOT_ALLOWED);
        $msg = "Método Http não permitido";
        $view = new View('src/views/error.html');
        $view->setParams(array('msg' => $msg));
        $view->showContents();
    }

}
