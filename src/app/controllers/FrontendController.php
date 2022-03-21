<?php

use Phalcon\Mvc\Controller;

class FrontendController extends Controller
{
    public function indexAction() {

    }
    public function homeAction() {
        $this->view->data =  Blogs::find([
            'conditions' => 'status= "Approved"'
        ]);
    }
    public function singleBlogAction() {
        $postData = $this->request->getPost();
        $id = $postData['singleBlog'];
        $blog = Blogs::find([
            'conditions' => 'id= :id:',
            'bind' => [
                'id' => $id,
            ]
        ]);
        $this->view->data= $blog;
    }
}
