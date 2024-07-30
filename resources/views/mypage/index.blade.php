@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">                
                <h1 class="mb-3">マイページ</h1>   
                
                <div class="mb-3">
                    <a href="{{ route('home') }}">< 戻る</a>     
                </div>    

                @if (session('flash_message')) 
                    <div>
                        <p class="text-success">{{ session('flash_message') }}</p>                    
                    </div>                                   
                @endif                

                <div class="list-group">
                    <a href="{{ route('user.edit') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3">
                        会員情報編集
                    </a>                    
                    @if (Auth::user()->subscribed('basic_plan'))
                        <a href="{{ route('reservations.index') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3">予約一覧</a>
                        <a href="{{ route('subscription.edit') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3">クレジットカード情報編集</a>
                        <a href="{{ route('subscription.cancel') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3">有料会員解約</a>                        
                    @else
                        <a href="{{ route('subscription.create') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3">有料会員登録</a>
                    @endif
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action fs-5 fw-bold py-3" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}                                                    
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>                        
                </div>                                    
            </div>                          
        </div>
    </div>   
@endsection