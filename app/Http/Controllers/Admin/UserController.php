<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Permission;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách các user có id_permission = 1
        $users = User::join('user_permission', 'user.username', '=', 'user_permission.username')
                     ->where('user_permission.id_permission', 1)
                     ->get(['user.*']); // Lấy tất cả các cột từ bảng user

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'username' => 'required|unique:user,username',
            'email' => 'required|email|unique:user,email',
            'phone_number' => 'required',
            'password' => 'required|min:6', // Kiểm tra mật khẩu ít nhất 6 ký tự
        ]);

        // Tạo tài khoản mới
        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');
        $user->password = bcrypt($request->input('password')); // Mã hóa mật khẩu
        $user->email_verified = 1; // Đặt giá trị email_verified là 1
        $user->save();

        // Gán quyền cho tài khoản
        $userPermission = new User_Permission();
        $userPermission->id_permission = 1; // Quyền mặc định
        $userPermission->username = $user->username;
        $userPermission->save();

        // Chuyển hướng về trang danh sách tài khoản với thông báo thành công
        return redirect()->route('admin.user')->with('success', 'Tài khoản đã được tạo thành công.');
    }
}
