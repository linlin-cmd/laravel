@extends('layouts.hadmin')
@section('title')绑定账号@endsection
@section('content')
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">h</h1>

            </div>
            <h3>绑定账号</h3>

            <form class="m-t" role="form" method="post" action="{{url('hadmin/account_do')}}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" required="" name="name">
                </div>
                <input type="hidden" name="openid" value="{{$openid}}">
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" id="account">绑 定 账 号</button>
                </p>

            </form>
        </div>
    </div>
@endsection