<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
{
    $path= storage_path('logs/logs.txt');
    $json = File::get($path);


    $data = json_decode($json, true);

    $data = array_reverse($data);

    // dd($data);

    return view('index', ['data' => $data]);
}
}
