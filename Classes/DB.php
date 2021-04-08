<?php

namespace App\Classes;

use PDO;
use PDOException;

class DB {
    private string $server = 'localhost';
    private string $db = 'liva_api';
    private string $user = 'root';
    private string $passwd = '';

    private static ?PDO $dbInstance = null;

    /*
     * Static construct
     */
    public function __construct() {
        try {
            self::$dbInstance = new PDO("mysql:host=$this->server;dbname=$this->db;charset=utf8", $this->user, $this->passwd);
            self::$dbInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$dbInstance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch (PDOException $exeption) {
            echo $exeption->getMessage();
        }
    }

    /**
     * Return only one PDO  instance through the whole project.
     * @return PDO|null (instance) PDO|null
     */
    public static function getInstance(): ?PDO {
        if (null === self::$dbInstance) {
            new self();
        }
        return self::$dbInstance;
    }

    /**
     * Return sanitized string to have secure data to insert into the database.
     * @param $data
     * @return string
     */
    public static function sanitizeString($data): string {
        $data = strip_tags($data);
        $data = addslashes($data);
        return trim($data);
    }

    /**
     * Return sanitized int to have secure data to insert into the database.
     * @param $data
     * @return int
     */
    public static function sanitizeInt($data): int {
        return intval($data);
    }

    /**
     * we prevent letting other developers clone the object
     */
    public function __clone(){}
}