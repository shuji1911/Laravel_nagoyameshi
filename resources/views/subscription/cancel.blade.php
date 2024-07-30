@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">            
                <h1 class="mb-3">有料会員解約</h1>                                                       

                <p>有料会員を解約してもよいですか？</p>  
                <form id="cardForm" action="{{ route('subscription.destroy') }}" method="post">
                    @csrf                                
                    <button type="submit" class="btn btn-primary shadow-sm">解約</button>      
                </form>
            </div>                          
        </div>
    </div>       
@endsection