@extends('admin.layouts.app')
@section('title', 'Trang admin/user')
@section('content')

    @php
        session_start();
    @endphp

    <!-- Main content -->
    <section class="content">
        <a href="/admin/addUser" class="btn btn-success mb-3">Thêm tài khoản</a>
        <div>
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tài Khoản</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td class="align-middle text-center">{{ $count++ }}</td>
                            <td class="align-middle text-center">{{ $user->username }}</td>
                            <td class="align-middle text-center">{{ $user->email }}</td>
                            <td class="align-middle text-center">{{ $user->phone_number }}</td>

                            <td class="align-middle text-center">
                                <a href="{{ route('admin.user', $user->id) }}" class="btn btn-warning">Edit</a>

                                <form class="delete-form" action="/admin/category/delete/{{ $user->id }}" method="POST"
                                    style="display: inline;" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete btn-danger">Delete</button>
                                </form>

                                <script>
                                    function confirmDelete() {
                                        return confirm('Bạn có chắc chắn muốn xóa danh mục này?');
                                    }
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.content -->
    @endsection
