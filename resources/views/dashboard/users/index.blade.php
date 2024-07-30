@extends('layouts.dashboard')

@section('content')          
    <h1 class="mb-3">会員一覧</h1>     
    
    <div class="d-flex mb-2">
        <form method="GET" action="{{ route('dashboard.users.index') }}" class="search-box mb-3">
            <div class="row">
                <div class="col-auto pe-2">
                    <input type="text" class="form-control" placeholder="氏名" name="keyword" value="{{ $keyword }}">
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
                <th scope="col">氏名</th>
                <th scope="col">メールアドレス</th>
                <th scope="col">電話番号</th>  
                <th scope="col">会員種別</th>                                                                                  
            </tr>
        </thead>   
        <tbody>                 
            @foreach($users as $user)  
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="{{ route('dashboard.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>  
                    <td>
                        @if ($subscriptions_query->where('user_id', $user->id)->exists() && $subscriptions_query->where('user_id', $user->id)->value('stripe_status') === 'active') 
                            有料会員
                        @else
                            無料会員
                        @endif
                    </td>                                                                                    
                </tr>  
            @endforeach
        </tbody>
    </table> 

    <div>
        {{ $users->appends(request()->query())->links() }}
    </div>                                           
@endsection