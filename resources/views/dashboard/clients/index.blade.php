@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')
                <small>It's All Start Here</small>
            </h1>


            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li>@lang('site.clients')</li>
            </ol>

        </section> <!-- End Of content-header -->

        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('site.clients')</h3> <small>{{ $clients->total() }}</small>

                    <form action="{{ route('dashboard.clients.index') }}" method="get">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" placeholder="@lang('site.search')" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                                @if(auth()->user()->hasPermission('create_clients'))
                                    <a href="{{ route('dashboard.clients.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</a>
                                @else
                                    <button class="btn btn-primary disabled"><i class="fa fa-plus"></i> @lang('site.add')</button>
                                @endif
                            </div>
                        </div>
                    </form>

                </div> <!-- End Of Box Header -->
                <div class="box-body">
                    @if($clients->count() > 0)

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.add_order')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($clients as $index => $client)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ is_array($client->phone) ? implode($client->phone, '-') : $client->phone }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('create_orders'))
                                            <a href="{{{ route('dashboard.clients.orders.create', $client->id) }}}" class="btn btn-primary btn-sm">@lang('site.add_order')</a>
                                        @else
                                            <button class="btn btn-primary btn-sm disabled">@lang('site.add_order')</button>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasPermission('update_clients'))
                                            <a href="{{ route('dashboard.clients.edit', $client->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <button class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                                        @endif
                                        @if(auth()->user()->hasPermission('delete_clients'))
                                            <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="post" style="display: inline-block">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            </form>
                                        @else
                                                <button class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $clients->appends(request()->query())->links() }}
                    @else

                        <h1>@lang('site.no_data_found')</h1>

                    @endif

                </div> <!-- End Of Box Body -->
            </div> <!-- End Of Box -->


        </section> <!-- End Of Content -->

    </div> <!-- End Of content-wrapper -->

@endsection

