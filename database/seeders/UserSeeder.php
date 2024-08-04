<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 既存のデータを削除
        DB::table('users')->delete();

        // ユーザーファクトリーで100件のデータを作成
        User::factory()->count(100)->create();

        // デフォルトのユーザーを追加
        DB::table('users')->insert([
            'name' => '小谷 柊二',
            'kana' => 'コタニ シュウジ',
            'email' => 'shumiyu0225@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ttcsk1125'), // パスワードはハッシュ化する必要があります
            'postal_code' => '123-4567',
            'address' => '123 Default St, Default City',
            'phone_number' => '090-1234-5678',
            'birthday' => '1990-01-01',
            'occupation' => 'Default Occupation',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
