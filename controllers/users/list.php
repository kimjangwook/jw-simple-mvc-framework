<?php

namespace App\Controllers\Users;

use App\Controllers\BaseController;
use App\Model\User;

class UsersListController extends BaseController
{
    public function get()
    {
        $users = (new User())->getAll();
        $this->data['users'] = $users;
    }
}