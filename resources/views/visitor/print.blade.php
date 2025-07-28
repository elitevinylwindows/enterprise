<div class="pt-0 pb-3 modal-body pos-module" id="pass_print">
    <table class="table pos-module-tbl">
        <tbody>
        <div class="row">
            <div class="col">
                <img class="img-fluid"
                     src="{{asset(Storage::url('upload/logo/')).'/'.(isset($settings['company_logo']) && !empty($settings['company_logo'])?$settings['company_logo']:'logo.png')}}"
                     alt="">
            </div>
        </div>
        <div class="row text-end">
            <div class="text-left mt-10">
                {{$settings['company_name']}}<br>
                {{$settings['company_phone'] }}<br>
                {{$settings['company_email'] }}<br>
            </div>
        </div>

        <div class="invoice-to mt-2 product-border">
            <b>{{__('Visitor')}} :</b>
        </div>
        <div>
            {{$visitor->first_name.' '.$visitor->last_name}}
        </div>
        <div>
            {{$visitor->phone_number}}
        </div>
        <div>
            {{$visitor->email}}
        </div>

        </tbody>
    </table>

    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Visitor ID') }}:</div>
            <div class="text-end ms-auto"><b> {{visitorPrefix().$visitor->visitor_id}}</b></div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Visit Date') }}:</div>
            <div class="text-end ms-auto"> {{dateFormat($visitor->date)}}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Entry Time') }}:</div>
            <div class="text-end ms-auto"> {{timeFormat($visitor->entry_time)}}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Exit Time') }}:</div>
            <div class="text-end ms-auto">
                @if(!empty($visitor->exit_time))
                    {{timeFormat($visitor->exit_time)}}
                @else
                    -
                @endif
            </div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Category') }}:</div>
            <div class="text-end ms-auto">{{ !empty($visitor->categories)?$visitor->categories->title:'-' }}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Address') }}:</div>
            <div class="text-end ms-auto">{{ $visitor->address }}</div>
        </div>
    </div>
    <div class="mt-2">
        <div class="d-flex product-border">
            <div>{{ __('Notes') }}:</div>
            <div class="text-end ms-auto">{{ $visitor->notes }}</div>
        </div>
    </div>
</div>

<div class=" mt-2 modal-footer text-end">
    <a href="#" class="btn btn-secondary btn-sm text-right float-right mb-3 print-btn">
        {{ __('Print') }}
    </a>
</div>
<script>
    $(".print-btn").click(function () {
        document.getElementById("pass_print");
        $('.pc-sidebar').addClass('d-none');
        $('.pc-header').addClass('d-none');
        $('.pc-container').addClass('d-none');
        $('.pc-footer').addClass('d-none');
        $('.print-btn').addClass('d-none');

        $('#customModal').modal('hide');

        window.print();

        $('.pc-sidebar').removeClass('d-none');
        $('.pc-header').removeClass('d-none');
        $('.pc-container').removeClass('d-none');
        $('.pc-footer').removeClass('d-none');
        $('.print-btn').removeClass('d-none');
        $('#customModal').modal('hide')
    });
</script>




