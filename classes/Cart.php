<?php
class Cart {
    private $items;
    public function __construct(&$sessionCart) {
        $this->items = &$sessionCart;
    }

    public function add(int $productId) {
        if (!isset($this->items[$productId])) {
            $this->items[$productId] = 1;
        } else {
            $this->items[$productId]++;
        }
    }

    public function remove(int $productId) {
        if (isset($this->items[$productId])) {
            unset($this->items[$productId]);
        }
    }

    public function getItems(): array {
        return $this->items;
    }
}
