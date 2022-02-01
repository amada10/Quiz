<?php
session_start();
class ControllersLogin {
    private array $data;
    public function __construct(string $identifiant, string $keyword) {
        $this -> data = [
            'identifiant' => strip_tags($identifiant),
            'keyword' => $keyword
        ];
    }

    public function apiLogin() {
        $login = new LoginAdmin();
        $resultats = $login -> authentifierAdmin($this -> data);
        unset($login);
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }

    public function sessionLogin() {
        $login = new LoginAdmin();
        $resultats = $login -> authentifierAdmin($this -> data);
        unset($login);
        $_SESSION['infos'] = $resultats;
        print_r(json_encode($resultats, JSON_FORCE_OBJECT));
    }
}
