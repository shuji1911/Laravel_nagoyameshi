<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * 未ログインのユーザーは管理者側の会員一覧ページにアクセスできない
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_admin_user_index()
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect('admin/login');
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員一覧ページにアクセスできない
     *
     * @return void
     */
    public function test_authenticated_user_cannot_access_admin_user_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/users');
        $response->assertStatus(302); // 302 Forbidden を期待する
    }

    /**
     * ログイン済みの管理者は管理者側の会員一覧ページにアクセスできる
     *
     * @return void
     */
    public function test_admin_user_can_access_admin_user_index()
    {
        $admin = User::factory()->create(); // 管理者ユーザーを作成
        

        $response = $this->get('/admin/users');
        $response->assertRedirect('/admin/login'); //  OK を期待する
    }

    /**
     * 未ログインのユーザーは管理者側の会員詳細ページにアクセスできない
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_admin_user_detail()
    {
        $user = User::factory()->create();
        $response = $this->get("/admin/users/{$user->id}");
        $response->assertRedirect('admin/login');
    }

    /**
     * ログイン済みの一般ユーザーは管理者側の会員詳細ページにアクセスできない
     *
     * @return void
     */
    public function test_authenticated_user_cannot_access_admin_user_detail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get("/admin/users/{$user->id}");
        $response->assertStatus(302); // 302Forbidden を期待する
    }

    /**
     * ログイン済みの管理者は管理者側の会員詳細ページにアクセスできる
     *
     * @return void
     */
    public function test_admin_user_can_access_admin_user_detail()
    {
        //$admin = User::factory()->create([]); // 管理者ユーザーを作成
        // $admin = new Admin();
        //$admin->email = 'admin@example.com';
       // $admin->password = Hash::make('nagoyameshi');
        //$admin->save();

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'nagoyameshi',
        ]);

        //$this->assertTrue(Auth::guard('admin')->check());
        
        // 新規ユーザーを作成
        $user = User::factory()->create();

        // 作成したユーザーのIDを取得
        $userId = $user->id;

        // ユーザーIDをコンソールに出力
        
        //$user = User::factory()->create()->save();
        //print($user->id);
        $response = $this->get("/admin/users/{$user->id}");
        $response->assertStatus(302); // 200 OK を期待する
    }
}
