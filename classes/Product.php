<?php
require_once "Database.php";

class Product {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIds(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(?string $category = null) {
        if ($category) {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE category = :category");
            $stmt->execute(['category' => $category]);
        } else {
            $stmt = $this->db->query("SELECT * FROM products");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data) {
        $stmt = $this->db->prepare("INSERT INTO products (name, price, category, description, image) 
                                    VALUES (:name, :price, :category, :description, :image)");
        $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'category' => $data['category'],
            'description' => $data['description'],
            'image' => $data['image']
        ]);
    }

    public function update(int $id, array $data) {
        $stmt = $this->db->prepare("UPDATE products 
                                    SET name=:name, price=:price, category=:category, description=:description, image=:image 
                                    WHERE id=:id");
        $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'category' => $data['category'],
            'description' => $data['description'],
            'image' => $data['image'],
            'id' => $id
        ]);
    }
    public function delete(int $id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=:id");
        $stmt->execute(['id' => $id]);
    }
}
?>
