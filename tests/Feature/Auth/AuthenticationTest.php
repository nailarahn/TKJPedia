<?php

use App\Models\User;

test('halaman login dapat ditampilkan', function () {
    $response = $this->get('/login');
    $response->assertStatus(200);
});

test('user tidak dapat login dengan password salah', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'login'    => $user->email,
        'password' => 'salah-banget',
    ]);

    $this->assertGuest();
});

test('user dapat logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect(route('landing'));
});
