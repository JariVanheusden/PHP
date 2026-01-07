<?php
class Database {
    private $host = "localhost";
    private $dbname = "f1_shop";
    private $user = "root";
    private $pass = "";
    public $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
            $this->user,
            $this->pass
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}
?>
