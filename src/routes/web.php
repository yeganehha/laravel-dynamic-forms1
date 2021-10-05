<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Yeganehha\DynamicForms\app\Http\Controllers'],function (){
    Route::get('dynamicForms/files/dl' , 'filesController@dl')->name('dynamicForms.dl')->middleware('signed');
});

