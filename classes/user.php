<?php
require_once "Database.php";

class User {
    private $db;
    public $id;
    public $email;
    public $role;
    public $balance;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $this->id = $user['id'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->balance = $user['balance'];
            return true;
        }
        return false;
    }

    public function register($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        if ($stmt->fetch()) return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, password_hash, role, balance) VALUES (:email, :hash, 'user', 1000)");
        $stmt->execute(['email'=>$email, 'hash'=>$hash]);

        $this->id = $this->db->lastInsertId();
        $this->email = $email;
        $this->role = 'user';
        $this->balance = 1000;
        return true;
    }

    public function updateBalance($newBalance) {
        $stmt = $this->db->prepare("UPDATE users SET balance=:balance WHERE id=:id");
        $stmt->execute(['balance'=>$newBalance, 'id'=>$this->id]);
        $this->balance = $newBalance;
    }
}
?>
