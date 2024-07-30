<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $company = new Company();
        $company->name = 'NAGOYAMESHI株式会社';
        $company->representative = '侍太郎';
        $company->establishment_date = '2022-09-01';
        $company->postal_code = '1234567';
        $company->address = '東京都侍区侍町1-2-3';
        $company->business = '飲食店の検索・予約サービス';
        $company->save();
    }
}
