<?php

/*
 * This is the model for home page
 * @author: Eric
 */

import('dao.Tag');

Class userPageModel extends ModelCore {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function make() {
        parent::make();
    }

    public function getUser() {
        if(empty($_SESSION['user'])) {
            goToUrl('/user/login');
        }
        else {
            return $_SESSION['user'];
        }
    }

    public function userLogout() {
        unset($_SESSION['user']);
        goToUrl('/');
    }

    public function userAction() {
        $requestData = $this->request->getSysRequest();

        $action = empty($requestData['action']) ? '' : $requestData['action'];
        if(!empty($action)) {
            switch ($action) {
                case 'login':
                    $name = $requestData['name'];
                    $pass = $requestData['pass'];

                    $user = User::authencate($name, $pass);

                    if(!empty($user)) {
                        // Save user to session
                        $_SESSION['user'] = $user;
                        $this->data['user'] = $user;

                        goToUrl('/user');
                    }
                    else {
                        $_SESSION['login_form_user_name'] = $name;
                        $_SESSION['login_error_msg'] = 'Failed to login! Wrong user name or password!';
                        goToUrl('/user/login');
                    }

                    break;

                case 'register':
                    $name = $requestData['name'];
                    $email = $requestData['mail'];
                    $pass = $requestData['pass']['pass1'];

                    $exist = User::getUserByName($name);
                    if(!empty($exist)) {
                        $_SESSION['register_form_user_name'] = $name;
                        $_SESSION['register_form_user_email'] = $email;
                        $_SESSION['register_error_msg'] = 'User name already exists!';
                        goToUrl('/user/register');
                    }
                    else {
                        $user = User::saveUser(null, $name, $email, $pass);

                        if(!empty($user)) {
                            // login user and goto user dashboard
                            // Save user to session
                            $_SESSION['user'] = $user;
                            $this->data['user'] = $user;

                            goToUrl('/user');
                        }
                        else {
                            $_SESSION['register_form_user_name'] = $name;
                            $_SESSION['register_form_user_email'] = $email;
                            $_SESSION['register_error_msg'] = 'Failed to register user! Please try later!';
                            goToUrl('/user/register');
                        }
                    }

                    break;
                case 'reset-pw':
                    break;
            }
        }
        else {
            if(!empty($_SESSION['user'])) {
                $this->data['user'] = $_SESSION['user'];

                $myFiles = File::getFilesByUserName($_SESSION['user']['name']);
                $this->data['user']['files'] = $myFiles;
            }
            else {
                goToUrl('/');
            }
        }
    }
}