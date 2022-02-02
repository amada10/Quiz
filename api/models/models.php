<?php
// *************************** CONNECTION À LA BASE DE DONNÉES ***************************
abstract class Database {
    private $host = 'localhost';
    private $database = 'quiz';
    private $user = 'jitiy';
    private $password = '01Lah_tr*@ro0t/*';

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

class Administrateur extends Database {
    public function getAdmin():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, PSEUDO FROM ADMINISTRATEUR');
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
                SET PSEUDO = :nom, MDP = SHA2(:keyword, 256)
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
    public function authentifierAdmin(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT True, ID, PSEUDO
                FROM ADMINISTRATEUR
                WHERE PSEUDO = :identifiant AND MDP = SHA2(:keyword, 256)');
            $demande -> execute($donnees);
            $reponses = $demande -> fetch(PDO::FETCH_ASSOC);
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

class LoginUser extends Database {
    public function authentifierUser(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT True, ID, PRENOM
                FROM UTILISATEUR
                WHERE PRENOM = :prenom
            ');
            $reponses = $demande -> fetch();
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pu obtenir l'authentification Users !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}
class Utilisateur extends Database {
    // ******************** PRENDRE TOUS LES USERS ****************************
    public function getAllUsers():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, NOM, PRENOM, EMAIL
                FROM UTILISATEUR
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Utilisateur Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    // *********************** PRENDRE UN USER *******************************
    public function getUsers(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT ID, NOM, PRENOM, EMAIL
                FROM UTILISATEUR
                WHERE ID = :identifiant 
                OR (EMAIL = :identifiant OR SOUNDEX(:identifiant) = SOUNDEX(EMAIL))
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Nous n'avons pas pu obtenir 'Utilisateur' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO UTILISATEUR (PRENOM)
                VALUES(:prenom)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'Utilisateur' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
    
    public function updateUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE UTILISATEUR
                SET NOM = :nom, PRENOM = :prenom, EMAIL = :email, MDP = SHA2(:keyword, 256)
                WHERE ID = :identifiant
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu mettre à jours 'Utilisateur' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteUsers(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM UTILISATEUR WHERE ID = :identifiant');
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

class GroupeQuest extends Database {
    // ************************* PRENDRE TOUTES LES DESCRIPTIONS **************************
    public function getAllGroupeQuest():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT ID, ENONCE
                FROM GROUPEQUEST
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'GroupeQuest Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function getGroupeQuest(array $donnees):array {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT ID, ENONCE
                FROM GROUPEQUEST
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
                'message' => "Erreur: nous n'avons pas pu obtenir 'GroupeQuest' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addGroupeQuest(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO GROUPEQUEST(ENONCE)
                VALUES(:enonce)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'GroupeQuest' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function updateGroupeQuest(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('UPDATE GROUPEQUEST
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
                'message' => "Erreur: nous n'avons pas pu mettre à jour 'GroupeQuest' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function deleteGroupeQuest(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('DELETE FROM GROUPEQUEST WHERE ID = :identifiant');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu supprimer 'GroupeQuest' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}

class Question extends Database {

    public function getAllQuestions():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT Q.ID, Q.ENONCE AS ENONCE_QUESTION, Q.IDGROUPEQUEST, G.ENONCE AS ENONCE_GROUPEQUEST,
                FROM QUESTION Q
                JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID
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
            $demande = $database -> prepare('SELECT Q.ID, Q.ENONCE AS ENONCE_QUESTION, Q.IDGROUPEQUEST, G.ENONCE AS ENONCE_GROUPEQUEST,
            FROM QUESTION Q
            JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID
            WHERE G.ID = :identifiant
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
            $demande = $database -> prepare('INSERT INTO QUESTION(IDGROUPEQUEST, ENONCE)
                VALUES(:id, :enonce)
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
                SET IDGROUPEQUEST = :id, ENONCE = :enonce 
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

class Choix extends Database {

    public function getAllChoix() {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT C.ID, G.ENONCE AS ENONCE_GROUPEQUEST, C.IDQUESTION, Q.ENONCE AS ENONCE_QUESTION, C.CHOIX, C.ETAT
                FROM CHOIX C
                JOIN QUESTION Q ON C.IDQUESTION = Q.ID
                JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID
                GROUP BY C.IDQUESTION ASC
            ');
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Choix Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function getByEtatChoix(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('SELECT C.ID, G.ENONCE AS ENONCE_GROUPEQUEST, C.IDQUESTION, Q.ENONCE AS ENONCE_QUESTION, C.CHOIX, C.ETAT
                FROM CHOIX C
                JOIN QUESTION Q ON C.IDQUESTION = Q.ID
                JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID
                WHERE C.ETAT = :identifiant
                GROUP BY C.IDQUESTION ASC
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
        }
        catch(PDOException $e) {
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu obtenir 'Choix Tout' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }

    public function addChoix(array $donnees) {
        try {
            $database = Database::db_connect();
            $demande = $database -> prepare('INSERT INTO CHOIX (IDQUESTION, CHOIX, ETAT)
                VALUES(:id, :choix, 0)
            ');
            $demande -> execute($donnees);
            $database -> commit();
        }
        catch(PDOException $e) {
            $database -> rollBack();
            print_r(json_encode([
                'status' => false,
                'message' => "Erreur: nous n'avons pas pu ajouter dans 'Choix' !".$e -> getMessage()
            ], JSON_FORCE_OBJECT));
        }
        $database = null;
    }
}

class Reponse extends Database {

    public function getAllReponses():array {
        try {
            $database = Database::db_connect();
            $demande = $database -> query('SELECT R.ID, R.IDUTILISATEUR, U.PRENOM, R.IDCHOIX, C.CHOIX, C.ETAT,
                C.IDQUESTION, Q.ENONCE AS ENONCE_GROUPEQUEST, Q.IDGROUPEQUEST, G.ID, G.ENONCE AS ENONCE_GROUPEQUEST
                FROM REPONSE R
                JOIN UTILISATEUR U ON R.IDUTILISATEUR = U.ID
                JOIN CHOIX C ON R.IDCHOIX = C.ID
                JOIN QUESTION Q ON C.IDQUESTION = Q.ID
                JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID

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
            $demande = $database -> prepare('SELECT R.ID, R.IDUTILISATEUR, U.PRENOM, R.IDCHOIX, C.CHOIX, C.ETAT,
                C.IDQUESTION, Q.ENONCE AS ENONCE_GROUPEQUEST, Q.IDGROUPEQUEST, G.ID, G.ENONCE AS ENONCE_GROUPEQUEST
                FROM REPONSE R
                JOIN UTILISATEUR U ON R.IDUTILISATEUR = U.ID
                JOIN CHOIX C ON R.IDCHOIX = C.ID
                JOIN QUESTION Q ON C.IDQUESTION = Q.ID
                JOIN GROUPEQUEST G ON Q.IDGROUPEQUEST = G.ID
                WHERE Q.ID = :identifiant
            ');
            $demande -> execute($donnees);
            $reponses = $demande -> fetchAll(PDO::FETCH_ASSOC);
            $demande -> closeCursor();
            return $reponses;
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
            $demande = $database -> prepare('INSERT INTO REPONSE (IDUTILISATEUR, IDCHOIX)
                VALUES(:id_utilisateur, :id_choix)
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
