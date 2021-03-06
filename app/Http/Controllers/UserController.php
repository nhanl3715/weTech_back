<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use Response,File;
use Cloudder;

class UserController extends Controller
{
    // Login & Register
    public function register(Request $request)
    {
        $ch1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ch1len = strlen($ch1);
        $rd = '';
        for ($i = 0; $i < 4; $i++) {
            $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
        }
        $rd = $ran;
        $id = Hash::make($ran);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;

        $account = new User;
        $account->user_id = $id;
        $account->name=$name;
        $account->username=$username;
        $account->email=$email;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        $account->status=1;
        $account->role='User';
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if ($account) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }
    }

    public function login(Request $request){
        $name = $request->username;
        $pass = $request->password;
        $user = User::where('password',$pass)->where('username',$name)->orWhere('email',$name)->where('password',$pass)->get();
        if(count($user) <= 0){
            return response()->json(['error' => 'Sai tên đăng nhập hoặc mật khẩu']);  
        }else{
            return response()->json($user);
        }
    }


    // User
    public function showUser(){
        return User::all();
    }

    public function addUser(Request $request){
        $ch1 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ch1len = strlen($ch1);
        $rd = '';
        for ($i = 0; $i < 4; $i++) {
            $rd .= $ch1[rand(0, $ch1len - 1)].rand(0,9).rand(0,9);
        }
        $rd = $ran;
        $id = Hash::make($ran);
        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;
        $avatar = $request->avatar;
        $role = $request->role;
        $background = $request->background;
        if ($avatar) {
            //get name image
            $filename = $request->file('avatar');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut1 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut1);        
        }

        if ($background) {
            //get name image
            $filename = $request->file('background');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut2 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut2);        
        }

        $account = new User;
        $account->user_id = $id;
        $account->name=$name;
        $account->username=$username;
        $account->email=$email;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        $account->avatar = Cloudder::show('users/'. $cut1);
        $account->background = Cloudder::show('users/'. $cut2);
        $account->status=1;
        $account->role = $role;
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if ($account) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }


    public function updateUser(Request $request){
        $user_id = $request->user_id;
        $name = $request->name;
        $password = $request->password;
        $gender = $request->gender;
        $address = $request->address;
        $birth_day = $request->birth_day;
        $phone_number = $request->phone_number;
        $avatar = $request->avatar;
        $role = $request->role;
        $background = $request->background;
        $status = $request->status;
        if ($avatar) {
            //get name image
            $filename = $request->file('avatar');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut1 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut1);        
        }

        if ($background) {
            //get name image
            $filename = $request->file('background');
            $name = $filename->getClientOriginalName();
            $extension = $filename->getClientOriginalExtension();
            $cut2 = substr($name, 0,strlen($name)-(strlen($extension)+1));
            //upload image
            Cloudder::upload($filename, 'users/' . $cut2);        
        }

        $account = new User;
        $account->user_id = $id;
        $account->name=$name;
        $account->password=Hash::make($password);
        $account->gender=$gender;
        $account->address=$address;
        $account->birth_day=$birth_day;
        $account->phone_number=$phone_number;
        $account->avatar = Cloudder::show('users/'. $cut1);
        $account->background = Cloudder::show('users/'. $cut2);
        $account->status = $status;
        $account->role = $role;
        $account->created_at = now()->timezone('Asia/Ho_Chi_Minh');       
        $account->save();
        if ($account) {
            echo 'Thành công';
        }
        else{
            echo 'Lỗi';
        }

    }


    public function deleteUser(Request $request){
        $id = $request->id;

        $user = DB::table('users')->where('user_id','=',$id)->get();

        $user->delete();
        if ($user) {
            return 'Thành công';
        }else{
            return 'Thất bại';
        }
    }




}
