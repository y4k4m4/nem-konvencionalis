<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller {
    public function login(Request $request) {
        if(\Auth::attempt(['username' => $request->get('name'), 'password' => $request->get('password')])) {
            return redirect('/');
        } else {
            return redirect('/login');
        }
    }
}
