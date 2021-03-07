<?php

namespace App\Http\Controllers;

use App\Period;
use App\Service;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(){
        $services = Service::all();
        $periods = Period::all();

        return view('index', compact('services','periods'));
    }

        public function store(Request $request)
        {
            $this->mail($request);
            $user = new User();
            $user->name =$request->input('name');
            $user->mobile =$request->input('mobile');
            $user->email =$request->input('email');
            $user->service1 =$request->input('service1');
            $user->service2 =$request->input('service2');
            $user->service3 =$request->input('service3');
            $user->period =$request->input('period');
            $user->save();


            return json_encode(array(
                "statusCode" => 200
            ));
        }

public function mail($request){

        $name = $request->input('name');
    $period = $request->input('period');
    if($request->input('service1') == 1){
        $body = "You are Chosen " . "service1" . " your interest is " . "{$period}" ;
    }
    if($request->input('service2') == 1){
        $body = "You are Chosen " . "service2" . " your interest is " . "{$period}" ;
    }
    if($request->input('service3') == 1){
        $body = "You are Chosen " . "service3" . " your interest is " . "{$period}" ;
    }
    if($request->input('service3') == 1 && $request->input('service2') == 1 && $request->input('service1') == 1 ){
        $body = "You are Chosen " . " service1,service2 and service3" . " your interest is " . "{$period}" ;
    }
    if($request->input('service3') == 1 && $request->input('service2') == 1){
        $body = "You are Chosen " . "service2 and service3" . " your interest is " . "{$period}" ;
    }
    if($request->input('service3') == 1 && $request->input('service1') == 1){
        $body = "You are Chosen " . "service1 and service3" . " your interest is " . "{$period}" ;
    }
    if($request->input('service2') == 1 && $request->input('service1') == 1){
        $body = "You are Chosen " . "service1 and service2" . " your interest is " . "{$period}" ;
    }
    $details = [
        'title' => "Hello {$name}",
        'body' => $body
    ];
    \Mail::to($request->input('email'))->send(new \App\Mail\WelcomeMail($details));
}

}
