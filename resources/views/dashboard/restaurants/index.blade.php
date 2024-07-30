@extends('layouts.dashboard')

@section('content')           
    <h1 class="mb-3">店舗一覧</h1>   
    
    <div>
        <a href="{{ route('dashboard.restaurants.create') }}" class="btn btn-primary text-white shadow-sm mb-3">+ 新規作成</a>            
    </div>            
            
    <div class="d-flex mb-2">
        <form method="GET" action="{{ route('dashboard.restaurants.index') }}" class="search-box mb-3">
            <div class="row">
                <div class="col-auto pe-2">
                    <input type="text" class="form-control" placeholder="店名" name="keyword" value="{{ $keyword }}">
                </div>
                <div class="col-auto p-0">
                    <button type="submit" class="btn btn-primary text-white shadow-sm">検索</button> 
                </div>
            </div>               
        </form>                                
    </div>

    @if (session('flash_message')) 
        <div>
            <p class="text-success">{{ session('flash_message') }}</p>                    
        </div>                                   
    @endif                                             

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">画像</th>
                <th scope="col">店名</th>                        
                <th scope="col">住所</th>
                <th scope="col">電話番号</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>   
        <tbody>                 
            @foreach($restaurants as $restaurant)  
                <tr>
                    <td>{{ $restaurant->id }}</td>
                    <td><a href="{{ route('dashboard.restaurants.show', $restaurant) }}"><img src="{{ asset('storage/restaurants/' . $restaurant->image) }}" class="store-image"></a></td>
                    <td><a href="{{ route('dashboard.restaurants.show', $restaurant) }}">{{ $restaurant->name }}</a></td>                            
                    <td>{{ $restaurant->address }}</td>
                    <td>{{ $restaurant->phone_number }}</td>
                    <td><a href="{{ route('dashboard.restaurants.edit', $restaurant) }}">編集</a></td>
                    <td>
                        <form action="{{ route('dashboard.restaurants.destroy', $restaurant) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-link text-dark p-0" onclick="return confirm('削除してもよいですか？');">削除</button>
                        </form>                                    
                    </td>
                </tr>  
            @endforeach
        </tbody>
    </table>                        

    <div>
        {{ $restaurants->appends(request()->query())->links() }}
    </div>
@endsection