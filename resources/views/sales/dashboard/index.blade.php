@extends('layouts.app')

@section('page-title')
    {{ __('Sales Dashboard') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Sales') }}</li>
@endsection


@section('content')
<div class="mb-4"></div> {{-- Space --}}




    <div class="row">
        
   <!-- <div class="row mb-4 align-items-center">
        <div class="col-md-10">
        </div>
        <div class="col-md-3 text-end">
            <button class="btn btn-danger w-100" style="height: 45px;">Action</button>
        </div>
         <div class="col-md-2">
            <input type="text" class="form-control" placeholder="Search...">
        </div>
    </div>-->
    
    
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-secondary">
                                <i class="ti ti-users f-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Quotes') }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"></h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-warning">
                                <i class="ti ti-package f-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Orders') }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-primary">
                                <i class="ti ti-history f-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Invoices') }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar bg-light-danger">
                                <i class="ti ti-credit-card f-24"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1">{{ __('Total Completed') }}</p>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    
    

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <h5 class="mb-1">{{ __('Chart') }}</h5>
                            {{-- <p class="text-muted mb-2">{{ __('Users and Payments Overview') }}</p> --}}
                        </div>

                    </div>
                    <div id="deliveries_chart"></div>
                </div>
            </div>
        </div>

    </div>








<div class="mb-4"></div> {{-- Space --}}


    
    
<div class="row">
    {{-- Left Column Card (Sidebar content or metrics) --}}
    <div class="col-md-12">
        <div class="card h-100">
            <div class="card-header">
                <h5>{{ __('Chart') }}</h5>
            </div>
           
        </div>
    </div>
    <div class="mb-4"></div> {{-- Space --}}

    {{-- Left Column Card (Sidebar content or metrics) --}}
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">
                <h5>{{ __('Quick Stats') }}</h5>
            </div>
            <div class="card-body">
                <p>Total Quotes: <strong>123</strong></p>
                <p>Total Orders: <strong>89</strong></p>
                <p>Total Invoices: <strong>47</strong></p>
            </div>
        </div>
    </div>

    {{-- Right Column with 2 stacked cards --}}
    <div class="col-md-9">
        {{-- Top Right Card --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5>{{ __('Recent Quotes') }}</h5>
            </div>
            <div class="card-body">
                <p>No recent quotes available.</p>
            </div>
        </div>

        {{-- Bottom Right Card --}}
        <div class="card">
            <div class="card-header">
                <h5>{{ __('Recent Orders') }}</h5>
            </div>
            <div class="card-body">
                <p>No recent orders available.</p>
            </div>
        </div>
    </div>
</div>

<div class="mb-4"></div> {{-- Space --}}

@endsection


@push('styles')
<style>
    .ribbon-tile {
        display: inline-block;
        width: 100px;
        height: 75px;
        padding: 8px;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
        color: #212529;
        font-size: 12px;
        text-align: center;
        text-decoration: none;
        border-radius: 3px;
    }

    .ribbon-tile:hover {
        background-color: #e2e6ea;
    }

    .ribbon-divider {
        border-bottom: 1px solid #ccc;
        margin: 10px 0;
    }
</style>
@endpush

@push('script-page')
    <script>
        var options = {
            chart: {
                height: 452,
                type: 'line',
                toolbar:{
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#2ca58d', '#0a2342'],
            dataLabels: {
                enabled: false
            },
            legend: {
                show: true,
                position: 'top'
            },
            markers: {
                size: 1,
                colors: ['#fff', '#fff', '#fff'],
                strokeColors: ['#2ca58d', '#0a2342'],
                strokeWidth: 1,
                shape: 'circle',
                hover: {
                    size: 4
                }
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    type: 'vertical',
                    inverseColors: false,
                    opacityFrom: 0.5,
                    opacityTo: 0
                }
            },
            grid: {
                show: false
            },
            series: [{
                name: "{{__('Total Deliveries')}}",
                type: 'column',
                data: ,
                // data: [10,20,30,40,50,60,70,80,90,100,110,120,130,140],
            }],
            xaxis: {
                categories: ,
                tooltip: {
                    enabled: false
                },
                labels: {
                    hideOverlappingLabels: true
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            }
        };
        var chart = new ApexCharts(document.querySelector('#deliveries_chart'), options);
        chart.render();


    </script>
@endpush