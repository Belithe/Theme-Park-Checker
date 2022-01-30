<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/DataHandlers/DataLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/DataHandlers/DataSaver.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/Controllers/ParkController.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . 'BaseHTML/Models/User.php';

    class UserController {
        protected $loader;
        protected $saver;

        protected $ParkController;

        function __construct() {
            $this->ParkController = new ParkController();

            $this->loader = new DataLoader();
            $this->saver = new DataSaver();
        }

        public function CreateUserSession($id, $name) {

            //set global user variables
            $_SESSION['loggedInUsername'] = $name;
            $_SESSION['loggedInUserId'] = $id;

            $savedSettings = $this->loader->translateGetVisitedSettings($id);


            if(!isset($_SESSION['checked'])) {
                $this->ParkController->fillSessionChecked();
            }

            //Go through each siteside park entry
            foreach($_SESSION['checked'] as $key => $bool) {

                //Go through every dbside entry under the given userid
                foreach($savedSettings as $setting) {
                    print_r($setting);
                    //If the site's park and the db's park are the same, continue
                    if($setting['parkid'] == substr($key, 0, 1)) {
                        //Set the value as checked if the user has it marked as visited, and not if they don't
                        if ($setting['visited'] == 1) {
                            $_SESSION['checked'][$key] = 1;
                        } else {
                            $_SESSION['checked'][$key] = 0;
                        }
                    }
                }
            }
        }

        public function CreateUserObject($id, $username, $pass) {
            // Simple function to create a new user object if this is needed
            return new User($id, $username, $pass);
        }

        public function SaveCurrentSession() {
            //check if the home page has a save request
            if (!empty($_POST["Save"])) {
                //go through every known park entry
                foreach($_SESSION['checked'] as $key => $bool) {
                    //check the save request's contents, if yes mark it, if no don't
                    if(isset($_POST[$key])) {
                        $_SESSION['checked'][$key] = 1;
                    } else {
                        $_SESSION['checked'][$key] = 0;
                    }
                }

                //If a user is logged in, attempt to save the session, if not end
                if(!empty($_SESSION["loggedInUserId"])) {
                    return $this->saver->saveVisitedSettings($_SESSION['loggedInUserId'], $_SESSION['checked']);
                } else {
                    return true;
                }

            }
        }
    }
?>