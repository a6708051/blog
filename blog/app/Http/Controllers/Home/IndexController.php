<?php
/**
 * Created by PhpStorm.
 * User: abc
 * Date: 2017/8/30
 * Time: 17:05
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Http\Models;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller {
    public function index($id = null){
        if ($id > 0) {
            $list = Models\Article::where('status', '>', 0)->whereRaw('FIND_IN_SET('.$id.', cat_id)')->orderBy('id', 'desc')->paginate(5);
        } else {
            $list = Models\Article::where('status', '>', 0)->orderBy('id', 'desc')->paginate(5);
        }
        return view('home.index', ['list'=>$list]);
    }

    public function detail($id)
    {
        $data = Models\Article::find($id);
        return view('home.detail', ['data'=>$data]);
    }
}