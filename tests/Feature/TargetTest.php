<?php

use App\Models\User;

test('guest diarahkan ke login saat akses halaman target', function () {
    $response = $this->get(route('target'));
    $response->assertRedirect('/login');
});

test('user dapat melihat halaman target belajar', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('target'));

    $response->assertStatus(200);
});

test('user dapat membuka halaman buat target', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('target.create'));

    $response->assertStatus(200);
});
