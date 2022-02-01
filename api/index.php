<?php
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
require_once './models/models.php';
require_once './controllers/login.php';
require_once './controllers/getters.php';
require_once './controllers/adding.php';
require_once './controllers/delete.php';

try {
    if(!empty(trim($_GET['demande']))) {
        $url = explode('/', filter_var(strip_tags($_GET['demande']).'/'), FILTER_SANITIZE_URL);
        if(!empty(trim($url[0]))) {
            switch($url[0]) {
                case 'login':
                    if(!empty(trim($url[1]))) {
                        // $login = new ControllersLogin($_POST['identifiant'], $_POST['keyword']);
                        $login = new ControllersLogin('user1', 'dama');
                        switch($url[1]) {
                            case 'api-login':
                                $login -> apiLogin();
                            break;

                            case 'session-login':
                                $login -> sessionLogin();
                            break;
                            default: throw new Exception("Erreur: methode de login invalide !", http_response_code(1));                              
                        }
                        unset($login);
                    }
                    else throw new Exception("Erreur: demande login invalide !", http_response_code(1));
                break;
                case 'get':
                    if(!empty(trim($url[1]))) {
                        $get = new ControllersGet();
                        switch($url[1]) {
                            case 'admin':
                                $get -> admin();
                            break;

                            case 'users':
                                if(!empty(trim($url[2]))) {
                                    if($url[2] == '.') $get -> allUsers();
                                    elseif(preg_match("#^[a-zA-Z0-9._-]+@[a-z0-9]{2,7}\.[a-z]{2,4}$#", $url[2])) $get -> users($url[2]);
                                    else throw new Exception("Erreur: votre demande USERS n'existe pas", http_response_code(1));
                                }
                                else throw new Exception("Erreur: paramètre incomplètre 'get users' !", http_response_code(1));
                            break;

                            case 'groupe-questions':
                                if(!empty(trim($url[2]))) {
                                    if($url[2] == '.') $get -> allGroupeQuest();
                                    elseif(preg_match("#^[0-9]$#", $url[2])) $get -> groupeQuest($url[2]); 
                                    else throw new Exception("Erreur: votre demande GROUPE-QUEST n'existe pas", http_response_code(1));
                                    
                                }
                                else throw new Exception("Erreur: paramètre incomplètre 'get groupeQuest' !", http_response_code(1));
                            break;

                            case 'questions':
                                if(!empty(trim($url[2]))) {
                                    if($url[2] == '.') $get -> allQuestions();
                                    elseif(preg_match("#^[0-9]$#", $url[2])) $get -> questions($url[2]); 
                                    else throw new Exception("Erreur: votre demande QUESTIONS n'existe pas", http_response_code(1));
                                    
                                }
                                else throw new Exception("Erreur: paramètre incomplètre 'get questions' !", http_response_code(1));
                            break;

                            case 'choix':
                                if(trim($url[2]) !== '') {
                                    if($url[2] == '.') $get -> allChoix();
                                    elseif($url[2] == '1') $get -> choixByEtat(1);
                                    elseif($url[2] == '0') $get -> choixByEtat(0);
                                    else throw new Exception("Erreur: votre demande CHOIX n'existe pas", http_response_code(1));
                                }
                                else throw new Exception("Erreur: paramètre incomplètre 'get choix' !", http_response_code(1));
                            break;
                            default: throw new Exception("Erreur: paramètre invalide !", http_response_code(1));    
                        }
                        unset($get);
                    }
                    else throw new Exception("Erreur: demande get invalide !", http_response_code(1));
                break;

                case 'add':
                    
                break;

                case 'update':
                
                break;

                case 'delete':
                
                break;
                default: throw new Exception("", http_response_code(1));                
            }
        }
        else throw new Exception("Erreur: La demande est vide !", http_response_code(1));
    }
    else throw new Exception("Erreur: URL invalide !", http_response_code(1));
}
catch(Exception $e) {
    print_r(json_encode([
        'status' => false,
        'message' => $e -> getMessage(),
        'code' => $e -> getCode()
    ], JSON_FORCE_OBJECT));
}
