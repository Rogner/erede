<?php

const EREDE_CONTROLER = 'Rogner\Erede\Http\Controllers\EredeController@';

Route::group(['middleware' => ['web']], function () {
    Route::prefix('erede')->group(function () {
        Route::get('/redirect', EREDE_CONTROLER . 'redirect')->name('erede.redirect');
        Route::post('/pay', EREDE_CONTROLER . 'pay')->name('erede.pay');
    });
});
