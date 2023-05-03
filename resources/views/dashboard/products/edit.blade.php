@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.update', $product->id) }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        @foreach (config('support_language.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.' . $lang . '.name')</label>
                                <input type="text" name="name[{{ $lang }}]" class="form-control"
                                    value="{{ $product->Namelang[$lang] }}">
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>@lang('site.category')</label>
                            <select class="form-control" name="cat_id" id="">
                                <option value="" disabled>---</option>
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : false }}>{{ $category->name }}</option>
                                @empty

                                @endforelse

                            </select>
                        </div>
                        @foreach (config('support_language.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.' . $lang . '.name')</label>
                                <input type="text" name="description[{{ $lang }}]" class="form-control"
                                    value="{{ $product->Descriptionlang[$lang] }}">
                            </div>
                        @endforeach
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>
                        <div class="form-group">
                            <img src="{{ $product->image_path }}" style="width: 100px" class="img-thumbnail image-preview" alt="">
                        </div>



                        <div class="form-group">
                            <label>@lang('site.purchase_price')</label>
                            <input type="integer" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.sale_price')</label>
                            <input type="integer" name="sale_price" class="form-control" value="{{ $product->sale_price }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="integer" name="stock" class="form-control" value="{{$product->stock}}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
