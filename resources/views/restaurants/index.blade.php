@extends('layouts.app')

@section('content')  
    <div class="container">
        <h1 class="mb-3">店舗一覧</h1>         
            <form method="GET" action="{{ route('restaurants.index') }}" class="search-box mb-2">            
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <div class="me-2 mb-2">
                        <input type="text" class="form-control" placeholder="店名" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="me-2 mb-2 category-select">
                        <select class="form-control form-select" id="category_id" name="category_id">   
                            <option value="">カテゴリ</option>                                             
                            @foreach ($categories as $category) 
                                @if ($category->id == $category_id)                                       
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option> 
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option> 
                                @endif                                       
                            @endforeach                              
                        </select>    
                    </div>
                    <div class="mb-2">
                        <button type="submit" class="btn btn-primary shadow-sm text-nowrap">検索</button> 
                    </div>                                                     
                </div>                                                         
            </form>                
            <form method="GET" action="{{ route('restaurants.index') }}" class="mb-3 sort-box"> 
                @if ($keyword)
                    <input type="hidden" name="keyword" value="{{ $keyword }}">
                @endif
                @if ($category_id)
                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                @endif                                                                 
                <select class="form-select" name="sort_type" onChange="this.form.submit();">
                    @foreach ($sorts as $key => $value)
                        @if ($sorted === $value)
                            <option value="{{ $value }}" selected>{{ $key }}</option>
                        @else
                            <option value="{{ $value }}">{{ $key }}</option>
                        @endif                            
                    @endforeach
                </select>   
            </form>                                         
        <div class="row row-cols-xl-6 row-cols-md-3 row-cols-2 g-3 mb-2">
            @foreach ($restaurants as $restaurant)
                <div class="col">
                    <a href="{{ route('restaurants.show', $restaurant) }}"><img src="{{ asset('storage/restaurants/' . $restaurant->image) }}" class="w-100"></a>
                    <a href="{{ route('restaurants.show', $restaurant) }}" class="text-decoration-none"><h2 class="mb-0">{{ $restaurant->name }}</h2></a>
                    <p class="text-warning mb-2">{{ str_repeat('★', round($restaurant->reviews_avg_score)) }}</p>
                    <p class="mb-0">{{ $restaurant->category->name }}</p>
                    <p>{{ $restaurant->lowest_price }}円～{{ $restaurant->highest_price }}円</p>
                </div>            
            @endforeach
        </div>  
        <div>
            {{ $restaurants->appends(request()->query())->links() }}
        </div>                                                              
    </div>                                   
@endsection