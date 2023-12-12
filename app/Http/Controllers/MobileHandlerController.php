<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileHandlerController extends Controller
{
    //
    public function receiveKtpImage(){
        if(!request()->hasFile('ktp_image')){
            return response()->json([
                'message' => 'no file'
            ],400);
        }

        $file = request()->file('ktp_image');
        $file->storeAs('images/ktp', request()->image_name, 'public');

        return response()->json([
            'message' => 'success'
        ],200);
    }
}
