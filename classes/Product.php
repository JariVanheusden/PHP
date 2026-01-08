<?php
require_once "Database.php";

class Product {
    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getByIds(array $ids): array {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(?string $category = null): array {
        if ($category) {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE category = :category");
            $stmt->execute(['category' => $category]);
        } else {
            $stmt = $this->db->query("SELECT * FROM products");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add(array $data): void {
    $stmt = $this->db->prepare(
        "INSERT INTO products (name, price, category, description, image) 
         VALUES (:name, :price, :category, :description, :image)"
    );

    $stmt->execute([
        'name' => $data['name'] ?? '',
        'price' => $data['price'] ?? 0,
        'category' => $data['category'] ?? '',
        'description' => $data['description'] ?? '',
        'image' => $data['image'] ?? ''
    ]);
}


    public function update(int $id, array $data): void {
        $stmt = $this->db->prepare(
            "UPDATE products 
             SET name=:name, price=:price, category=:category, description=:description, image=:image 
             WHERE id=:id"
        );

        $stmt->execute([
            'id' => $id,
            'name' => $data['name'] ?? '',
            'price' => $data['price'] ?? 0,
            'category' => $data['category'] ?? '',
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? ''
        ]);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id=:id");
        $stmt->execute(['id' => $id]);
    }
}
?>
