<?php

use Phalcon\Mvc\Model;

class Blogs extends Model 
{
    public $id;
    public $title;
    public $category;
    public $description;
    public $content;
    public $status;
}