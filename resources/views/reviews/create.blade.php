@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-md-10">                
                <h1 class="mb-3">レビュー投稿</h1>   
                
                <div class="mb-3">
                    <a href="{{ route('restaurants.show', $restaurant) }}">< 戻る</a>     
                </div>                    
            
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif                
            
                <form method="POST" action="{{ route('restaurants.reviews.store', $restaurant) }}">
                    @csrf    
                    
                    <div class="mb-3">
                        <label class="form-label text-md-left fw-bold">評価</label>

                        <select name="score" class="form-select text-warning text-warning">
                            <option value="5" class="text-warning">★★★★★</option>
                            <option value="4" class="text-warning">★★★★</option>
                            <option value="3" class="text-warning">★★★</option>
                            <option value="2" class="text-warning">★★</option>
                            <option value="1" class="text-warning">★</option>
                        </select> 
                    </div>                 
                    
                    <div class="mb-4">
                        <label for="comment" class="form-label text-md-left fw-bold">コメント</label>

                        <div>
                            <textarea class="form-control" id="comment" name="comment" cols="30" rows="5">{{ old('comment') }}</textarea>                            
                        </div>
                    </div>                                                             

                    <div class="form-group mb-4">
                        <button type="submit" class="btn btn-primary shadow-sm">投稿</button>
                    </div>
                </form>                
            </div>                          
        </div>
    </div>   
@endsection