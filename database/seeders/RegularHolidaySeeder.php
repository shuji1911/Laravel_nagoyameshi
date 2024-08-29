<?php

// database/seeders/RegularHolidaySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RegularHoliday;

class RegularHolidaySeeder extends Seeder
{
    public function run()
    {
        RegularHoliday::factory()->count(10)->create();  // 例えば10件のデータを作成
    }
}