<?php

/**
 * Classe abstrata para conexão com o banco
 * todos os DAOs herdam dela
 *
 * @author tutocury
 */
abstract class AbstractDAO {

    protected $conn;

    function __construct() {
        // Dados de conexão com MySQL
        $host = 'agenda-db';
        $banco = 'agendadb';
        $usuario = 'root';
        $senha = '';

        $this->conn = new PDO(
                "mysql:host=$host;dbname=$banco", $usuario, $senha);
    }

}
