@extends('layouts.app')
@section('page-title')
    {{ __('Coupon') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page"> {{ __('Coupon') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card table-card">
                <div class="card-header">
                    <div class="row align-items-center g-2">
                        <div class="col">
                            <h5>{{ __('Coupon List') }}</h5>
                        </div>
                        @if (Gate::check('create coupon'))
                            <div class="col-auto">
                                <a href="#" class="btn btn-secondary customModal" data-size="lg"
                                    data-url="{{ route('coupons.create') }}" data-title="{{ __('Create Coupon') }}"> <i
                                        class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Coupon') }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="dt-responsive table-responsive">
                        <table class="table table-hover advance-datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Coupon Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Rate') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Valid For') }}</th>
                                    <th>{{ __('Use Limit') }}</th>
                                    <th>{{ __('Applicable Packages') }}</th>
                                    <th>{{ __('Total Used') }}</th>
                                    <th>{{ __('status') }}</th>
                                    @if (Gate::check('edit coupon') || Gate::check('delete coupon'))
                                        <th class="text-right">{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                    <tr role="row">
                                        <td> {{ $coupon->name }} </td>
                                        <td> {{ \App\Models\Coupon::$type[$coupon->type] }} </td>
                                        <td>{{ $coupon->rate }} </td>
                                        <td>{{ $coupon->code }} </td>
                                        <td>{{ dateFormat($coupon->valid_for) }} </td>
                                        <td>{{ $coupon->use_limit }} </td>
                                        <td>

                                            @foreach ($coupon->package($coupon->applicable_packages) as $package)
                                                <span class="badge bg-light-secondary ms-2 f-12"> {{ $package->title }} </span>
                                            @endforeach

                                        </td>
                                        <td>{{ $coupon->usedCoupon() }}</td>
                                        <td>
                                            @if ($coupon->status == 1)
                                                <span
                                                    class="badge bg-success ms-2 f-12">{{ \App\Models\Coupon::$status[$coupon->status] }}</span>
                                            @else
                                                <span
                                                    class="badge bg-danger ms-2 f-12">{{ \App\Models\Coupon::$status[$coupon->status] }}</span>
                                            @endif
                                        </td>
                                        @if (Gate::check('edit coupon') || Gate::check('delete coupon'))
                                            <td class="text-right">
                                                <div class="cart-action">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id]]) !!}

                                                    @if (Gate::check('edit coupon'))
                                                        <a class="avtar avtar-xs btn-link-secondary text-secondary customModal" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Edit') }}" data-size="lg"
                                                            href="#"
                                                            data-url="{{ route('coupons.edit', $coupon->id) }}"
                                                            data-title="{{ __('Edit Coupon') }}"> <i
                                                                data-feather="edit"></i></a>
                                                    @endif
                                                    @if (Gate::check('delete coupon'))
                                                        <a class=" avtar avtar-xs btn-link-danger text-danger confirm_dialog" data-bs-toggle="tooltip"
                                                            data-bs-original-title="{{ __('Detete') }}"
                                                            href="#"> <i data-feather="trash-2"></i></a>
                                                    @endif
                                                    {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
