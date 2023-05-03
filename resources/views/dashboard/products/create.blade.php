@extends('layouts.dashboard.app')

@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
                <li class="active">@lang('site.add')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.add')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        @foreach (config('support_language.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.' . $lang . '.name')</label>
                                <input type="text" name="name[{{ $lang }}]" class="form-control"
                                    value="{{ old('name.' . $lang) }}">
                            </div>
                        @endforeach
                        @foreach (config('support_language.locales') as $lang)
                            <div class="form-group">
                                <label>@lang('site.' . $lang . '.description')</label>
                                <input type="text" name="description[{{ $lang }}]" class="form-control"
                                    value="{{ old('description.' . $lang) }}">
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label>@lang('site.category')</label>
                            <select class="form-control" name="cat_id" id="">
                                <option value="">---</option>
                                @forelse ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @empty

                                @endforelse

                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('site.image')</label>
                            <input type="file" name="image" class="form-control image">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/user_images/default.png') }}" style="width: 100px"
                                class="img-thumbnail image-preview" alt="">
                        </div>


                        <div class="form-group">
                            <label>@lang('site.purchase_price')</label>
                            <input type="integer" name="purchase_price" class="form-control"
                                value="{{ old('purchase_price') }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.sale_price')</label>
                            <input type="integer" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                        </div>
                        <div class="form-group">
                            <label>@lang('site.stock')</label>
                            <input type="integer" name="stock" class="form-control" value="{{ old('stock') }}">
                        </div>





                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>
                                @lang('site.add')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endsection
