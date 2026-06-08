<?php

use App\Models\User;

test('guest diarahkan ke login saat akses dashboard', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect('/login');
});

test('user yang login dapat mengakses dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
});

test('dashboard berhasil load walaupun belum ada materi', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertStatus(200);
});
