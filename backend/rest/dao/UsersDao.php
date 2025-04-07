<?php
require_once 'BaseDao.php';

class UsersDao extends BaseDao {

    public function __construct() {
        parent::__construct("users", "user_id");
    }

    public function getUserByEmail($email) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getAllWithRoles() {
        $stmt = $this->connection->prepare("
            SELECT u.*, r.role_name 
            FROM users u 
            JOIN roles r ON u.role_id = r.role_id
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateCredentials($user_id, $email, $password) {
        $stmt = $this->connection->prepare("
            UPDATE users SET email = :email, password = :password WHERE user_id = :user_id
        ");
        return $stmt->execute([
            'email' => $email,
            'password' => $password,
            'user_id' => $user_id
        ]);
    }

    public function updateImage($user_id, $image_url) {
        $stmt = $this->connection->prepare("
            UPDATE users SET image_url = :img WHERE user_id = :uid
        ");
        return $stmt->execute([
            'img' => $image_url,
            'uid' => $user_id
        ]);
    }

    public function deleteUser($user_id) {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE user_id = :id");
        return $stmt->execute(['id' => $user_id]);
    }

}
