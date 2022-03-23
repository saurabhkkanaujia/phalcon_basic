<?php

use Phalcon\Mvc\Controller;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class AdminController extends Controller
{
    public function indexAction()
    {
    }

    public function dashboardAction()
    {
        if (isset($_SESSION['userData'])) {
            $this->view->userData = Users::find(
                [
                    'order' => 'id DESC',
                    'limit' => 5,
                ]
            );
            $this->view->blogData = Blogs::find(
                [
                    'order' => 'id DESC',
                    'limit' => 5,
                ]
            );
            
        } else {
            $this->response->redirect('login');
        }
    }

    public function allUsersAction()
    {
        // $this->view->data =  Users::find();
        if (isset($_SESSION['userData']) && $_SESSION['userData']['role'] == 'admin') {
            $toSearch = $this->request->getPost();
            if ($_SESSION['userData']['role'] == 'admin') {
                $currentPage = $this->request->getQuery('page', 'int', 1);
                $paginator   = new PaginatorModel(
                    [
                        'model'  => Users::class,
                        "parameters" => [
                            "id LIKE '%" . $toSearch['searchField'] . "%' OR name LIKE '%" . $toSearch['searchField'] . "%' OR username LIKE '%" . $toSearch['searchField'] . "%' OR email LIKE '%" . $toSearch['searchField'] . "%'",

                            "order" => "id"
                        ],
                        'limit' => 5,
                        'page'  => $currentPage,
                    ]
                );

                $page = $paginator->paginate();

                $this->view->setVar('page', $page);
            } else {
                $data = ['message' => "Action Prohibited!. Please Signin as admin.."];
                $this->response->redirect('login', $data);
            }
        } else {
            $this->response->redirect('login');
        }
    }

    public function alterUserAction()
    {

        $postData = $this->request->getPost();
        if (isset($postData['approve'])) {
            $id = $postData['approve'];
            $user = Users::findFirst($id);
            $user->status = "Approved";
        } elseif (isset($postData['restrict'])) {
            $id = $postData['restrict'];
            $user = Users::findFirst($id);
            $user->status = "Not Approved";
        } elseif (isset($postData['deleteUser'])) {
            $id = $postData['deleteUser'];
            $user = Users::findFirst($id);
            $user->delete();
        }
        $user->update();

        $this->dispatcher->forward(
            [
                'controller' => 'admin',
                'action' => 'allUsers',
            ]
        );
    }
}
