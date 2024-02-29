<?php

test('returns a successful response')
    ->get('/')
    ->assertSuccessful();
