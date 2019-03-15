<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('seller')->user();

    //dd($users);

    return view('seller.home');
})->name('home');

