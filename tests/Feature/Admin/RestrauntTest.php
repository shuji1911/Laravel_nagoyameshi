<?php

namespace Tests\Feature\Admin;

use App\Models\Restaurant;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;


class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function not_logged_in_user_cannot_access_restaurant_index_page()
    {
        $response = $this->get(route('admin.restaurants.index'));
        $response->assertRedirect('admin/login');

        $response = $this->get(route('admin.restaurants.index'));
    $response->assertStatus(302);
    }

    /** @test */
    public function regular_user_cannot_access_restaurant_index_page()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $response = $this->actingAs($user)->get(route('admin.restaurants.index'));
        $response->assertStatus(302); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_access_restaurant_index_page()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $response = $this->actingAs($admin)->get(route('admin.restaurants.index'));
        $response->assertStatus(302);
    }

    /** @test */
    public function not_logged_in_user_cannot_access_restaurant_show_page()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.show', $restaurant));
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_access_restaurant_show_page()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.restaurants.show', $restaurant));
        $response->assertStatus(302); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_access_restaurant_show_page()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($admin)->get(route('admin.restaurants.show', $restaurant));
        $response->assertStatus(200);
    }

    /** @test */
    public function not_logged_in_user_cannot_access_restaurant_create_page()
    {
        $response = $this->get(route('admin.restaurants.create'));
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_access_restaurant_create_page()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $response = $this->actingAs($user)->get(route('admin.restaurants.create'));
        $response->assertStatus(302); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_access_restaurant_create_page()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $response = $this->actingAs($admin)->get(route('admin.restaurants.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function not_logged_in_user_cannot_store_restaurant()
    {
        $response = $this->post(route('admin.restaurants.store'), $this->validRestaurantData());
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_store_restaurant()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $response = $this->actingAs($user)->post(route('admin.restaurants.store'), $this->validRestaurantData());
        $response->assertStatus(500); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_store_restaurant()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $response = $this->actingAs($admin)->post(route('admin.restaurants.store'), $this->validRestaurantData());
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDatabaseHas('restaurants', $this->validRestaurantData());
    }

    /** @test */
    public function not_logged_in_user_cannot_access_restaurant_edit_page()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->get(route('admin.restaurants.edit', $restaurant));
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_access_restaurant_edit_page()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->get(route('admin.restaurants.edit', $restaurant));
        $response->assertStatus(302); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_access_restaurant_edit_page()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($admin)->get(route('admin.restaurants.edit', $restaurant));
        $response->assertStatus(302);
    }

    /** @test */
    public function not_logged_in_user_cannot_update_restaurant()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->put(route('admin.restaurants.update', $restaurant), $this->validRestaurantData());
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_update_restaurant()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->put(route('admin.restaurants.update', $restaurant), $this->validRestaurantData());
        $response->assertStatus(500); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_update_restaurant()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($admin)->put(route('admin.restaurants.update', $restaurant), $this->validRestaurantData());
        $response->assertRedirect(route('admin.restaurants.show', $restaurant));
        $this->assertDatabaseHas('restaurants', $this->validRestaurantData());
    }

    /** @test */
    public function not_logged_in_user_cannot_delete_restaurant()
    {
        $restaurant = Restaurant::factory()->create();
        $response = $this->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertRedirect('admin/login');
    }

    /** @test */
    public function regular_user_cannot_delete_restaurant()
    {
        $user = User::factory()->create(); // ここで一般ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($user)->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertStatus(500); // 権限なしエラー
    }

    /** @test */
    public function admin_user_can_delete_restaurant()
    {
        $admin = User::factory()->admin()->create(); // ここで管理者ユーザーを作成
        $restaurant = Restaurant::factory()->create();
        $response = $this->actingAs($admin)->delete(route('admin.restaurants.destroy', $restaurant));
        $response->assertRedirect(route('admin.restaurants.index'));
        $this->assertDeleted($restaurant);
    }

    protected function validRestaurantData()
    {
        return [
            'name' => 'テスト',
            'description' => 'テスト',
            'lowest_price' => 1000,
            'highest_price' => 5000,
            'postal_code' => '0000000',
            'address' => 'テスト',
            'opening_time' => '10:00:00',
            'closing_time' => '20:00:00',
            'seating_capacity' => 50,
        ];
    }
}
