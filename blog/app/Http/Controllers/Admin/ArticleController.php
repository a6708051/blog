<?php
/**
 * Created by PhpStorm.
 * User: abc
 * Date: 2017/9/4
 * Time: 15:17
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lists(Request $request)
    {
        $list = Models\Article::where('status', '>=', 0)->orderBy('id', 'desc')->paginate(10);


        foreach ($list as &$lv) {
            $lv['cat_id'] = explode(',', $lv['cat_id']);
        }
        return view('admin.lists', ['list'=>$list]);
    }

    public function change($id)
    {
        $data = Models\Article::find($id);
        $data->status = $data->status>0 ? 0 : 1;
        $res = $data->save();
        if ($res) {
            return redirect('/admin/article');
        } else {
            return false;
        }
    }

    public function editor($id = null)
    {
        $data = $id>0 ? Models\Article::find($id) : ['id'=>0, 'title'=>'', 'content'=>''];
        return view('admin.editor', ['data'=>$data]);
    }

    public function save()
    {
        $id = Input::get('id');
        $title = Input::get('title');
        $content = Input::get('content');
        $cat_id = Input::get('cat_id', 1);

        $article = $id>0 ? Models\Article::find($id) : new Models\Article();
        $article->title = $title;
        $article->content = $content;
        $article->cat_id = $cat_id;
        $article->release_day = date('Y-m-d');
        $article->open_id = 0;
        $article->create_user = 1;
        $res = $article->save();
        if ($res) {
            return redirect('/admin/article');
        } else {
            echo 'failed';exit;
        }

    }

}