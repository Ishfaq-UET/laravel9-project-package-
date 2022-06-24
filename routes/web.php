<?php

namespace App\Models;

use App\Http\Controllers\ShortUrlController;
use App\Http\Traits\ShortUrlTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', static function () {
    return view('welcome');
});


/*
 * return can return array in json
 */
Route::get('/array', static function () {
    return ([12, 14, 14]);
});
/*
 * echo can not return any array it returns only string
 * to return any array to echo we use jsom_encode method.
 */
Route::get('/string', static function () {
    echo json_encode([12, 14, 14], JSON_THROW_ON_ERROR);
});

/*
 *  Routing with required parameters dynamic routing
 */
Route::get('/about/{country}', static function ($country) {
    return "welcome to {$country}";
});
/*
 * route with optional parameters if user not pass the parameter
 */
Route::get('/user/{name?}', static function ($name = 'guest'){
    return "welcome {$name} to our website";
});

/*
 * Route with multiple query string
 */
Route::get('/search', static function (Request $request) {
    dd($request->userAgent());
});

Route::get('/user/welcome', static function () {
    echo "<a href='" . route('bye') . "'>bye link</a>";
})->name('welcome');

Route::get('/user/bye', static function () {
    echo "<a href='" . route('welcome') . "' >welcome link</a>";
})->name('bye');

Route::get('/country', static function () {
    echo "<a href='" . route('welcome') . "' >welcome link</a>";
    $countries = ([
        "143232" => "Pakistan",
        "4736456" => "india",
        "70925092" => "china",
        "9890812313" => "america"
    ]);

    echo "<ul>";

    foreach ($countries as $population => $country) {
        echo "<li>
            <a href='" . route('country', [
                'country' => $country,
                'population' => $population]) . "' >$country
            </a>
            </li>";
    }
    echo "</ul>";

})->name('country');

Route::get('/about/{country}', static function ($country) {
    return "welcome to {$country}, Our population is " . request('population');
})->name('country');

/*
 * Route attributes for collection of routes can be middleware, prefix, controller, name and domain
 * prefix attribute is used here
 */

Route::prefix('/user')->group(function () {
    Route::get('/dashboard');
    Route::get('/profile');
    Route::get('/setting');
    Route::get('/login');
    Route::get('/logout');
    Route::get('/register');
});
/*
 *  name attribute is used
 */

Route::name('/user.')->group(function () {
    Route::get('/dashboard')->name('dashboard');
    Route::get('/profile')->name('profile');
    Route::get('/setting')->name('setting');
    Route::get('/login')->name('login');
    Route::get('/logout')->name('logout');
    Route::get('/register')->name('register');
});
/*
 * controller attribute is used here for controller,
 * this feature is available is used only in laravel '9.0'
 *
 */

Route::controller(\App\Http\Controllers\PagesController::class)->name('page.')->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/gallery', 'gallery')->name('gallery');
    Route::get('/services', 'services')->name('services');
});
/*
 * Singleton controller: no need to call method in route as __invoke method is used in controller
 */
Route::match(['get', 'post', 'put'], '/upload', \App\Http\Controllers\SingletonController::class,)->name('page.upload');

/*
 * resource controller: php artisan make:controller PostController --resource or -r
 * Route::resource('/path', PostController::class);
 */
Route::resource('/about-us', \App\Http\Controllers\PostController::class);

/*
 * calling views directly
 * pass a static value to the view from route e.g. about.blade.php view has value passed from about-us route
 *
 */

Route::view('/about-us', 'about', [
    'message' => 'This is message for about',
    'name' => 'Muhammad Ishfaq'
    ])->name('about');
/*
 * calling controller
 */

Route::get('/url/{code}', [ShortUrlController::class, 'getUrl']);

Route::get('/url', static function (Request $request) {
// Get the app URL from configuration which we set in .env file.
//    echo config('app.url');;
//    \App\Models\ShortUrl::set('login','/login');
    dd(\App\Models\ShortUrl::get('login'));
});

Route::controller(\App\Http\Controllers\ShortUrlController::class)->group(function () {

    Route::get('/getvalue', function () {
        return \App\Models\ShortUrl::get('tracker');
    });

    Route::get('/url', 'getUrl')->middleware('short_url_tracker');
    Route::get('/tracker', 'trackUser');

    Route::get('/login', static function () {
        return ('welcome to login');
    });

    Route::get('/track', static function () {
        ShortUrlTrait::getData();

    });

});
