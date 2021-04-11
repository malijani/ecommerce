<?php

// Home
use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push(config('app.name' ?? 'فروشگاه'), route('home'));
});

// Home > Dashboard
Breadcrumbs::for('dashboard', function($trail){
    $trail->parent('home');
    $trail->push('داشبورد', route('dashboard.index'));
});


// Home > Dashboard > Orders
Breadcrumbs::for('dashboard.orders', function($trail){
    $trail->parent('dashboard');
    $trail->push('سفارش های کاربر', route('dashboard.orders.index'));
});

// Home > Dashboard > Addresses
Breadcrumbs::for('dashboard.addresses', function($trail){
    $trail->parent('dashboard');
    $trail->push('آدرس های کاربر', route('dashboard.addresses.index'));
});

// Home > Dashboard > Account
Breadcrumbs::for('dashboard.profile', function($trail){
    $trail->parent('dashboard');
    $trail->push('حساب کاربری', route('dashboard.profile.index'));
});

// Home > Cart
Breadcrumbs::for('cart', function($trail){
    $trail->parent('home');
    $trail->push('سبد خرید', route('cart.index'));
});

// Home > Address
Breadcrumbs::for('address', function($trail){
    $trail->parent('home');
    $trail->push('تعیین آدرس', route('address.index'));
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


// Home > Categories
Breadcrumbs::for('categories', function ($trail) {
    $trail->parent('home');
    $trail->push('دسته بندی ها', route('category.index'));
});

// Home > Categories > [Category]
Breadcrumbs::for('categories.category', function ($trail, $category) {
    $trail->parent('categories');
    $trail->push($category->title, route('category.show', $category->id));
});

// Home > Brands
Breadcrumbs::for('brands', function ($trail) {
    $trail->parent('home');
    $trail->push('برند ها', route('brand.index'));
});

// Home > Brands > [Brand]
Breadcrumbs::for('brands.brand', function ($trail, $brand) {
    $trail->parent('brands');
    $trail->push($brand->title, route('brand.show', $brand->id));
});

// Home > Products
Breadcrumbs::for('products', function ($trail) {
    $trail->parent('home');
    $trail->push('محصولات', route('product.index'));
});

// Home > Products > [Product]
Breadcrumbs::for('products.product', function ($trail, $product) {
    $trail->parent('products');
    $trail->push($product->title, route('product.show', $product->id));
});

