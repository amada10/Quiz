<?php
class ControllersAdd {
    public function users(string $prenom) {
        $infos = [
            'prenom' => strip_tags($prenom)
        ];
        $login = new LoginUser();
        $verif = $login -> authentifierUser($infos);
        if($verif['TRUE'] != '1'){
            $add = new Utilisateur();
            $add -> addUsers($infos);
            unset($add);
            $verif = $login -> authentifierUser($infos);
            $_SESSION['user'] = $verif;
        }
        else $_SESSION['user'] = $verif;
        unset($login);
        echo '1';
    }

    public function groupeQuest(string $enonce) {
        $infos = [
            'enonce' => strip_tags($enonce)
        ];
        $add = new GroupeQuest();
        $add -> addGroupeQuest($infos);
        unset($add);
        echo '1';
    }

    public function questions(string $identifiant, string $enonce) {
        $infos = [
            'id' => strip_tags($identifiant),
            'enonce' => strip_tags($enonce)
        ];
        $add = new Question();
        $add -> addQuestions($infos);
        unset($add);
        echo '1';
    }

    public function choix(string $identifiant, array $choix) {
        if(count($choix) > 0){
            $add = new Choix();
            foreach($choix as $data):
                $infos = [
                    'id' => strip_tags($identifiant),
                    'choix' => strip_tags($data)
                ];
                $add -> addChoix($infos);
            endforeach;
            unset($add);
            echo '1';
        }
    }
}
