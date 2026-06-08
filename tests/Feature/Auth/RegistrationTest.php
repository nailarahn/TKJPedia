<?php

test('halaman registrasi dapat ditampilkan', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

test('registrasi gagal jika email sudah dipakai', function () {
    \App\Models\User::factory()->create(['email' => 'duplikat@example.com']);

    $response = $this->post('/register', [
        'name'                  => 'Orang Lain',
        'email'                 => 'duplikat@example.com',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('registrasi gagal jika password kurang dari 6 karakter', function () {
    $response = $this->post('/register', [
        'name'                  => 'Andi',
        'email'                 => 'andi@example.com',
        'password'              => '123',
        'password_confirmation' => '123',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertGuest();
});
