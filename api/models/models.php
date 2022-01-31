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
        $database = null;
    }

    public function updateAdmin(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE ADMINISTRATEUR
                SET NOM = :nom, MDP = SHA2(:keyword, 256)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jour 'ADMINISTRATEUR' !".$e -> getMessage()
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
            $demande -> execute($donnees);
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
        $database = null;
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
        $database = null;
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
        $database = null;
    }

    public function addUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO USERS (NOM, PRENOM, EMAIL)
                VALUES(:nom, :prenom, :email)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'Users' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function updateUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE USERS 
                SET SCORE = :score
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jours 'Users' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM USERS WHERE ID = :identifiant');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu supprimer 'Users' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}

class Descriptions extends Database {
    // ************************* PRENDRE TOUTES LES DESCRIPTIONS **************************
    public function getAllDescriptions():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, ENONCE
                FROM DESCRIPTIONS
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Descriptions Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function getDescriptions(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT ID, ENONCE
                FROM DESCRIPTIONS
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Descriptions' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addDescriptions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO DESCRIPTIONS(ENONCE)
                VALUES(:enonce)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'Descriptions' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function updateDescriptions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE DESCRIPTIONS
                SET ENONCE = :enonce
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jour 'Descriptions' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteDescriptions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM DESCRIPTIONS WHERE ID = :identifiant');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu supprimer 'Descriptions' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}

class Question extends Database {
    public function getAllQuestions():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, ENONCE
                FROM QUESTION
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Questions Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function getQuestions(array $donnees): array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT ID, ENONCE
                FROM QUESTION
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Questions' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addQuestions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO QUESTION(ENONCE)
                VALUES(:enonce)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas ajouter dans 'Question' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function updateQuestions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE QUESTION 
                SET ENONCE = :enonce 
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jour dans 'Question' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteQuestions(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM QUESTION WHERE ID = :identifiant');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu supprimer dans 'Question' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}

class Reponse extends Database {

    public function getAllReponses():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT R.ID, R.REPONSE, R.ID_QUESTION, Q.ENONCE
                FROM REPONSE R
                JOIN QUESTION Q ON R.ID_QUESTION = Q.ID
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Reponse Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function getReponses(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT R.ID, R.REPONSE, R.ID_QUESTION, Q.ENONCE
                FROM REPONSE R
                JOIN QUESTION Q ON R.ID_QUESTION = Q.ID
                WHERE Q.ID = :identifiant
            ');
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Reponse' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addReponses(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO REPONSE (REPONSE, ID_QUESTION)
                VALUES(:reponse, :identifiant)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'Reponse' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function updataReponses(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE REPONSE 
                SET REPONSE = :reponse, ID_QUESTION = :identifiant
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jour 'Reponse' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteReponses(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM REPONSE WHERE ID = :identifiant');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu supprimer 'Reponse' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}
