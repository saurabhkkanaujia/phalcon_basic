<?php

use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function indexAction()
    {
    }
    public function checkAction()
    {
        $postData = $this->request->getPost();

        $user = Users::find([
            'conditions' => 'email= :email: AND password = :password:',
            'bind' => [
                'email' => $postData['email'],
                'password' => $postData['password'],
            ]
        ]);
        if (count($user) == 0) {
            $this->dispatcher->forward(
                [
                    'controller' => 'login',
                    'action' => 'index',
                ]
            );
            $this->view->message = "Invalid Credentials";

        } else {
            $_SESSION['userData']['id'] = $user[0]->id;
            $_SESSION['userData']['name'] = $user[0]->name;
            $_SESSION['userData']['username'] = $user[0]->username;
            $_SESSION['userData']['email'] = $user[0]->email;
            $_SESSION['userData']['status'] = $user[0]->status;
            $_SESSION['userData']['role'] = $user[0]->role;
            if ($user[0]->status == 'Approved') {

                $this->dispatcher->forward(
                    [
                        'controller' => 'admin',
                        'action' => 'dashboard',
                    ]
                );
            } else {
                $this->dispatcher->forward(
                    [
                        'controller' => 'login',
                        'action' => 'index',
                    ]
                );
                $this->view->message = "Oops!!, You haven't been approved ";
            }
            
        }


    }
    
}
