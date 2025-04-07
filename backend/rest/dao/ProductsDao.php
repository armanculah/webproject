<?php
require_once 'BaseDao.php';

class ProductsDao extends BaseDao {

    public function __construct() {
        parent::__construct("products", "product_id");
    }

    public function getAllWithGender() {
        $stmt = $this->connection->prepare("
            SELECT p.*, g.gender_name 
            FROM products p
            JOIN genders g ON p.gender_id = g.gender_id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByName($product_name) {
        $stmt = $this->connection->prepare("SELECT * FROM products WHERE product_name = :name");
        $stmt->execute(['name' => $product_name]);
        return $stmt->fetch();
    }

    public function updateProduct($product_id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");

        $sql = "UPDATE products SET $fields WHERE product_id = :product_id";
        $stmt = $this->connection->prepare($sql);
        $data['product_id'] = $product_id;
        return $stmt->execute($data);
    }

    public function deleteProduct($product_id) {
        $stmt = $this->connection->prepare("DELETE FROM products WHERE product_id = :id");
        return $stmt->execute(['id' => $product_id]);
    }
}
