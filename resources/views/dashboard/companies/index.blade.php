@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-3">会社情報</h1>                                    

    <div class="mb-3">                    
        <div>
            <a href="{{ route('dashboard.companies.edit', $company) }}" class="btn btn-primary me-2">編集</a>                        
        </div>
    </div>     

    @if (session('flash_message')) 
        <div>
            <p class="text-success">{{ session('flash_message') }}</p>                    
        </div>                                   
    @endif     

    <div class="container mb-4">
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">会社名</span>
            </div>

            <div class="col">
                <span>{{ $company->name }}</span>
            </div>
        </div>  
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">代表者</span>
            </div>

            <div class="col">
                <span>{{ $company->representative }}</span>
            </div>
        </div> 
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">設立日</span>
            </div>

            <div class="col">
                <span>{{ $company->establishment_date }}</span>
            </div>
        </div>
        
        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">郵便番号</span>
            </div>

            <div class="col">
                <span>〒{{ $company->postal_code }}</span>
            </div>
        </div>       

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">住所</span>
            </div>

            <div class="col">
                <span>{{ $company->address }}</span>
            </div>
        </div>

        <div class="row pb-2 mb-2 border-bottom">
            <div class="col-3">
                <span class="fw-bold">事業内容</span>
            </div>

            <div class="col">
                <span>{{ $company->business }}</span>
            </div>
        </div>                                                          
    </div>                                                     
@endsection