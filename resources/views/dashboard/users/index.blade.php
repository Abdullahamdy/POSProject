@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.users')</h1>

            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
                <li> @lang('site.users')</li>
            </ol>
        </section>

        <section class="content">
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header">
                        <h1 class="box-title">@lang('site.users')</h1>

                        <form action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" id="">

                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">@lang('site.search')</button>
                                    @if (auth()->user()->hasPermission('users-update'))
                                    <a href="{{ route('dashboard.users.create') }}"
                                        class="btn btn-primary btn-sm">@lang('site.add')</a>
                                        @endif
                                </div>
                            </div>
                        </form>

                    </div> <!-- end of box header -->
                    <div class="box-body">


                        @if ($users->count() > 0)
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.first_name')</th>
                                        <th>@lang('site.last_name')</th>
                                        <th>@lang('site.email')</th>
                                        <th>@lang('site.image')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td><img src="" style="width: 100px;" class="img-thumbnail"
                                                    alt=""></td>
                                            <td>
                                                @if (auth()->user()->hasPermission('users-update'))
                                                    <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                                        @lang('site.edit')</a>
                                                @else
                                                    <a href="#" class="btn btn-info btn-sm disabled"><i
                                                            class="fa fa-edit"></i> @lang('site.edit')</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('users-delete'))
                                                    <form action="{{ route('dashboard.users.destroy', $user->id) }}"
                                                        method="post" style="display: inline-block">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                        <button type="submit" class="btn btn-danger delete btn-sm"><i
                                                                class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    </form><!-- end of form -->
                                                @else
                                                    <button class="btn btn-danger btn-sm disabled"><i
                                                            class="fa fa-trash"></i> @lang('site.delete')</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table><!-- end of table -->
                        @else
                            <h1>@lang('site.no_data_found')</h1>
                        @endif






                    </div> <!-- end of box body -->
                </div> <!-- end of box  -->

            </section><!-- end of content -->




        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
@endsection

@push('scripts')
@endpush
