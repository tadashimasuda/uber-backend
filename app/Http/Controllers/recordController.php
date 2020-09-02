<?php

namespace App\Http\Controllers;

use App\Models\Record;
use DB;
use Exception;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Str;
use Storage;

class recordController extends Controller
{
    public function index(){
        return Record::all();
    }
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    //
    public function show($id)
    {
        /** @var Record $record */
        $record = Record::find($id);
        // dd($record);
        return response()->json([
            'message' => $record->message,
            'area' => $record->area,
            'reward' => $record->reward,
            'way' => $record->way,
            'time' => $record->time,
            'count' => $record->count,
            'url' => config('app.image_url') . $record->file_path
        ]);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $params = $request->json()->all();
        
        list(, $image) = explode(';', $params['image']);
        list(, $image) = explode(',', $image);
        $decodedImage = base64_decode($image);

        $content = $params['message'];
        $area = $params['area'];
        $way = $params['way'];
        $count = $params['count'];
        $time = $params['time'];
        $reward = $params['reward'];

        $user_id = 1;

        $id = DB::transaction(function () use ($decodedImage, $content, $area, $way, $time, $count, $reward, $user_id) {
            $id = Str::uuid();
            $file = $id->toString() . '.jpg';

            Record::create([
                'id' => $id,
                'file_path' => $file,
                'area' => $area,
                'way' => $way,
                'time' => $time,
                'message' => $content,
                'count' => $count,
                'reward' => $reward,
                'user_id' => $user_id
            ]);

            $isSuccess = Storage::disk('s3')->put($file, $decodedImage);
            if (!$isSuccess) {
                throw new Exception('ファイルのアップでエラー');
            }

            return $id;
        });


        return response()->json($id);
    }
}
