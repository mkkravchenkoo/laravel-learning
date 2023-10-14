<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


//abstract class Model2 {
//    protected $attributes = [];
//    public function setAttributes($key, $val){
//        $this->attributes[$key] = $val;
//        return $this;
//    }
//
//    public function __set($key, $val){
//        $this->setAttributes($key, $val);
//    }
//}
//class Order extends Model2{
//
//}
//
//$res = new Order;
//$res->setAttributes('aa', 'bbb');
//$res->setAttributes('bbb', 'ddd');
//$res->eeee = 'asasasas';
//dd($res);


class RegisterController extends Controller
{
    public function index(){
        return view('register.index');
    }
    public function store(Request $request){
//       return redirect()->back()->withInput();

        $validated = validator($request->all(), [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', 'min:7'],
            'agreement' => ['accepted']
        ])->validate();


//        $user = new User;
//        $user->name = $validated['name'];
//        $user->email = $validated['email'];
//        $user->password = bcrypt($validated['password']);
//        $user->save();

//        User::query()->create([
//            'name' => $validated['name'],
//            'email' => $validated['email'],
//            'password' => bcrypt($validated['password'])
//        ]);

        $user = new User([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->setAttribute('email', $validated['email']);
        $user->fill(['email' => $validated['email']]);
        $user->email = $validated['email'];
        $user->save();
        return redirect()->route('user');

    }
}
