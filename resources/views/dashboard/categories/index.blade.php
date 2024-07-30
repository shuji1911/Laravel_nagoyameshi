@extends('layouts.dashboard')

@section('content')    
    <h1 class="mb-3">カテゴリ一覧</h1>  
    
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

    <form method="POST" action="{{ route('dashboard.categories.store') }}" class="row">
        @csrf
        <div class="col-md-4 form-group mb-3">
            <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">カテゴリ名</label>                    
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>                    
        </div> 
        <div class="form-group mb-4">
            <button type="submit" class="btn btn-primary text-white shadow-sm">作成</button>
        </div>        
    </form>        

    <div class="d-flex mb-2">
        <form method="GET" action="{{ route('dashboard.categories.index') }}" class="search-box mb-3">
            <div class="row">
                <div class="col-auto pe-2">
                    <input type="text" class="form-control" placeholder="カテゴリ名" name="keyword" value="{{ $keyword }}">
                </div>
                <div class="col-auto p-0">
                    <button type="submit" class="btn btn-primary text-white shadow-sm">検索</button> 
                </div>
            </div>               
        </form>                     
    </div>                                 
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">カテゴリ</th>                            
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>   
        <tbody> 
            @foreach($categories as $category)    
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', $category) }}">編集</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.destroy', $category) }}" method="post">
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
        {{ $categories->appends(request()->query())->links() }}
    </div>
@endsection