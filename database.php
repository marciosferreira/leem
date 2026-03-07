<?php
class database{

    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_base;
    private $db_port;

    private $conexao;

    public function __construct(){
        if (function_exists('mysqli_report')) {
            mysqli_report(MYSQLI_REPORT_OFF);
        }

        $this->db_host = getenv('LEEM_DB_HOST') ?: 'leem_db';
        $this->db_user = getenv('LEEM_DB_USER') ?: 'leemdxxp_leem';
        $this->db_pass = getenv('LEEM_DB_PASS') ?: '';
        $this->db_base = getenv('LEEM_DB_NAME') ?: 'leemdxxp_leem';
        $this->db_port = (int) (getenv('LEEM_DB_PORT') ?: 3306);

        $this->conexao = new mysqli(
            $this->db_host, 
            $this->db_user, 
            $this->db_pass, 
            $this->db_base,
            $this->db_port);

        if ($this->conexao instanceof mysqli && !$this->conexao->connect_errno) {
            @$this->conexao->set_charset('utf8mb4');
        }
    }

    public function get_conexao(){
        return $this->conexao;
    }

}
