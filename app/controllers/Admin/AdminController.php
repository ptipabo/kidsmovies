<?php

namespace App\controllers\Admin;

use App\controllers\Controller;

class AdminController extends Controller{
    public function index(){
        return $this->view('admin.index');
    }
}