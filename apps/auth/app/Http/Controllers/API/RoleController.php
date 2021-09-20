<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

/**
 * @property string model
 */
class RoleController extends Controller
{
    public function __construct() {
        $this->model = Role::class;
    }

    public function getRoles() {

    }
}
