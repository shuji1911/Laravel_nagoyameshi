@extends('layouts.dashboard')

@section('content')                                                                                 
    <h1 class="mb-3">店舗登録</h1>   
    <a href="{{ route('dashboard.restaurants.index') }}">< 戻る</a>                                    

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.restaurants.store') }}" class="row" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-7 form-group mb-3">
            <label for="name" class="col-md-5 col-form-label text-md-left fw-bold">店名</label>                    
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>                    
        </div> 

        <div class="col-lg-7 form-group mb-3">
            <label for="image" class="col-md-5 col-form-label text-md-left fw-bold">画像</label>                                        
            <input type="file" id="restaurantImage" name="image">                    
            <img src="#" class="w-100" id="restaurantImagePreview"> 
        </div>                                               

        <div class="col-lg-7 form-group mb-3">
            <label for="description" class="col-md-5 col-form-label text-md-left fw-bold">説明</label>                    
            <textarea class="form-control" id="description" name="description" cols="30" rows="5" required>{{ old('description') }}</textarea>                                                
        </div> 
        
        <div class="col-lg-7 form-group mb-3">
            <label for="lowest_price" class="col-md-5 col-form-label text-md-left fw-bold">価格</label>

            <div class="row g-1">
                <div class="col-auto">
                    <input type="number" class="form-control" id="lowest_price" name="lowest_price" value="{{ old('lowest_price') }}" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">円</span></div>
                <div class="col-auto"><span class="form-control-plaintext">～</span></div>
                <div class="col-auto">
                    <input type="number" class="form-control" id="highest_price" name="highest_price" value="{{ old('highest_price') }}" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">円</span></div>
            </div>

        </div> 
        
        <div class="col-lg-7 form-group mb-3">
            <label for="opening_hour" class="col-md-5 col-form-label text-md-left fw-bold">営業時間</label>

            <div class="row g-1">
                <div class="col-auto">
                    <input type="number" class="form-control" id="opening_hour" name="opening_hour" value="{{ old('opening_hour') }}" max="23" min="0" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">時</span></div>
                <div class="col-auto">
                    <input type="number" class="form-control" id="opening_minute" name="opening_minute" value="{{ old('opening_minute') }}" max="59" min="0" required> 
                </div>
                <div class="col-auto"><span class="form-control-plaintext">分～</span></div>
                <div class="col-auto">  
                    <input type="number" class="form-control" id="closing_hour" name="closing_hour" value="{{ old('closing_hour') }}" max="23" min="0" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">時</span></div>
                <div class="col-auto">
                    <input type="number" class="form-control" id="closing_minute" name="closing_minute" value="{{ old('closing_minute') }}" max="59" min="0" required>      
                </div>
                <div class="col-auto"><span class="form-control-plaintext">分</span></div>              
            </div>
        </div>               

        <div class="col-lg-7 form-group mb-3">
            <label for="postal_code1" class="col-md-5 col-form-label text-md-left fw-bold">郵便番号</label>

            <div class="row g-1">
                <div class="col-auto"><span class="form-control-plaintext">〒</span></div>
                <div class="col-3">
                    <input type="number" class="form-control" id="postal_code1" name="postal_code1" value="{{ old('postal_code1') }}" required>
                </div>
                <div class="col-auto"><span class="form-control-plaintext">-</span></div>
                <div class="col-4">
                    <input type="number" class="form-control" id="postal_code2" name="postal_code2" value="{{ old('postal_code2') }}" required>
                </div>
            </div>
        </div>

        <div class="col-lg-7 form-group mb-3">
            <label for="address" class="col-md-5 col-form-label text-md-left fw-bold">住所</label>

            <div>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
            </div>
        </div>

        <div class="col-lg-7 form-group mb-3">
            <label for="phone_number" class="col-md-5 col-form-label text-md-left fw-bold">電話番号</label>

            <div class="row g-1">
                <div class="col-3">
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
                </div>
            </div>
        </div>
        
        <div class="col-lg-7 form-group mb-3">
            <label for="regular_holiday" class="col-md-5 col-form-label text-md-left fw-bold">定休日</label>

            <div>
                <input type="text" class="form-control" id="regular_holiday" name="regular_holiday" value="{{ old('regular_holiday') }}" required>
            </div>                    
        </div>   
        
        <div class="col-lg-7 form-group mb-4">
            <label for="category_id" class="col-md-5 col-form-label text-md-left fw-bold">カテゴリ</label>

            <div>
                <select class="form-control form-select" id="category_id" name="category_id">                                                
                    @foreach ($categories as $category)                                        
                        @if ($category->id == old("category_id"))                                        
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach                              
                </select>                                
            </div>                    
        </div>         

        <div class="col-lg-7 form-group mb-4">
            <button type="submit" class="btn btn-primary text-white shadow-sm w-100">登録</button>
        </div>
    </form>            

    <script type="text/javascript">
        document.getElementById('restaurantImage').addEventListener('change', () => {
            if (document.getElementById('restaurantImage').files[0]) {
                let fileReader = new FileReader();
                fileReader.onload = () => {
                    document.getElementById('restaurantImagePreview').setAttribute('src', fileReader.result);
                }
                fileReader.readAsDataURL(document.getElementById('restaurantImage').files[0]);
            }
        })
    </script>              
@endsection