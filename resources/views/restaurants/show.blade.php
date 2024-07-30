@extends('layouts.app')

@section('content')     
    <div class="container">
        <h1 class="mb-3">{{ $restaurant->name }}</h1>       
        
        @if (session('flash_message')) 
            <div>
                <p class="text-success">{{ session('flash_message') }}</p>                    
            </div>                                   
        @endif   
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif         

        <div class="mb-3">
            <a href="{{ route('restaurants.index') }}">< 戻る</a>     
        </div>
        
        <div class="container p-0 mb-4">
            <div class="row g-3">
                <div class="col-12 col-lg-4">
                    <img src="{{ asset('storage/restaurants/' . $restaurant->image) }}" class="w-100">
                </div>
                <div class="col">
                    <div class="border-bottom mb-2">
                        <p class="mb-2"><span class="fw-bold">カテゴリ：</span>{{ $restaurant->category->name }}　<span class="fw-bold">平均評価：</span><span class="text-warning">{{ str_repeat('★', round($restaurant->reviews()->avg('score'))) }}</span></p>
                    </div>
                    <div class="border-bottom mb-2">
                        <p class="mb-2"><span class="fw-bold">予算：</span>{{ $restaurant->lowest_price }}円～{{ $restaurant->highest_price }}円</p>
                    </div>      
                    <div class="border-bottom mb-2">
                        <p class="mb-2"><span class="fw-bold">営業時間：</span>{{ date('G:i', strtotime($restaurant->opening_time)) . '～' . date('G:i', strtotime($restaurant->closing_time)) }}　<span class="fw-bold">定休日：</span>{{ $restaurant->regular_holiday }}</p>
                    </div>                                   
                    <div class="border-bottom mb-2">
                        <p class="mb-2">{{ $restaurant->description }}</p>
                    </div>
                    <div class="border-bottom mb-2">
                        <p class="mb-2"><span class="fw-bold">住所：</span>〒{{ $restaurant->postal_code }}　{{ $restaurant->address }}</p>
                    </div>                    
                </div>
            </div>
        </div> 

        <div>
            <h2 class="mb-3">予約</h2>                   
            
            
                <form method="POST" action="{{ route('restaurants.reservations.store', $restaurant) }}" class="mb-4">
                    @csrf       

                    <div class="d-flex flex-wrap align-items-end">
                        <input type="hidden" name="restaurant_id", value="{{ $restaurant->id }}">
                        <div class="form-group me-2  mb-2">
                            <label for="reservation_date" class="form-label text-md-left fw-bold">予約日</label>

                            <div>
                                <select class="form-control form-select resevation-select" id="reservation_date" name="reservation_date" required>
                                    <option value="">選択してください</option>
                                    @for ($i = 0; $i <= 14; $i++)
                                    @if (date('Y-m-d', strtotime($reservation_start_date . "+{$i} day")) == old('reservation_date'))
                                        <option value="{{ date('Y-m-d', strtotime($reservation_start_date . "+{$i} day")) }}" selected>{{ date('Y-m-d', strtotime($reservation_start_date . "+{$i} day")) }}</option>
                                    @else
                                        <option value="{{ date('Y-m-d', strtotime($reservation_start_date . "+{$i} day")) }}">{{ date('Y-m-d', strtotime($reservation_start_date . "+{$i} day")) }}</option>
                                    @endif
                                    @endfor
                                </select>                                     
                            </div>
                        </div>

                        <div class="form-group me-2 mb-2">
                            <label for="reservation_time" class="form-label text-md-left fw-bold">予約時間</label>

                            <div>
                                <select class="form-control form-select resevation-select" id="reservation_time" name="reservation_time" required>
                                    <option value="">選択してください</option>
                                    @for ($i = 0; $i <= (strtotime($reservation_end_time) - strtotime($reservation_start_time)) / 60 / $time_unit; $i++)
                                        {{ $reservation_time = date('H:i', strtotime($reservation_start_time . '+' . $i * $time_unit . 'minute')) }}
                                        @if ($reservation_time == old('reservation_time'))
                                            <option value="{{ $reservation_time }}" selected>{{ $reservation_time }}</option>
                                        @else
                                            <option value="{{ $reservation_time }}">{{ $reservation_time }}</option>
                                        @endif
                                    @endfor                                                        
                                </select>                             
                            </div>
                        </div>                    
                        
                        <div class="form-group me-2 mb-2">
                            <label for="number_of_people" class="form-label text-md-left fw-bold">予約人数</label>

                            <div>
                                <select class="form-control form-select resevation-select" id="number_of_people" name="number_of_people" required>
                                    <option value="">選択してください</option>
                                    @for ($i = 1; $i <=30; $i++)
                                        <option value="{{ $i }}">{{ $i }}名</option>
                                    @endfor 
                                </select>
                            </div>
                        </div>                     
                        
                        <button type="submit" class="btn btn-primary shadow-sm mb-2">予約</button>                    
                    </div> 
                </form>           
        </div>        
        
        <div>
            <h2 class="mb-3">レビュー一覧</h2>    

            <div class="mb-3">
                <a href="{{ route('restaurants.reviews.create', $restaurant) }}" class="btn btn-primary shadow-sm">レビュー投稿</a>                
            </div>

            @foreach ($reviews as $review)
                <div class="border-bottom mb-3">
                    <h3>{{ $review->user->name }}</h3>
                    <p class="text-warning">{{ str_repeat('★', $review->score) }}</p>
                    <p>{{ $review->comment }}</p>
                    @if ($review->user->id == Auth::id())
                        <div class="d-flex mb-3">
                            <a href="{{ route('restaurants.reviews.edit', [$restaurant, $review]) }}" class="btn btn-primary shadow-sm me-2">編集</a>      
                            <form action="{{ route('restaurants.reviews.destroy', [$restaurant, $review]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('削除してもよいですか？');">削除</button>
                            </form>                                                
                        </div>
                    @endif                    
                </div>
            @endforeach 
            <div>
                {{ $reviews->links() }}
            </div>                       
        </div>
    </div>                                                                                                                                                            
@endsection