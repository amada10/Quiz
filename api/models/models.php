<?php
    abstract class Database {
        private $host = process.env.HOST;
        private $database = process.env.DB_NAME;
        private $user = process.env.DB_USER;
        private $password = process.env.DB_PASSWORD;

        protected function db_connect():object {
            try {
                return new PDO('mysql:host='.$this -> host.'; dbname='.$this -> database.'; charset=utf8',
                    $this -> user, $this -> password,
                    array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION));
            }
            catch(PDOException $e) {
                print_r(json_encode([
                    'status' => false,
                    'message' => "Erreur: nous n'avons pas pu connecter à la base de données !".$e -> getMessage()
                ], JSON_FORCE_OBJECT));
            }
        }
    }
