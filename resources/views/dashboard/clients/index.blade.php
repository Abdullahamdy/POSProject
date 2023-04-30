@extends('layouts.dashboard.app')
@section('content')
    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
                <li> @lang('site.clients')</li>
            </ol>
        </section>

        <section class="content">
            <section class="content">
                <div class="box box-primary">
                    <div class="box-header">
                        <h1 class="box-title">@lang('site.clients')</h1>

                        <form action="{{ route('dashboard.clients.index') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="search" value="{{ request()->search }}" id="">

                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">@lang('site.search')</button>
                                    @if (auth()->user()->hasPermission('clients-update'))
                                    <a href="{{ route('dashboard.clients.create') }}"
                                        class="btn btn-primary btn-sm">@lang('site.add')</a>
                                        @endif
                                </div>
                            </div>
                        </form>

                    </div> <!-- end of box header -->
                    <div class="box-body">


                        @if ($clients->count() > 0)
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('site.name')</th>
                                        <th>@lang('site.phone')</th>
                                        <th>@lang('site.address')</th>

                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($clients as $index => $client)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td>{{ $client->name }}</td>
                                            <td>{{ implode(',',array_filter($client->phone)) }}</td>
                                            <td>{{ $client->address }}</td>

                                            <td>
                                                @if (auth()->user()->hasPermission('clients-update'))
                                                    <a href="{{ route('dashboard.clients.edit', $client->id) }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                                        @lang('site.edit')</a>
                                                @else
                                                    <a href="#" class="btn btn-info btn-sm disabled"><i
                                                            class="fa fa-edit"></i> @lang('site.edit')</a>
                                                @endif
                                                @if (auth()->user()->hasPermission('clients-delete'))
                                                    <form action="{{ route('dashboard.clients.destroy', $client->id) }}"
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
                            {{ $clients->appends(request()->query())->links() }}
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