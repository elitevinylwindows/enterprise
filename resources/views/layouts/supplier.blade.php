<!doctype html>
<html lang="en">
<head>
    @include('admin.head') {{-- or create a separate supplier_head if you prefer --}}
</head>

<body data-pc-theme="light" data-pc-sidebar-theme="light" data-pc-direction="ltr">

    {{-- Optional Header Section (you can replace/remove this as needed) --}}
    <header class="py-3 px-4 border-bottom bg-white">
        <h4 class="m-0">@yield('page-title', 'Supplier Portal')</h4>
    </header>

    {{-- Main Content --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Optional Footer --}}
    <footer class="text-center text-muted py-3">
        &copy; {{ date('Y') }} Elite Vinyl Windows
    </footer>

    {{-- Modals (optional, keep if needed) --}}
    <div class="modal fade" id="commonModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- dynamic content loads here -->
                </div>
            </div>
        </div>
    </div>

    {{-- JS Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1HiPTa92e6ozp6GAKU4OevkHyVS75j5b+K+04pGNI7p"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    {{-- Icons and Datatable Assets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

    {{-- Custom Scripts --}}
    @stack('scripts')
</body>
</html>
