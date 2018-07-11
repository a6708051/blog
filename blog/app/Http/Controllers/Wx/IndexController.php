<?php
/**
 * Created by PhpStorm.
 * User: fengdh
 * Date: 2018/7/3
 * Time: 17:29
 */
namespace App\Http\Controllers\Wx;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        $path = 'C:\Users\fengdh\Desktop\xls\developer.xlsx';
        $file = fopen($path, 'r');
        $row = fgets($file);
//        $row = explode("\t", $row);
        var_dump($row);exit;
    }


}