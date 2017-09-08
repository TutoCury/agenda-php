<?php

/**
 * Classe responsável por carregar o conteúdo html
 * das views
 */
class View {

    /**
     * Armazena o conteúdo HTML
     * @var string
     */
    private $contents;

    /**
     * Armazena o nome do arquivo de visualização
     * @var string
     */
    private $view;

    /**
     * Armazena os dados que devem ser mostrados ao reenderizar o 
     * arquivo de visualização
     * @var Array
     */
    private $params;

    /**
     * É possivel efetuar a parametrização do objeto ao instanciar o mesmo,
     * $view é o nome do arquivo de visualização a ser usado e 
     * $params são os dados que devem ser utilizados pela camada de visualização
     * 
     * @param string $view
     * @param Array $params
     */
    function __construct($view = null, $params = null) {
        if ($view != null) {
            $this->setView($view);
        }
        $this->params = $params;
    }

    /**
     * Define qual arquivo html deve ser renderizado
     * @param string $view
     * @throws Exception
     */
    public function setView($view) {
        if (file_exists($view)) {
            $this->view = $view;
        } else {
            throw new Exception("View File '$view' don't exists");
        }
    }

    /**
     * Retorna o nome do arquivo que deve ser renderizado
     * @return string 
     */
    public function getView() {
        return $this->view;
    }

    /**
     * Define os dados que devem ser repassados à view
     * @param Array $params
     */
    public function setParams(Array $params) {
        $this->params = $params;
    }

    /**
     * Retorna os dados que foram ser repassados ao arquivo de visualização
     * @return Array
     */
    public function getParams() {
        return $this->params;
    }

    /**
     * Retorna uma string contendo todo 
     * o conteudo do arquivo de visualização
     * 
     * @return string
     */
    public function getContents() {
        ob_start();
        if (isset($this->view)) {
            require_once $this->view;
        }
        $this->contents = ob_get_contents();
        ob_end_clean();
        return $this->contents;
    }

    /**
     * Imprime o arquivo de visualização 
     */
    public function showContents() {
        echo $this->getContents();
        exit;
    }

}
