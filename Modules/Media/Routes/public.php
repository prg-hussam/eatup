<?php

use Illuminate\Support\Facades\Route;

Route::get('media/{id}/download', [
    'as' => 'media.download',
    'uses' => 'MediaController@download',
]);
