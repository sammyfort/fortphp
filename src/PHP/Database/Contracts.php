<?php


namespace Fort\PHP;


use PDO;
use PDOException;
use Fort\PHP\Environment;

trait Contracts
{


    public function connection(){
        try {
            $handle = new PDO(
                "mysql:host=" . env('HOST') . ";dbname=" . env('DATABASE') .";charset=utf8mb4",
                env('USER'),
                env('PASSWORD'));
            $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $handle;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

}