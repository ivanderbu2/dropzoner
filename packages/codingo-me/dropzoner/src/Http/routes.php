<?php

$s = 'dropzoner.';
Route::post('dropzoner/upload', ['as' => $s . 'upload', 'uses' => 'DropzonerController@postUpload']);