@extends('back.layouts.master')
@section('title', 'Main Menu')

@section('head')
  <link rel="stylesheet" href="{{asset('back/css/category-header.css')}}">
@endsection

@section('master')
<div class="card border-light mt-3 shadow">
    <div class="card-header no_icon">
        <h5>Main Menu</h5>
    </div>

    <div class="card-body">
        <div class="menu_style_a">
            <ul class="npnls">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{route('back.products.create')}}?category={{$category->id}}&cat_type=cat" class="d-inline-block">{{$category->title}} <i class="fas fa-plus" title="Add Product"></i></a>

                        <ul>
                            @foreach ($category->Categories as $sub_category)
                                <li>
                                    <a href="{{route('back.products.create')}}?category={{$sub_category->id}}&cat_type=sub_cat">{{$sub_category->title}} <i class="fas fa-plus" title="Add Product"></i></a>

                                    <ul>
                                        @foreach ($sub_category->Categories as $sub_category)
                                            <li><a href="{{route('back.products.create')}}?category={{$sub_category->id}}&cat_type=sub_sub_cat">{{$sub_category->title}} <i class="fas fa-plus" title="Add Product"></i></a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection

