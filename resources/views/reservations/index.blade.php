@extends('layouts.app')

@section('content')     
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">
                <h1 class="mb-3">予約一覧</h1>       
                
                @if (session('flash_message')) 
                    <div>
                        <p class="text-success">{{ session('flash_message') }}</p>                    
                    </div>                                   
                @endif            

                <div class="mb-3">
                    <a href="{{ route('mypage') }}">< 戻る</a>     
                </div>
                
                <div class="container p-0 mb-4">
                    @foreach ($reservations as $reservation)
                        <div class="row g-3 mb-3">
                            <div class="col-12 col-lg-4">
                                <img src="{{ asset('storage/restaurants/' . $reservation->restaurant->image) }}" class="w-100">
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-between border-bottom mb-2">
                                    <p class="mb-2"><span class="fw-bold">店名：</span>{{ $reservation->restaurant->name }}</p>     
                                    @if ($reservation->reservation_datetime >= now())               
                                        <form action="{{ route('reservations.destroy', $reservation) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-link text-dark p-0 text-decoration-none" onclick="return confirm('キャンセルしてもよいですか？');">キャンセル</button>
                                        </form>
                                    @endif  
                                </div>
                                <div class="border-bottom mb-2">
                                    <p class="mb-2"><span class="fw-bold">予約日時：</span>{{ date('Y年m月d日H時i分', strtotime($reservation->reservation_datetime)) }}</p>
                                </div>      
                                <div class="border-bottom mb-2">
                                    <p class="mb-2"><span class="fw-bold">予約人数：</span>{{ $reservation->number_of_people }}名</p>
                                </div>                                                                               
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    {{ $reservations->links() }}
                </div>                
            </div>
        </div> 
    </div>                                                                                                                                                            
@endsection