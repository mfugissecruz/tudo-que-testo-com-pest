<?php

test('testando o código 200')
    ->get('/')
    ->assertStatus(200)
    ->assertOk();

test('testando o código 404')
    ->get('/not-exists')
    ->assertStatus(404)
    ->assertNotFound();

test('testando o código 403')
    ->get('/403')
    ->assertStatus(403)
    ->assertForbidden();
