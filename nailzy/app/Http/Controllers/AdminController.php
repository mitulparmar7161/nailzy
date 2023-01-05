<?php

namespace App\Http\Controllers;




use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class AdminController extends Controller
{
    public function index()
{

    
    $path= storage_path('logs/logs.txt');
    $json = File::get($path);

    if (empty($json)) {

            
        return view('admin.apilog', ['data' => NULL ]);

    }
    else {

        
    $data = json_decode($json, true);

    $data = array_reverse($data);

    $data = collect($data);

    $data = $this->paginate($data);
    
    // $paginator = Collection::make($data)->paginate(2);


    return view('admin.apilog', ['data' => $data]);
        
    }

}
public function paginate($items, $perPage = 5, $page = null, $options = [])
{
    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
    $items = $items instanceof Collection ? $items : Collection::make($items);
    return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}


}
