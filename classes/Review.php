<?php
require_once "Database.php";

class Review {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function canReview($user_id, $product_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(['user_id'=>$user_id, 'product_id'=>$product_id]);
        return $stmt->fetch() !== false;
    }

    public function add($user_id, $product_id, $rating, $comment) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (:user_id, :product_id, :rating, :comment)"
        );
        $stmt->execute([
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'rating'=>$rating,
            'comment'=>$comment
        ]);
    }
}
?>
