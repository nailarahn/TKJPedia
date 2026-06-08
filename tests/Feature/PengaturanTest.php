<?php

use App\Models\User;

test('guest diarahkan ke login saat akses halaman pengaturan', function () {
    $response = $this->get(route('pengaturan.index'));
    $response->assertRedirect('/login');
});

test('user dapat melihat halaman pengaturan', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('pengaturan.index'));

    $response->assertStatus(200);
});

test('user dapat memperbarui profil', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->put(route('pengaturan.update'), [
        'name'    => 'Nama Baru',
        'email'   => 'emailbaru@example.com',
        'jurusan' => 'Rekayasa Perangkat Lunak',
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();

    $user->refresh();
    expect($user->name)->toBe('Nama Baru');
    expect($user->email)->toBe('emailbaru@example.com');
});

test('update profil gagal jika email sudah dipakai user lain', function () {
    $user  = User::factory()->create();
    User::factory()->create(['email' => 'sudahada@example.com']);

    $response = $this->actingAs($user)->put(route('pengaturan.update'), [
        'name'  => $user->name,
        'email' => 'sudahada@example.com',
    ]);

    $response->assertSessionHasErrors('email');
});
