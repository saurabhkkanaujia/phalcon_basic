<?php

use Phalcon\Mvc\Controller;

class BlogController extends Controller
{
    public function indexAction() {
    
    }

    public function allBlogsAction() {
        if ($_SESSION['userData']['role'] == 'admin'){
            $this->view->data =  Blogs::find();
        } else {
            $this->view->data =  Blogs::find([
                'conditions' => 'user_email=:email:',
                'bind' => [
                    'email' => $_SESSION['userData']['email'],
                ]
            ]);
        }
    }

    public function alterBlogAction() {
        $postData = $this->request->getPost();
        if (isset($postData['approve'])) {
            $id = $postData['approve'];
            $blog = Blogs::findFirst($id);
            $blog->status="Approved";
            $blog->update();


        } elseif (isset($postData['restrict'])) {
            $id = $postData['restrict'];
            $blog = Blogs::findFirst($id);
            $blog->status="Not Approved";
            $blog->update();

        } elseif (isset($postData['deleteBlog'])) {
            $id = $postData['deleteBlog'];
            $blog = Blogs::findFirst($id);
            $blog->delete();
        } elseif (isset($postData['updateBlog'])) {
            $id = $postData['updateBlog'];
            $blog = Blogs::findFirst($id);
            $blog->title= $postData['title'];
            $blog->category= $postData['category'];
            $blog->description= $postData['description'];
            $blog->content= $postData['content'];
            $blog->update();
        }

        $this->dispatcher->forward(
            [
                'controller' => 'blog',
                'action' => 'allBlogs',
            ]
        );
    }

    public function addBlogAction()
    {
        $blog = new Blogs();

        $blog->assign(
            $this->request->getPost(),
            [
                'title',
                'category',
                'description',
                'content'
            ]
        );
        $blog->user_email = $_SESSION['userData']['email'];
        $success = $blog->save();

        $this->view->success = $success;

        if ($success) {
            $this->dispatcher->forward(
                [
                    'controller' => 'blog',
                    'action' => 'allBlogs',
                ]
            );
            $this->view->message = "Blog Added";
        } else {
            $this->view->message = "Blog Not Added succesfully due to following reason: <br>" . implode("<br>", $blog->getMessages());
        }
    }

    public function editBlogAction() {
        $id = $_GET['id'];
        $blog = Blogs::findFirst($id);
        $this->view->data= $blog;
    }
}
