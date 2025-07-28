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

<div class="card shadow mb-4">
            <div class="card-body p-3">
                <!-- Ribbon Tabs -->
                <ul class="nav nav-tabs mb-3 small" id="ribbonTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="production-tab" data-bs-toggle="tab" href="#production" role="tab">Production</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#rma" role="tab">RMA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#purchasing" role="tab">Purchasing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#inventory" role="tab">Inventory</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#reports" role="tab">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#accounting" role="tab">Accounting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#projects" role="tab">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="crm-tab" data-bs-toggle="tab" href="#crm" role="tab">CRM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="setup-tab" data-bs-toggle="tab" href="#setup" role="tab">Setup</a>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="ribbonTabsContent">
                    <!-- Setup Tab -->
                    <div class="tab-pane fade show active" id="setup" role="tabpanel">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-users fa-lg d-block mb-1"></i>
        <span>Customers</span>
    </a>
    <div class="vr mx-2"></div> <!-- Vertical line between groups -->

    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-truck fa-lg d-block mb-1"></i>
        <span>Shipping</span>
    </a>
    <div class="vr mx-2"></div> <!-- Vertical line between groups -->

    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Pricing</span>
    </a>
    <div class="vr mx-2"></div> <!-- Vertical line between groups -->
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Products</span>
    </a>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Designers</span>
    </a>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Vendors</span>
    </a>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Inventory</span>
    </a>
    <div class="vr mx-2"></div>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Interfaces</span>
    </a>
    <div class="vr mx-2"></div>

    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>xxx</span>
    </a>
    
    <div class="vr mx-2"></div>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Rejects</span>
    </a>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>Capacity Planning</span>
    </a>
    <div class="vr mx-2"></div>
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>CRM</span>
    </a>
    <div class="vr mx-2"></div>
    
    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>xxx</span>
    </a>
    <div class="vr mx-2"></div>

    <a href="#" class="ribbon-tile text-center">
        <i class="fas fa-coins fa-lg d-block mb-1"></i>
        <span>System</span>
    </a>
</div>

                    </div>

                    <!-- Production Tab -->
                    <div class="tab-pane fade" id="production" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-cube fa-2x d-block mb-1"></i>
                                <small>Products</small>
                            </a>
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-pencil-ruler fa-2x d-block mb-1"></i>
                                <small>Designers</small>
                            </a>
                        </div>
                    </div>

                    <!-- CRM Tab -->
                    <div class="tab-pane fade" id="crm" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-address-book fa-2x d-block mb-1"></i>
                                <small>Contacts</small>
                            </a>
                        </div>
                    </div>

                    <!-- Setup Tab -->
                    <div class="tab-pane fade" id="setup" role="tabpanel">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="#" class="btn text-center p-2" style="min-width: 100px; background-color: #f8f9fa !important; color: #212529 !important; border: 1px solid #dee2e6;">
                                <i class="fas fa-cogs fa-2x d-block mb-1"></i>
                                <small>System</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



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