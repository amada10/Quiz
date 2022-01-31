<?php
// *************************** CONNECTION À LA BASE DE DONNÉES ***************************
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

class Admin extends Database {
    public function getAdmin():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, NOM FROM ADMINISTRATEUR');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Admin' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
    }
}

class LoginAdmin extends Database {
    public function authentifierAdmin(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT True, ID, NOM
                FROM ADMINISTRATEUR
                WHERE NOM = :nom AND MDP = SHA2(:keyword, 256)');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;

        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pu obtenir l'authentification Admin !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
    }
}

class Users extends Database {
    // ******************** PRENDRE TOUS LES USERS ****************************
    public function getAllUsers():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, NOM, PRENOM, EMAIL, SCORE
                FROM USERS
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Users Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
    }

    // *********************** PRENDRE UN USER *******************************
    public function getUsers(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT ID, NOM, PRENOM, EMAIL, SCORE
                FROM USERS
                WHERE ID = :identitifiant OR PRENOM = :identifiant OR EMAIL = :identifiant
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Nous n'avons pas pu obtenir 'Users' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
    }
}
