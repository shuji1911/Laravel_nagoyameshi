@extends('layouts.dashboard')

@section('content')
    <div class="col container">
        <div class="row">                            
                <h1 class="mb-3">会員詳細</h1>       
                
                <a href="{{ route('dashboard.users.index') }}" class="mb-2">< 戻る</a>

                <div class="container mb-4">
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">ID</span>          
                        </div>                                                  

                        <div class="col">
                            <span>{{ $user->id }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">氏名</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->name }}</span>
                        </div>
                    </div>                    

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">メールアドレス</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div> 
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">郵便番号</span>
                        </div>

                        <div class="col">
                            <span>〒{{ $user->postal_code }}</span>
                        </div>
                    </div>   
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">住所</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->address }}</span>
                        </div>
                    </div>

                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">電話番号</span>
                        </div>

                        <div class="col">
                            <span>{{ $user->phone_number }}</span>
                        </div>
                    </div>  
                    
                    <div class="row pb-2 mb-2 border-bottom">
                        <div class="col-3">
                            <span class="fw-bold">会員種別</span>
                        </div>

                        <div class="col">
                            <span>
                                @if ($subscriptions_query->where('user_id', $user->id)->exists() && $subscriptions_query->where('user_id', $user->id)->value('stripe_status') === 'active') 
                                    有料会員
                                @else
                                    無料会員
                                @endif                                
                            </span>
                        </div>
                    </div>                    
                                       
                </div>                                                                                  
        </div>
    </div>       
@endsection