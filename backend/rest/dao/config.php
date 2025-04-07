<?php
if (!class_exists('Database')) {
    class Database {
        private static $host = '127.0.0.1';
        private static $dbName = 'Aragon';
        private static $username = 'root';
        private static $password = '12345678';
        private static $connection = null;

        public static function connect() {
            if (self::$connection === null) {
                try {
                    self::$connection = new PDO(
                        "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                        self::$username,
                        self::$password,
                        [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                        ]
                    );
                } catch (PDOException $e) {
                    die("Connection failed: " . $e->getMessage());
                }
            }
            return self::$connection;
        }
    }
}
?>
