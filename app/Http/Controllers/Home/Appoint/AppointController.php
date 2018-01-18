<?php

namespace App\Http\Controllers\Home\Appoint;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AppointController extends Controller
{
    //
    public function index()
    {
        return view('home.appoint.index.index');
    }

    //创建预约
    public function create()
    {
        //$physicalItems  = DB::table('physical_items')->first();
        return view('home.appoint.index.create');
    }

    //保存预约
    public function store(Request $request)
    {
        $data = $request->all();

    }
}


