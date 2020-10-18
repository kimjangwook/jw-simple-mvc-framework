<?php

namespace App\Controllers;

class BaseController
{
    public $viewPath = '';
    public $params = [];
    public $data = [];

    public function __construct()
    {
        $this->params = $_REQUEST;
    }


    public function get() {}
    public function post() {}
}