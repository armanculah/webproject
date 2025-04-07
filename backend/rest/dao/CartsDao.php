<?php
require_once 'BaseDao.php';

class CartsDao extends BaseDao {
    public function __construct() {
    
        parent::__construct("carts", "cart_id");
    }

    public function getCartByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function removeFromCart($userId, $productId) {
        $stmt = $this->connection->prepare("DELETE FROM carts WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function updateCartQuantity($userId, $productId, $quantity) {
        $stmt = $this->connection->prepare("UPDATE carts SET cart_quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function clearCart($userId) {
        $stmt = $this->connection->prepare("DELETE FROM carts WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
}
?>
