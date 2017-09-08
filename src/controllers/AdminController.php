<?php

require_once 'src/dao/ContatoDAO.php';

/**
 * Description of AdminController
 *
 * @author tutocury
 */
class AdminController {

    public function __construct($httpMethod) {
        if ($httpMethod == "GET") {
            $this->showDashboard();
        } else {
            $this->showError();
        }
    }

    private function showDashboard() {
        $dao = new ContatoDAO();
        $contatosTotal = $dao->getTotal();

        $view = new View('src/views/dashboard.html');
        $view->setParams(array('total' => $contatosTotal));
        $view->showContents();
    }

    private function showError() {
        http_response_code(HTTPStatusCode::$METHOD_NOT_ALLOWED);
        //echo "Configurar uma página de erro bonita";
        $view = new View('src/views/error.html');
        $view->showContents();
    }

}
