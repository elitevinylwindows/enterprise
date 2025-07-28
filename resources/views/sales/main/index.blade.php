@extends('layouts.app')

@section('page-title')
    {{ __('Sales Dashboard') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Sales') }}</li>
@endsection


@section('content')
    <div class="row">
        
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Ribbon Interface</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .ribbon-button {
            min-width: 100px;
            background-color: #f8f9fa !important;
            color: #212529 !important;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="card shadow mb-4">
        <div class="card-body p-3">
            <ul class="nav nav-tabs mb-3 small" id="ribbonTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="production-tab" data-bs-toggle="tab" href="#production" role="tab">Production</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#crm" role="tab">CRM</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="setup-tab" data-bs-toggle="tab" href="#setup" role="tab">Setup</a>
                </li>
            </ul>

            <div class="tab-content" id="ribbonTabsContent">
                <div class="tab-pane fade show active" id="orders" role="tabpanel">
                    <div class="d-flex flex-wrap gap-2 mb-3 border-bottom pb-2">
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-users fa-2x d-block mb-1"></i>
                            <small>Customers</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-box fa-2x d-block mb-1"></i>
                            <small>Shipping</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-coins fa-2x d-block mb-1"></i>
                            <small>Pricing</small>
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3 border-bottom pb-2">
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-cube fa-2x d-block mb-1"></i>
                            <small>Products</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-pencil-ruler fa-2x d-block mb-1"></i>
                            <small>Designers</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-user-tie fa-2x d-block mb-1"></i>
                            <small>Vendors</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-warehouse fa-2x d-block mb-1"></i>
                            <small>Inventory</small>
                        </a>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-network-wired fa-2x d-block mb-1"></i>
                            <small>Interfaces</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-file-alt fa-2x d-block mb-1"></i>
                            <small>Reports</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-user-friends fa-2x d-block mb-1"></i>
                            <small>Employees</small>
                        </a>
                        <a href="#" class="btn text-center p-2 ribbon-button">
                            <i class="fas fa-ban fa-2x d-block mb-1"></i>
                            <small>Rejects</small>
                        </a>
                    </div>
                </div>

                <div class="tab-pane fade" id="production" role="tabpanel">Production tab content</div>
                <div class="tab-pane fade" id="crm" role="tabpanel">CRM tab content</div>
                <div class="tab-pane fade" id="setup" role="tabpanel">Setup tab content</div>
            </div>
        </div>
    </div>
</div>


    
    
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
@endsection



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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

@endpush