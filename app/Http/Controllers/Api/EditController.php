<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Str;

class EditController extends Controller
{
    //
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()
            ], 400);
        }

        $params = $request;
        $aws=false;
        // if profileimage
        if ($params['file']) {
            list(, $file) = explode(';', $params['file']);
            list(, $file) = explode(',', $file);
            $decodedImage = base64_decode($file);
        } else {
            $decodedImage = false;
        }

        $name = $params['name'];
        $email = $params['email'];
        $password = $params['password'];
        // $profile = $params['profile'];
        $user_id = $params['user_id'];

        $data = false;

        DB::transaction(function () use ($user_id, $decodedImage, $name, $email, $password) {
            $id = Str::uuid();
            // $file = $id->toString() . '.jpg';
            $file = $id->toString();


            $user = User::find($user_id);
            //requestされてきたカラムだけupdate?
            $user->name = $name;
            $user->email = $email;
            $user->password = bcrypt($password);

            // if profileimage
            if (!is_null($decodedImage)){
                //s3にファイルがあるか？(dbで判定)y->delete->upload,n->upload
                if (!is_null($user->file_path)) {
                    //delete old img
                    $data = 'file  db now';
                    Storage::disk('s3')->delete('profile/' . $user->file_path);
                } 
                //upload
                //[/profile]に$decodeimageを$fileという名前で
                $isSuccess = Storage::disk('s3')->put('profile/'.$file, $decodedImage);
                if (!$isSuccess) {
                    throw new Exception('ファイルのアップでエラー');
                }
                //publicにする
                Storage::disk('s3')->setVisibility('profile/'.$file, 'public');
                $user->file_path = $file;
                $aws=true;
            } 
            $user->save();
        });

        return response()->json([
            'status' => 'success',
            'aws'=>$aws
        ], 200);
    }
}
