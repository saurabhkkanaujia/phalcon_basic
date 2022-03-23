<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        // $this->view->users = Users::find();
        // echo "jhsvdjvjsvd";
    }

    public function signOutAction() {
        session_destroy();
        $this->response->redirect('login/');
        // $this->dispatcher->forward(
        //     [
        //         'controller' => 'login',
        //         'action' => 'index',
        //     ]
        // );
    }
}
