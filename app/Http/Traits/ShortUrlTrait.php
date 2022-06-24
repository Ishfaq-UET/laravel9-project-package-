<?php

namespace App\Http\Traits;

use App\Models\Tracker;

trait ShortUrlTrait{

    public static function getDetails(){
        $data = Tracker::all();
        return response()->json(['Success' => ['details' => $data]]);
    }

    public static function getData($ipAddress){

        $data = Tracker::where('ip_address', $ipAddress)->first();
        dd($data);
        return response()->json(['Success' => ['data' => $data]]);

    }


}