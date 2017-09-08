<?php

// Incluindo DAO e Model de Contato
require_once 'src/dao/ContatoDAO.php';
require_once 'src/models/Contato.php';

/**
 * Controller para a entidade Contato
 *
 * @author tutocury
 */
class ContatoController {

    public function __construct($httpMethod) {
        switch ($httpMethod) {
            case "GET":
                if (!isset($_GET['id'])) {
                    if (!isset($_GET['total'])) {
                        $this->listarContatos();
                    } else {
                        $this->totalPorCodigoAction();
                    }
                } else {
                    $this->formularioContato($_GET['id']);
                }
                break;
            case "POST":
                $this->salvarContato();
                break;
            case "PUT":
                $this->salvarContato($_REQUEST['id']);
                break;
            case "DELETE":
                $this->apagarContato($_REQUEST['id']);
                break;
            default:
                $this->showError();
        }
    }

    private function listarContatos() {
        $dao = new ContatoDAO();
        $contatos = $dao->findAll();

        $view = new View('src/views/contatos.html');
        $view->setParams(array('contatos' => $contatos));
        $view->showContents();
    }

    private function formularioContato($id = null) {
        $dao = new ContatoDAO();
        $contato = new Contato();

        //verificando se o id passado é valido
        if (Validator::isNumeric($id)) {
            //buscando dados do contato
            $contato = $dao->findById($id);
        }

        $view = new View('src/views/contato-form.html');
        $view->setParams(array('contato' => $contato, 'errors' => array()));
        $view->showContents();
    }

    private function salvarContato($id = null) {
        $requestBody = array();
        parse_str(file_get_contents("php://input"), $requestBody);
        $dao = new ContatoDAO();
        $contato = new Contato();

        // Seta os dados no contato
        $contato->setId($id);
        $contato->setNome(addslashes(strip_tags($requestBody['nome'])));
        $contato->setEmail(addslashes(strip_tags($requestBody['email'])));
        $contato->setTelefone(addslashes(strip_tags($requestBody['telefone'])));
        $contato->setCelular(addslashes(strip_tags($requestBody['celular'])));

        // Valida o Contato
        if ($contato->isValid()) {
            //salvando dados e redirecionando para a lista de contatos
            if ($dao->save($contato) > 0) {
                http_response_code(HTTPStatusCode::$OK);
            }
        } else {
            http_response_code(HTTPStatusCode::$BAD_REQUEST);
            echo json_encode($contato->getErrors(), JSON_PRETTY_PRINT);
        };
    }

    private function apagarContato($id = null) {
        if (Validator::isNumeric($id)) {
            $dao = new ContatoDAO();
            $dao->delete($id);
            $this->listarContatos();
        }
    }

    private function totalPorCodigoAction() {
        $dao = new ContatoDAO();
        $contatosPorCod = $dao->getTotalGroupedByTelefoneCod();
        echo json_encode($contatosPorCod, JSON_PRETTY_PRINT);
    }

    private function showError() {
        http_response_code(HTTPStatusCode::$METHOD_NOT_ALLOWED);
        $msg = "Método Http não permitido";
        $view = new View('src/views/error.html');
        $view->setParams(array('msg' => $msg));
        $view->showContents();
    }

}
