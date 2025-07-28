<div class="modal-body">
    <div class="product-card">
        <div class="row ">
            <div class="col">
                <div class="col-auto text-end ">
                    <a class="btn btn-warning customModal-2 me-2" data-size="sm" href="javascript:void(0);"
                       data-url="{{ route('visitor.pass.print',$visitor->id) }}"
                       data-title="{{__('Visitor Pass')}}" data-ajax-popup="true"><i
                            class="fa fa-print"></i> {{__('Visitor Pass Print')}}</a>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('ID')}}</h6>
                        <p class="mb-20">{{visitorPrefix().$visitor->visitor_id}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Name')}}</h6>
                        <p class="mb-20">{{$visitor->first_name.' '.$visitor->last_name}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Email')}}</h6>
                        <p class="mb-20">{{$visitor->email}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Phone Number')}}</h6>
                        <p class="mb-20">{{$visitor->phone_number}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Gender')}}</h6>
                        <p class="mb-20">{{$visitor->gender}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Visit Date')}}</h6>
                        <p class="mb-20">  {{dateFormat($visitor->date)}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Entry Time')}}</h6>
                        <p class="mb-20"> {{timeFormat($visitor->entry_time)}}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Exit Time')}}</h6>
                        <p class="mb-20">
                            @if(!empty($visitor->exit_time))
                                {{timeFormat($visitor->exit_time)}}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Category')}}</h6>
                        <p class="mb-20"> {{ !empty($visitor->categories)?$visitor->categories->title:'-' }}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Status')}}</h6>
                        <p class="mb-20">
                            @if($visitor->status=='pending')
                                <span
                                    class="d-inline badge text-bg-primary">{{\App\Models\Visitor::$status[$visitor->status]}}</span>
                            @elseif($visitor->status=='cancelled')
                                <span
                                    class="d-inline badge text-bg-warning">{{\App\Models\Visitor::$status[$visitor->status]}}</span>
                            @elseif($visitor->status=='rejected')
                                <span
                                    class="d-inline badge text-bg-danger">{{\App\Models\Visitor::$status[$visitor->status]}}</span>
                            @elseif($visitor->status=='completed')
                                <span
                                    class="d-inline badge text-bg-success">{{\App\Models\Visitor::$status[$visitor->status]}}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Address')}}</h6>
                        <p class="mb-20">{{$visitor->address}}</p>
                    </div>
                </div>

                <div class="col-6">
                    <div class="detail-group">
                        <h6>{{__('Notes')}}</h6>
                        <p class="mb-20">{{$visitor->notes}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
