<?php
/**
 * Created by PhpStorm.
 * User: abc
 * Date: 2017/9/1
 * Time: 16:23
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Models;

class IndexController extends Controller {
    public function index()
    {
        return view('admin.index');
    }

}