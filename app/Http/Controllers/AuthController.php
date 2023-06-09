<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    //show login
    public function showLogin()
    {
        return view('admin.sign-in');
    }

    //show register
    public function showRegister()
    {
        return view('admin.register');
    }

    //login user
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu không được ít hơn 8 ký tự.',
        ]);

        //login
        if (Auth::attempt($request->only('email', 'password'))) {
            $position = DB::select("SELECT bophan.tenBP
                                FROM nguoidung
                                LEFT JOIN nhanvien ON nguoidung.id = nhanvien.maND
                                LEFT JOIN bophan ON nhanvien.maBP = bophan.id
                                WHERE nguoidung.id = ".Auth::user()->id);
                                
            if ($position[0]->tenBP == 'Nhân viên kinh doanh') {
                return redirect(route('warehouse'));
            } elseif($position[0]->tenBP == 'Kế toán'){
                return redirect(route('payment'));
            } else{
                return redirect('/');
            }
        }
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác',
        ]);
    }

    //logout
    public function logout()
    {
        Auth::logout();
        return back();
    }
}
