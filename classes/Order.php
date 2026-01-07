<?php
require_once "Database.php";

class Order {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function create($user_id, $products) {
        $total = 0;
        foreach ($products as $p) {
            $total += $p['price'] * $p['quantity'];
        }

        foreach ($products as $p) {
            $stmt = $this->db->prepare(
                "INSERT INTO orders (user_id, product_id, quantity, total_price) 
                 VALUES (:user_id, :product_id, :quantity, :total_price)"
            );
            $stmt->execute([
                'user_id' => $user_id,
                'product_id' => $p['id'],
                'quantity' => $p['quantity'],
                'total_price' => $p['price'] * $p['quantity']
            ]);
        }

        return $total;
    }

    public function getByUser($user_id) {
        $stmt = $this->db->prepare(
            "SELECT o.*, p.name, p.image FROM orders o 
             JOIN products p ON o.product_id = p.id 
             WHERE o.user_id = :user_id ORDER BY o.created_at DESC"
        );
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}
?>
