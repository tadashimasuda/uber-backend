<?php

namespace App\Http\Controllers;

use App\Models\Record;
use DB;
use Exception;
use Illuminate\Http\Request;
use Str;

class recordController extends Controller
{
    //
    public function store(Request $request){
        $params = $request->json()->all();
        $content = $params['message'];
        $area = $params['area'];
        $way = $params['way'];
        $count = $params['count'];
        $time = $params['time'];
        $reward =$params['reward'];

        $user_id = 1;

        $id = Str::uuid();
        $file = $id ->toString().'jpg';
         
        Record::create([
            'id' =>$id,
            'file_path'=>$file,
            'area'=>$area,
            'way'=>$way,
            'time'=>$time,
            'message'=>$content,
            'count'=>$count,
            'reward'=>$reward,
            'user_id'=>$user_id
        ]);

        return response()->json($id);
    }
}
