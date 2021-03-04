<?php

// Home
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(config('app.name' ?? 'فروشگاه'), route('home'));
});


// Home > Blog
Breadcrumbs::for('blog', function ($trail) {
    $trail->parent('home');
    $trail->push('وبلاگ', route('blog.index'));
});

// Home > Blog > [Article]
Breadcrumbs::for('blog.article', function ($trail, $article) {
    $trail->parent('blog');
    $trail->push($article->title, route('blog.show', $article->id));
});

//// Home > Category
//Breadcrumbs::for('category', function ($trail) {
//    $trail->parent('category');
//    $trail->push('دسته بندی ها', route('category.index'));
//});
//
