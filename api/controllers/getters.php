<?php
class ControllersGet {
    
    public function admin() {
        $get = new Admin();
        $resultats = $get -> getAdmin();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allUsers() {
        $get = new Users();
        $resultats = $get -> getAllUsers();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function users(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Users();
        $resultats = $get -> getUsers($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function allDescriptions() {
        $get = new Descriptions();
        $resultats = $get -> getAllDescriptions();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function descriptions(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Descriptions();
        $resultats = $get -> getDescriptions($infos);
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

    public function allReponses() {
        $get = new Reponse();
        $resultats = $get -> getAllReponses();
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function reponses(string $identifiant) {
        $infos = [
            'identifiant' => strip_tags($identifiant)
        ];
        $get = new Reponse();
        $resultats = $get -> getReponses($infos);
        unset($get);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }
}
