<?php

class Conn {
    static private $inst = NULL;
    static function getPdo() : PDO
    {
        if (self::$inst == NULL) { //singleton
            $conn = new PDO("mysql:host=" . DB_A . ";charset=utf8;dbname=" . DB_N, DB_U, DB_P); //vytvoření Pdo connection, včetně UTF-8 pro fční CZ znak. sadu
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //režim výpisu chyb a vyjímek
            self::$inst = $conn;
        }
        return self::$inst;
    }
}