<?php

/**
 * Classe de acesso aos dados da tabela contato
 *
 * @author tutocury
 */
class ContatoDAO extends AbstractDAO {

    public function __construct() {
        parent::__construct();
        $this->createTable();
    }

    public function findAll($nome = null) {
        if (!is_null($nome)) {
            $query = "SELECT * FROM contato WHERE nome LIKE '%$nome%';";
        } else {
            $query = 'SELECT * FROM contato;';
        }

        $contatos = array();
        try {
            $rs = $this->conn->query($query);
            while ($row = $rs->fetchObject()) {
                $contato = new Contato();
                $contato->setId($row->id);
                $contato->setNome($row->nome);
                $contato->setEmail($row->email);
                $contato->setTelefone($row->telefone);
                $contato->setCelular($row->celular);
                array_push($contatos, $contato);
            }
        } catch (PDOException $e) {
            throw $e;
        }
        return $contatos;
    }

    public function findById($id) {
        $contato = new Contato();
        $query = "SELECT * FROM contato WHERE id = $id;";
        $rs = $this->conn->query($query);
        $row = $rs->fetchObject();
        $contato->setId($row->id);
        $contato->setNome($row->nome);
        $contato->setEmail($row->email);
        $contato->setTelefone($row->telefone);
        $contato->setCelular($row->celular);
        return $contato;
    }

    public function save($contato = null) {
        if (is_null($contato)) {
            return false;
        }

        if (is_null($contato->getId())) {
            $query = "
                INSERT INTO contato
                (
                    nome,
                    email,
                    telefone,
                    celular
                )
                VALUES
                (
                    '{$contato->getNome()}',
                    '{$contato->getEmail()}',
                    '{$contato->getTelefone()}',
                    '{$contato->getCelular()}'
                );
            ";
        } else {
            $query = "
                UPDATE
                    contato
                SET
                    nome = '{$contato->getNome()}',
                    email = '{$contato->getEmail()}',
                    telefone = '{$contato->getTelefone()}',
                    celular = '{$contato->getCelular()}'
                WHERE
                    id = {$contato->getId()}
            ";
        }

        try {
            if ($this->conn->exec($query) > 0) {
                if (is_null($contato->getId())) {
                    return $this->conn->lastInsertId();
                } else {
                    return $contato->getId();
                }
            }
        } catch (PDOException $e) {
            throw $e;
        }
        return false;
    }

    public function delete($id) {
        if (!is_null($id)) {
            $query = "DELETE FROM contato WHERE id = $id";
            if ($this->conn->exec($query) > 0) {
                return true;
            }
        }
        return false;
    }

    public function getTotal() {
        $query = "SELECT count(*) AS total FROM contato";
        $rs = $this->conn->query($query);
        $row = $rs->fetchObject();
        return (int) $row->total;
    }

    public function getTotalGroupedByTelefoneCod() {
        $query = "
            SELECT 
                LPAD(telefone,4,'') as cod,
                COUNT(*) as total
            FROM contato
            GROUP BY LPAD(telefone,4,'')
        ";

        $result = array();
        $codigos = array();
        $totais = array();
        try {
            $rs = $this->conn->query($query);
            while ($row = $rs->fetchObject()) {
                array_push($codigos, $row->cod);
                array_push($totais, $row->total);
            }
            $result = array('codigos' => $codigos, 'totais' => $totais);
        } catch (PDOException $e) {
            throw $e;
        }

        return $result;
    }

    private function createTable() {
        $query = "
            CREATE TABLE IF NOT EXISTS contato
            (
                id INTEGER NOT NULL AUTO_INCREMENT,
                nome VARCHAR(200),
                email VARCHAR(100),
                telefone VARCHAR(14),
                celular VARCHAR(16),
                PRIMARY KEY(id)
            )
        ";

        try {
            $this->conn->exec($query);
        } catch (PDOException $e) {
            throw $e;
        }
    }

}
