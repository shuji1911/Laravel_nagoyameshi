<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => 'テスト',
            'postal_code' => '0000000',
            'address' => 'テスト',
            'representative' => 'テスト',
            'establishment_date' => 'テスト',
            'capital' => 'テスト',
            'business' => 'テスト',
            'number_of_employees' => 'テスト',
        ];
    }
}
