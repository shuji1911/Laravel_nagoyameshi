@extends('layouts.dashboard')

@section('content')    
    <h1 class="mb-3">カテゴリ編集</h1>  
    
    <a href="{{ route('dashboard.categories.index') }}">< 戻る</a>   

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif     

    <form method="POST" action="{{ route('dashboard.categories.update', $category) }}" class="row">
        @csrf
        @method('patch')
        <div class="col-md-4 form-group mb-3">
            <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">カテゴリ名</label>                    
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>                    
        </div> 
        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary text-white shadow-sm">編集</button>
        </div>        
    </form> 
@endsection    