<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Helper\Countries;
use App\Models\Blog;
use Illuminate\Support\Facades\Crypt;
use Config;


class UserController extends Controller
{
    //
    function register_user(Request $req){
        $user = new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->country=$req->country;

        $existingUser = User::where('email', $req->input('email'))->first();

        if($req->name==""){
            return response()->json(['message' => 'Name required'], 400);
        }
        if($req->email==""){
            return response()->json(['message' => 'Email required'], 400);
        }
        if($existingUser){
            return response()->json(['message' => 'Email Exists'], 400);
        }
        if($req->country == "Select country"){
            return response()->json(['message' => 'Country required'], 400);
        }

        if (strlen($req->password) < 8 || !preg_match('/[0-9]/', $req->password)) {
            return response()->json(['message' => 'Password error'], 400);
        }
        if ($req->password !== $req->password2) {
            return response()->json(['message' => 'Passwords do not match'], 400);
        }


        $user->password=$req->password;
        $user->save();
        return response()->json(['message' => 'Registration Successfull']);
    }

    function login(Request $req){

        $user = User::where('email',$req->input('email'))->first();
        if ($user) {
                if (password_verify($req->input('password'), $user->password)){
                    $req->session()->put([
                        "user_id"=>$user->id,
                        "user_name"=>$user->name,
                    ]);
                    return response()->json(['message' => 'Login Successfull']);
                }
                else{
                    return response()->json(['message' => 'Invalid Password!'], 400);
                }
        }

        else{
            return response()->json(['message' => 'Invalid Email!'], 400);
        }

    }

    function  logout(Request $req){
        $req->session()->flush();
        return redirect("/");
    }

    function profile(Request $req){
        $user_id = session('user_id');
        $user = User::find($user_id);

        if ($user) {
            $name = $user->name;
            $email = $user->email;
            $country = $user->country;

            $countryData = Countries::$countryData;
            $countryName = $countryData[$country];

            $data = [
                'name' => $name,
                'email' => $email,
                'country' => $countryName,
            ];
            return view('profile', ['user' => $data]);
        }
        else {
            return view('login');
        }

    }

    function user_timeline(Request $req){
        $user_id = session('user_id');
        $user = User::find($user_id);

        if ($user) {
            return view('user_timeline');
        }
        else {
            return view('login');
        }
    }


    function user_posts(Request $req){
        $user_id = session('user_id');
        $user = User::find($user_id);

        if ($user) {
            $blogs = Blog::where('user_id', $user_id)->get();
            return view('user_posts', ['blogs' => $blogs]);
        }
        else {
            return view('login');
        }
    }

}
