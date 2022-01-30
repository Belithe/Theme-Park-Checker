<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/Controllers/UserController.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/DataHandlers/DataLoader.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/BaseHTML/DataHandlers/DataSaver.php';

    session_start();

    $UserController = new UserController();
    $loader = new DataLoader();
    $saver = new DataSaver();


    if(!empty($_POST['register'])) {
        //If not all fields are filled, return to login with a warning
        if (empty($_POST['username']) || empty($_POST['pass'])) {
            header("Location: ../Views/LoginView.php?eId=0");
        } else {
            //sanitize inputs
            $enteredUser = htmlspecialchars($_POST['username']);
            $enteredPass = htmlspecialchars($_POST['pass']);

            //If username does not exist yet, continue, if it does, return with warning
            if(!$loader->translateSelectMatchingUser($enteredUser)) {
                //encrypt input password
                $cryptPass = md5($enteredPass);

                //Create a new user in the db, and check if it has succeeded
                if($saver->createNewUser($enteredUser, $cryptPass) && $saver->createNewVisitedSetting($loader->translateGetUserIdByName($enteredUser))) {
                    header("Location: ../Views/LoginView.php?newReg=true");
                } else {
                    var_dump(loader->translateGetUserIdByName($enteredUser));
                    //header("Location: ../Views/LoginView.php?eId=2");
                }
            } else {
                header("Location: ../Views/LoginView.php?eId=3");
            }

        }
    }

    else if (!empty($_POST['login'])) {
        //If not all fields are filled, return to login with a warning
        if (empty($_POST['username']) || empty($_POST['pass'])) {
            header("Location: ../Views/LoginView.php?eId=0");
        } else {
            //sanitize inputs
            $enteredUser = htmlspecialchars($_POST['username']);
            $enteredPass = htmlspecialchars($_POST['pass']);

            //create array from db user variables
            $userParamsArray = $loader->translateSelectMatchingUser($enteredUser);

            if (!empty($userParamsArray)) {
                //Convert 1 entry array of arrays into simply a single array
                $userParams = $userParamsArray[0];

                //create a user based on the gotten variables
                $dbUser = $UserController->CreateUserObject($userParams['id'], $userParams['username'], $userParams['password']);

                //validate encrypted password
                if ($dbUser->getPassword() == md5($enteredPass)) {
                    //validated :)
                    //Load user's settings and go to the home screen
                    $UserController->CreateUserSession($dbUser->getId(), $dbUser->getUsername());
                    header("Location: ../Views/HomeView.php");
                } else {
                    //return with a warning if pass invalid
                    header("Location: ../Views/LoginView.php?eId=1");
                }

            } else {
                //return with a warning if entered username is invalid
                header("Location: ../Views/LoginView.php?eId=1");
            }
        }
    }

    else {
        //return with a warning if Auth was somehow called without a post request
        header("Location: ../Views/LoginView.php?eId=2");
    }

?>