<?php

class Register extends Controller {
    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->view->setLayout('default');
    }

    public function loginAction() {
        $validation = new Validate();
        if($_POST) {
            // form validation
            $validation->check($_POST, [
                'username' => [
                    'display' => "Username",
                    'required' => true
                ],
                'password' => [
                    'display' => 'Password',
                    'required' => true,
                    'min' => 6
                ]
            ]);
            if($validation->passed()) {
                $user = $this->UsersModel->findByUsername($_POST['username']);
                // This if statement is producing error because it is trying to access an object
                //  property that won't be existing if findByUsername() return an object
                //  that doesn't have that property included.
                if($user && password_verify(Input::get('password'), $user->password)) {
                    $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                    $user->login($remember);
                    Router::redirect('');
                } else {
                    $validation->addError("There is an error with you username or password.");
                }
            }
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('register/login');
    }
}