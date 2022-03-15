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
            echo "failed";
        } else {
            echo "Success";
            echo $user[0]->email;
        }

        die();

        //return '<h1>Hello!!!</h1>';
    }
}
