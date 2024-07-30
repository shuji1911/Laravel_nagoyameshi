@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                <h1 class="mb-3">パスワード再設定</h1>       

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif                 

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group row mb-3">
                        <label for="email" class="col-md-5 col-form-label text-md-left fw-bold">メールアドレス</label>
                        <div class="col-md-7">                        
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-5 col-form-label text-md-left fw-bold">新しいパスワード</label>

                        <div class="col-md-7">
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password-confirm" class="col-md-5 col-form-label text-md-left fw-bold">新しいパスワード再入力</label>

                        <div class="col-md-7">
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>                    

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            パスワード再設定
                        </button>
                    </div>
                </form>                
            </div>
        </div>
    </div>
@endsection
