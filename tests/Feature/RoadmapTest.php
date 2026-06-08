<?php

use App\Models\User;

test('guest diarahkan ke login saat akses halaman roadmap', function () {
    $response = $this->get(route('roadmap'));
    $response->assertRedirect('/login');
});

test('user yang login dapat melihat halaman roadmap', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('roadmap'));

    $response->assertStatus(200);
});
