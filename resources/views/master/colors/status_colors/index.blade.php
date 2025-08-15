@extends('layouts.app')

@section('page-title', __('Status Colors'))

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Status Colors') }}</li>
@endsection

@section('content')

<div class="mb-4"></div> {{-- Space after title --}}
<div class="mb-4"></div> {{-- Space --}}

<div class="row">
    {{-- Taskbar Card --}}
    <div class="col-md-2">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('color-options.status-colors.index', ['scope' => 'all']) }}"
                   class="list-group-item {{ ($scope ?? 'all') === 'all' ? 'active' : '' }}">
                    {{ __('All Colors') }}
                </a>
                <a href="{{ route('color-options.status-colors.index', ['scope' => 'deleted']) }}"
                   class="list-group-item text-danger {{ ($scope ?? '') === 'deleted' ? 'active' : '' }}">
                    {{ __('Deleted') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-sm-10">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col"><h5>{{ __('Status Colors') }}</h5></div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-primary customModal"
                           data-size="lg"
                           data-url="{{ route('color-options.status-colors.create') }}"
                           data-title="{{ __('Create Status Color') }}">
                           <i class="fa-solid fa-circle-plus"></i> {{ __('Create') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover advance-datatable">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Color Code') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Status Abbreviation') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statusColors as $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>
                                    <span class="sc-swatch me-2" style="background: {{ $color->color_code }}"></span>
                                    <code>{{ strtoupper($color->color_code) }}</code>
                                </td>
                                <td>{{ $color->department }}</td>
                                <td>{{ $color->status }}</td>
                                <td>{{ $color->status_abbr }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info customModal"
                                       data-size="lg"
                                       data-url="{{ route('color-options.status-colors.edit', $color->id) }}"
                                       data-title="{{ __('Edit Status Color') }}">
                                       <i data-feather="edit"></i>
                                    </a>

                                    <form action="{{ route('color-options.status-colors.destroy', $color->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('{{ __('Are you sure?') }}')">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- tiny swatch style --}}
<style>
.sc-swatch{
  display:inline-block; width:18px; height:18px; border-radius:4px;
  border:1px solid rgba(0,0,0,.15); vertical-align:middle;
}
</style>

<script>
      $(document).ready(function() {

        @if($errors->any())
            @foreach($errors->all() as $error)
            toastr.error('{{ $error }}', 'Error', {
                timeOut: 3000
                , progressBar: true
                , closeButton: true
            });
            @endforeach
        @endif

        @if(session('error'))
            toastr.error('{{ session('
                error ') }}', 'Error', {
                    timeOut: 3000
                    , progressBar: true
                    , closeButton: true
                });
        @endif
        @if(session('success'))
            toastr.success('{{ session('success ') }}', 'Success', {
                timeOut: 3000
                , progressBar: true
                , closeButton: true
            });
        @endif
    });
</script>

@endsection
