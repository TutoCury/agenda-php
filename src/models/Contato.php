<?php

/**
 * Modelo da entidade Contato
 */
class Contato {

    private $id;
    private $nome;
    private $email;
    private $telefone;
    private $celular;
    private $errors = array();

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getCelular() {
        return $this->celular;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function isValid() {
        if (Validator::isEmpty($this->nome)) {
            $this->errors[] = "O nome é obrigatório";
        }
        if (Validator::hasMoreThanMaxLength($this->nome, 200)) {
            $this->errors[] = "O nome não pode ter mais de 200 caracteres";
        }
        if (Validator::isEmpty($this->email)) {
            $this->errors[] = "O email é obrigatório";
        }
        if (!Validator::isEmail($this->email)) {
            $this->errors[] = "Endereço de e-mail inválido";
        }
        if (Validator::isEmpty($this->telefone)) {
            $this->errors[] = "O telefone é obrigatório";
        }
        if (!Validator::isTelefone($this->telefone)) {
            $this->errors[] = "Número de telefone inválido";
        }
        if (Validator::isEmpty($this->celular)) {
            $this->errors[] = "O celular é obrigatório";
        }
        if (!Validator::isCelular($this->celular)) {
            $this->errors[] = "Número de celular inválido";
        }

        return (count($this->errors) == 0);
    }

    function getErrors() {
        return $this->errors;
    }

}
