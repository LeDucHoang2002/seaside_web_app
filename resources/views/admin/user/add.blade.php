@extends('admin.layouts.app')
@section('title', 'Trang admin/user')
@section('content')

    <!-- Main content -->
    <section class="content">        
        <div class="container-fluid">
            <div class="row" style="display: flex;justify-content: center;">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm Tài Khoản</h3>
                        </div>
                        <!-- form start -->
                        <form role="form" method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Tên Đăng Nhập</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">Số Điện Thoại</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Nhập số điện thoại" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Mật Khẩu</label>
                                    <input class="form-control" id="password" type="password" name="password" placeholder="Mật khẩu" required>
                                    <i id="togglePassword" class="fas fa-regular fa-eye-slash toggle-password"></i>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('js/togglePassword.js') }}"></script>
@endsection
