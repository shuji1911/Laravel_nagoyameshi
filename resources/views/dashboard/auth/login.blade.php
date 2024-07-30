@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8">
                <h1 class="mb-3">ログイン</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif  
                
                <form method="POST" action="{{ route('dashboard.login') }}">
                    @csrf                 

                    <div class="form-group row mb-3">
                        <label for="email" class="col-md-5 col-form-label text-md-left fw-bold">メールアドレス</label>
                        <div class="col-md-7">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="password" class="col-md-5 col-form-label text-md-left fw-bold">パスワード</label>

                        <div class="col-md-7">
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label samuraimart-check-label w-100" for="remember">
                                次回から自動的にログインする
                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <button type="submit" class="mt-3 btn btn-primary">
                            ログイン
                        </button>
                    </div>
                </form>             
            </div>
        </div>
    </div>
@endsection