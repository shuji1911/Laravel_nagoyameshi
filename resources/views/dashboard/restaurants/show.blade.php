@extends('layouts.dashboard')

@section('content')                                                                          
    <h1 class="mb-3">店舗詳細</h1>               

    <a href="{{ route('dashboard.restaurants.index') }}">< 戻る</a>                  

    <div class="container mt-2 mb-4">
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">ID</span>          
            </div>                                                  

            <div class="col">
                <span>{{ $restaurant->id }}</span>
            </div>
        </div>

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">画像</span>          
            </div>                                                  

            <div class="col">
                <span><img src="{{ asset('storage/restaurants/' . $restaurant->image) }}" class="w-100"></span>
            </div>
        </div>                    

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">店名</span>
            </div>

            <div class="col">
                <span>{{ $restaurant->name }}</span>
            </div>
        </div>                    

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">説明</span>
            </div>

            <div class="col">
                <span>{{ $restaurant->description }}</span>
            </div>
        </div>

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">価格帯</span>
            </div>

            <div class="col">
                <span>{{ number_format($restaurant->lowest_price) . '円～' . number_format($restaurant->highest_price) }}円</span>
            </div>
        </div> 

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">営業時間</span>
            </div>

            <div class="col">
                <span>{{ date('G:i', strtotime($restaurant->opening_time)) . '～' . date('G:i', strtotime($restaurant->closing_time)) }}</span>
            </div>
        </div>                    
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">郵便番号</span>
            </div>

            <div class="col">
                <span>〒{{ $restaurant->postal_code }}</span>
            </div>
        </div>   
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">住所</span>
            </div>

            <div class="col">
                <span>{{ $restaurant->address }}</span>
            </div>
        </div>    
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">電話番号</span>
            </div>

            <div class="col">
                <span>{{ $restaurant->phone_number }}</span>
            </div>
        </div> 
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">定休日</span>
            </div>

            <div class="col d-flex"> 
                <div>{{ $restaurant->regular_holiday }}</div>                           
            </div>
        </div>    
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-2">
                <span class="fw-bold">カテゴリ</span>
            </div>

            <div class="col d-flex"> 
                <div>{{ $restaurant->category->name }}</div>                           
            </div>
        </div>         
    </div>                                                                                     
@endsection