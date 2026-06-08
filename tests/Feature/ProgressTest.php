<?php

use App\Models\User;

test('guest diarahkan ke login saat akses halaman progress', function () {
    $response = $this->get(route('progress'));
    $response->assertRedirect('/login');
});

test('user dapat melihat halaman progress', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('progress'));

    $response->assertStatus(200);
});
