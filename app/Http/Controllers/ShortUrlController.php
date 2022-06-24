<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use App\Models\Tracker;
use Illuminate\Http\Request;

class ShortUrlController extends Controller {

    public function getUrl(Request $request) {

        if (isset($request['q'])) {
            $find = ShortUrl::where('code', $request['q'])->first();

            if ($find) {
                return redirect($find['value']);
            }
            return abort(404, 'invalid code provided');
        }
        return abort(404, 'Not found');
    }

    public function trackUser(Request $request) {
        $path = $request->path();
        $data = ShortUrl::where('key', $path)->first();
        if ($data) {
            Tracker::create([
                'short_url_id' => $data['id'],
                'ip_address' => $request->ip(),
                'full_url' => $request->fullUrl(),
                'operating_system' => $request->header('sec-ch-ua-platform'),
                'browser' => $request->userAgent(),
            ]);
        }
//        return response()->json(['key does not exist']);
    }
}
