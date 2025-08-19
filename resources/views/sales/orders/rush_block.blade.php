@if (session('rush_block'))
  @php($rb = session('rush_block'))
  <div class="modal fade" id="rushBlockModal" tabindex="-1" aria-labelledby="rushBlockLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rushBlockLabel">Rush blocked</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="alert alert-warning mb-3">
            {{ $rb['message'] }} Please choose an option below.
          </div>

          <div class="d-flex gap-2 flex-wrap">
            {{-- Take Payment → open existing AJAX modal --}}
            <a href="#"
               class="btn btn-info text-white customModal"
               data-size="lg"
               data-title="Invoice Payment"
               data-url="{{ $rb['payment_url'] }}">
              <i data-feather="credit-card"></i> Take Payment
            </a>

            {{-- Special Customer → POST --}}
            <form action="{{ $rb['special_url'] }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-success">
                <i data-feather="star"></i> Special Order
              </button>
            </form>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Auto-show and refresh icons --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('rushBlockModal');
      if (el) {
        var m = bootstrap.Modal.getOrCreateInstance(el);
        m.show();
        if (window.feather) { feather.replace(); }
      }
    });
  </script>
@endif
