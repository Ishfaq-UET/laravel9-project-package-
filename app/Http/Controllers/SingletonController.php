<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SingletonController extends Controller {
    /*
     * when __invoke method is used, the controller becomes a singleton controller
     */
    public function __invoke() {
        $this->message();
    }

    public function message() {
        echo 'i am invoked without calling any method';
    }
}
