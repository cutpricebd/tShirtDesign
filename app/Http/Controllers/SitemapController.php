<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $product = Product::active()->first();
        $product_category = Category::active()->where('for', 'product')->first();
        $article = Blog::active()->first();
        $article_category = Category::active()->where('for', 'blog')->first();
        $page = Page::active()->first();
        $brand = Brand::active()->first();

        return response()->view('sitemap.index', compact('product', 'product_category', 'article', 'article_category', 'page', 'brand'))->header('Content-Type', 'text/xml');
    }

    public function products(){
        $products = Product::active()->get();

        return response()->view('sitemap.products', compact('products'))->header('Content-Type', 'text/xml');
    }

    public function productCategories(){
        $categories = Category::active()->where('for', 'product')->get();

        return response()->view('sitemap.productCategories', compact('categories'))->header('Content-Type', 'text/xml');
    }

    public function articles(){
        $articles = Blog::active()->get();

        return response()->view('sitemap.articles', compact('articles'))->header('Content-Type', 'text/xml');
    }

    public function articleCategories(){
        $categories = Category::active()->where('for', 'blog')->get();

        return response()->view('sitemap.articleCategories', compact('categories'))->header('Content-Type', 'text/xml');
    }

    public function brands(){
        $brands = Brand::active()->get();

        return response()->view('sitemap.brands', compact('brands'))->header('Content-Type', 'text/xml');
    }

    public function pages(){
        $pages = Page::active()->get();

        return response()->view('sitemap.pages', compact('pages'))->header('Content-Type', 'text/xml');
    }
}
