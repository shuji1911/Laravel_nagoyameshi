<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Restaurant;
use App\Models\RegularHoliday;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate'); // マイグレーションを実行
    }

    // 未ログインのユーザーは店舗を登録できない
    public function test_guest_cannot_store_restaurant()
    {
        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'Test Restaurant',
            // その他の必須データ
        ]);

        $response->assertRedirect('/login'); // ログインページにリダイレクトされるべき
    }

    // ログイン済みの一般ユーザーは店舗を登録できない
    public function test_authenticated_user_cannot_store_restaurant()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $this->actingAs($user);

        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'Test Restaurant',
            // その他の必須データ
        ]);

        $response->assertStatus(403); // アクセス拒否エラーが返されるべき
    }

    // ログイン済みの管理者は店舗を登録できる
    public function test_admin_can_store_restaurant()
    {
        $admin = Admin::factory()->create(); // 管理者を作成
        $this->actingAs($admin, 'admin');

        // 定休日データとカテゴリーデータを作成
        $regularHoliday = RegularHoliday::factory()->create(); // 定休日を作成
        $categories = Category::factory()->count(3)->create(); // カテゴリを作成

        $response = $this->post(route('admin.restaurants.store'), [
            'name' => 'Test Restaurant',
            'category_ids' => $categories->pluck('id')->toArray(),
            'regular_holiday_ids' => [$regularHoliday->id],
            'description' => 'Test Description',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '1234567',
            'address' => 'Test Address',
            'opening_time' => '09:00',
            'closing_time' => '22:00',
            'seating_capacity' => 50,
        ]);

        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', ['name' => 'Test Restaurant']);
        $this->assertDatabaseHas('regular_holiday_restaurant', ['regular_holiday_id' => $regularHoliday->id]);
    }

    // 未ログインのユーザーは店舗を更新できない
    public function test_guest_cannot_update_restaurant()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->patch(route('admin.restaurants.update', $restaurant), [
            'name' => 'Updated Restaurant',
            // その他の必須データ
        ]);

        $response->assertRedirect('/login'); // ログインページにリダイレクトされるべき
    }

    // ログイン済みの一般ユーザーは店舗を更新できない
    public function test_authenticated_user_cannot_update_restaurant()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $this->actingAs($user);

        $restaurant = Restaurant::factory()->create();

        $response = $this->patch(route('admin.restaurants.update', $restaurant), [
            'name' => 'Updated Restaurant',
            // その他の必須データ
        ]);

        $response->assertStatus(403); // アクセス拒否エラーが返されるべき
    }

    // ログイン済みの管理者は店舗を更新できる
    public function test_admin_can_update_restaurant()
    {
        $admin = Admin::factory()->create(); // 管理者を作成
        $this->actingAs($admin, 'admin');

        $restaurant = Restaurant::factory()->create();
        $regularHoliday = RegularHoliday::factory()->create(); // 定休日を作成
        $categories = Category::factory()->count(3)->create(); // カテゴリを作成

        $response = $this->patch(route('admin.restaurants.update', $restaurant), [
            'name' => 'Updated Restaurant',
            'category_ids' => $categories->pluck('id')->toArray(),
            'regular_holiday_ids' => [$regularHoliday->id],
            'description' => 'Updated Description',
            'lowest_price' => 1500,
            'highest_price' => 6000,
            'postal_code' => '7654321',
            'address' => 'Updated Address',
            'opening_time' => '10:00',
            'closing_time' => '23:00',
            'seating_capacity' => 60,
        ]);

        $response->assertRedirect(route('admin.restaurants.show', $restaurant));
        $this->assertDatabaseHas('restaurants', ['name' => 'Updated Restaurant']);
        $this->assertDatabaseHas('regular_holiday_restaurant', ['regular_holiday_id' => $regularHoliday->id]);
    }
}
