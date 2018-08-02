<?php

// Search engine routes
Route::get('/', 'SearchController@index');
Route::post('/search/substructure', 'SearchController@substructureSearch');

// Chemical Routes
Route::get('/chemical/new', 'ChemicalController@create');
Route::post('/chemicals', 'ChemicalController@store');
