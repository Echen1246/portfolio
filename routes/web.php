<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portfolio');
});

// Blog post routes
Route::get('/posts/building-scalable-web-applications', function () {
    return view('posts.building-scalable-web-applications');
})->name('posts.building-scalable-web-applications');

Route::get('/posts/future-of-frontend-development', function () {
    return view('posts.future-of-frontend-development');
})->name('posts.future-of-frontend-development');

Route::get('/posts/effective-api-design-principles', function () {
    return view('posts.effective-api-design-principles');
})->name('posts.effective-api-design-principles');

Route::get('/posts/the-memory-wall', function () {
    return view('posts.the-memory-wall');
})->name('posts.the-memory-wall');

Route::get('/posts/nurag-blog-post', function () {
    return view('posts.nurag-blog-post');
})->name('posts.nurag-blog-post');

Route::get('/posts/my-thoughts-on-general-intelligence', function () {
    return view('posts.my-thoughts-on-general-intelligence');
})->name('posts.my-thoughts-on-general-intelligence');

Route::get('/posts/gpt-e3-implementation', function () {
    return view('posts.gpt-e3-implementation');
})->name('posts.gpt-e3-implementation');

Route::get('/posts/ai-geopolitics', function () {
    return view('posts.ai-geopolitics');
})->name('posts.ai-geopolitics');

Route::get('/posts/my-first-swe-interview-lessons', function () {
    return view('posts.my-first-swe-interview-lessons');
})->name('posts.my-first-swe-interview-lessons');
