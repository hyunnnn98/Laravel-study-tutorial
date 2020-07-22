<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $password = 'password';     // 중복제거

    /** @test */
    public function a_user_can_be_register()
    {
        // 코드에 에러가 있으면 withoutExceptionHandling로 숨겨진 에러를 볼 수 있다.
        // $this->withoutExceptionHandling();

        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'password' => $this->password,
            'password_confirmation' => $this->password
        ];

        $response = $this->post('/api/register', $data);

        // assertJsonStructure 을 사용해 넘어온 JSON값의 Key Value 까지 확인 가능하다.
        $response->assertStatus(201)
            ->assertJsonStructure(['user']);

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }

    /** @test */
    public function a_user_can_log_in()
    {
        $this->passprotInstall();

        $user = factory(User::class)->create([
            'password' => Hash::make($this->password)
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $this->password
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'token',
                'user'
            ]);

        // 넘어온 토큰 값 DB에 존재하는지 검사. ( 로그인 기능 최종 검사 )
        // assertSame 는 Type + Value 체크
        $this->assertSame(1, DB::table('oauth_access_tokens')->count());
    }

    /** @test */
    public function a_user_can_log_out()
    {
        $this->passprotInstall();

        $user = factory(User::class)->create();

        $token = $user->createToken('Personal Access Token')->accessToken;

        // assertEquals 는 Type 이 달라도 Value 만 체크
        $this->assertEquals(0, DB::table('oauth_access_tokens')->first()->revoked);

        // 로그아웃할때는 header에 token 값을 실어서 보낸다.
        $response = $this->post('/api/logout', [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200)
            -> assertJsonStructure(['message', 'user']);

        // 로그 아웃 후 revoked 값이 1 로 변했는지 검사.
        $this->assertEquals(1, DB::table('oauth_access_tokens')->first()->revoked);
    }

    // 각 함수에서 중복되는 구문들은 private function 으로 따로 빼서
    // 소스코드 간결화 하자!
    private function passprotInstall() {
        $this->artisan('passport:install');
    }
}
