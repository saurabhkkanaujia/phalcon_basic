<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

    public function IndexAction()
    {
    }

    public function registerAction()
    {
        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'username',
                'email',
                'password'
            ]
        );

        $success = $user->save();

        $this->view->success = $success;

        if ($success) {
            $this->dispatcher->forward(
                [
                    'controller' => 'login',
                    'action' => 'index',
                ]
            );
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>" . implode("<br>", $user->getMessages());
        }
    }

    public function testAction()
    {
        // echo "nsandnaslnlnasd";
    }
}
