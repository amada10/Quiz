<?php
class ControllersAdd {
    public function users(string $prenom, string $nom = "", string $email = "", string $mdp = "") {
        $infos = [
            'nom' => strip_tags($nom),
            'prenom' => strip_tags(ucwords($prenom)),
            'email' => strip_tags($email),
            'mdp' => $mdp
        ];
        $add = new Utilisateur();
        $add -> addUsers($infos);
        unset($add);
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
