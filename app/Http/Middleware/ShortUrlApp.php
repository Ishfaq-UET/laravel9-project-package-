<?php

namespace App\Http\Middleware;

use App\Models\ShortUrl;
use App\Models\Tracker;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShortUrlApp {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        dd($request->path());
        $path = $request->path();
        $data = ShortUrl::where('key', $path)->first();
//        dd(ShortUrl::where('key', $path)->first());

        if ($data) {
            Tracker::create([
                'short_url_id' => $data['id'],
                'ip_address' => $request->ip(),
                'full_url' => $request->fullUrl(),
                'operating_system' => $request->header('sec-ch-ua-platform'),
                'browser' => $request->userAgent(),
            ]);
        }

        if ($request->get('q')) {
            $find = ShortUrl::where('code', $request->get('q'))->first();
            if ($find) {
                return redirect($find['value']);
            }
        }
        return $next($request);
    }
}
