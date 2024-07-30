@extends('layouts.dashboard')

@section('content')                                                                                  
    <h1 class="mb-3">会社情報編集</h1>   
    <a href="{{ route('dashboard.companies.index') }}">< 戻る</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.companies.update', $company) }}" class="row">
        @csrf
        @method('patch')
        <div class="col-lg-7 form-group mb-3">
            <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">会社名</label>                    
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}" required>                    
        </div>       
        
        <div class="col-lg-7 form-group mb-3">
            <label for="representative" class="col-md-5 col-form-label text-md-left fw-bold">代表</label>                    
            <input type="text" class="form-control" id="representative" name="representative" value="{{ old('representative', $company->representative) }}" required>                    
        </div>                   
        
        <div class="col-lg-7 form-group mb-3">
            <label for="establishment_year" class="col-md-5 col-form-label text-md-left fw-bold">設立日</label>

            <div class="row g-1">
                <div class="col-auto">
                    <input type="number" class="form-control" id="establishment_year" name="establishment_year" value="{{ old('establishment_year', substr($company->establishment_date, 0, 4)) }}" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">年（西暦）</span></div>
                <div class="col-auto">
                    <input type="number" class="form-control" id="establishment_month" name="establishment_month" value="{{ old('establishment_month', substr($company->establishment_date, 5, 2)) }}" max="12" min="1" required> 
                </div>
                <div class="col-auto"><span class="form-control-plaintext">月</span></div>
                <div class="col-auto">  
                    <input type="number" class="form-control" id="establishment_day" name="establishment_day" value="{{ old('establishment_day', substr($company->establishment_date, 8, 2)) }}" max="31" min="1" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">日</span></div>             
            </div>
        </div>               

        <div class="col-lg-7 form-group mb-3">
            <label for="postal_code1" class="col-md-5 col-form-label text-md-left fw-bold">郵便番号</label>

            <div class="row g-1">
                <div class="col-auto"><span class="form-control-plaintext">〒</span></div>
                <div class="col-3">
                    <input type="number" class="form-control" id="postal_code1" name="postal_code1" value="{{ old('postal_code1', substr($company->postal_code, 0, 3)) }}" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">-</span></div>
                <div class="col-4">
                    <input type="number" class="form-control" id="postal_code2" name="postal_code2" value="{{ old('postal_code2', substr($company->postal_code, 3)) }}" required>
                </div>
            </div>
        </div>

        <div class="col-lg-7 form-group mb-3">
            <label for="address" class="col-md-5 col-form-label text-md-left fw-bold">住所</label>

            <div>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $company->address) }}" required>
            </div>
        </div>
        
        <div class="col-lg-7 form-group mb-3">
            <label for="business" class="col-md-5 col-form-label text-md-left fw-bold">事業内容</label>

            <div>
                <input type="text" class="form-control" id="business" name="business" value="{{ old('regular_holiday', $company->business) }}" required>
            </div>                    
        </div>          

        <div class="col-lg-7 form-group mb-4">
            <button type="submit" class="btn btn-primary text-white shadow-sm w-100">編集</button>
        </div>
    </form>                       
@endsection