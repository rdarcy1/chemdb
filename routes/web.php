<?php

// Search engine routes
Route::get('/', 'SearchController@index');
Route::post('/search/substructure', 'SearchController@substructureSearch');
Route::get('/search', 'SearchController@textSearch');

// Chemical Routes
Route::get('/chemical/new', 'ChemicalController@create');
Route::post('/chemicals', 'ChemicalController@store');
