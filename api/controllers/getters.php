<?php
class ControllersGet {
    public function admin() {
        $get = new Administrateur;
        $resultats = $get -> getAdmin();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allUsers() {
        $get = new Utilisateur();
        $resultats = $get -> getAllUsers();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function users(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Utilisateur();
        $resultats = $get -> getUsers($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allGroupeQuest() {
        $get = new GroupeQuest();
        $resultats = $get -> getAllGroupeQuest();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function groupeQuest(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new GroupeQuest();
        $resultats = $get -> getGroupeQuest($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allQuestions() {
        $get = new Question();
        $resultats = $get -> getAllQuestions();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function questions(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Question();
        $resultats = $get -> getQuestions($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allChoix() {
        $get = new Choix();
        $resultats = $get -> getAllChoix();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function choixByEtat(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Choix();
        $resultats = $get -> getByEtatChoix($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    // public function allReponses() {
    //     $get = new Reponse();
    //     $resultats = $get -> getAllReponses();
    //     unset($get);
    //     print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    // }

    // public function reponses(string $identifiant) {
    //     $infos = [
    //         'identifiant' => strip_tags($identifiant)
    //     ];
    //     $get = new Reponse();
    //     $resultats = $get -> getReponses($infos);
    //     unset($get);
    //     print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    // }
}
