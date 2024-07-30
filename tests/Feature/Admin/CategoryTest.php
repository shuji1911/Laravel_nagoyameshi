<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    // indexアクションのテスト
    public function test_unauthenticated_users_cannot_access_category_index()
    {
        $response = $this->get(route('admin.categories.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_cannot_access_category_index()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $response = $this->actingAs($user)->get(route('admin.categories.index'));
        $response->assertStatus(403); // Forbidden
    }

    public function test_authenticated_admin_can_access_category_index()
    {
        $admin = User::factory()->admin()->create(); // 管理者ユーザーを作成
        $response = $this->actingAs($admin)->get(route('admin.categories.index'));
        $response->assertStatus(200);
    }

    // storeアクションのテスト
    public function test_unauthenticated_users_cannot_store_category()
    {
        $response = $this->post(route('admin.categories.store'), [
            'name' => 'New Category',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_cannot_store_category()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $response = $this->actingAs($user)->post(route('admin.categories.store'), [
            'name' => 'New Category',
        ]);
        $response->assertStatus(403); // Forbidden
    }

    public function test_authenticated_admin_can_store_category()
    {
        $admin = User::factory()->admin()->create(); // 管理者ユーザーを作成
        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'New Category',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    // updateアクションのテスト
    public function test_unauthenticated_users_cannot_update_category()
    {
        $category = Category::factory()->create();
        $response = $this->put(route('admin.categories.update', $category->id), [
            'name' => 'Updated Category',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_cannot_update_category()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->put(route('admin.categories.update', $category->id), [
            'name' => 'Updated Category',
        ]);
        $response->assertStatus(403); // Forbidden
    }

    public function test_authenticated_admin_can_update_category()
    {
        $admin = User::factory()->admin()->create(); // 管理者ユーザーを作成
        $category = Category::factory()->create();
        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category->id), [
            'name' => 'Updated Category',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    // destroyアクションのテスト
    public function test_unauthenticated_users_cannot_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->delete(route('admin.categories.destroy', $category->id));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_users_cannot_delete_category()
    {
        $user = User::factory()->create(); // 一般ユーザーを作成
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->delete(route('admin.categories.destroy', $category->id));
        $response->assertStatus(403); // Forbidden
    }

    public function test_authenticated_admin_can_delete_category()
    {
        $admin = User::factory()->admin()->create(); // 管理者ユーザーを作成
        $category = Category::factory()->create();
        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category->id));
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
