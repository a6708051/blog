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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsersNew;

class LoginController extends Controller {
    use AuthenticatesUsersNew;
    public function index()
    {
        if (Auth::check()) {
            return redirect('/admin/article');
        }
        return view('admin.login');
    }

    public function checkAccount()
    {
        $name = Input::get('name');
        $data = Models\users::where('name', $name)->where('status', 1)->get();
        $res = $data->isEmpty() ? ['code'=>0] : ['code'=>1];
        return response()->json($res);
    }





}