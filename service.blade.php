@extends('layouts.apps')
@section('content')
    <div class="wrapper">
        <div class="aside maxheight">
            <!-- box begin -->
            <div class="box maxheight">
                <div class="inner">
                    <h3>Other Services</h3>
                    <div class="txt1">
                        <p>In addition to housing we also offer</p>
                        <ul class="img-list">
                            @foreach ($services as $service)
                                <li> <img alt=""
                                        src="{{ asset('images/' . $service->image) }}" />{{ $service->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- box end -->
        </div>
        <div class="content">
            <div class="indent">
                <h2>We offer several kinds of rooms</h2>
                <div class="container">
                    @foreach ($services as $service)
                        <!-- <form method="POST" action="{{ route('check') }}"  role="form" enctype="multipart/form-data"> -->
                        <div class="col-1"> <img alt=""
                                src="{{ asset('images/' . $service->image) }}" class="extra-img png" />
                            <dl class="list1">
                                <dt>{{ $service->title }}</dt>
                                <dd class="first">{{ $service->description }}</dd>
                                <dd><span><input type="number" name="floor" class="inputs" value="{{ $service->floor }}"
                                            readonly /></span>Floor</dd>
                                <dd><span><input type="number" name="rooms" class="inputs" value="{{ $service->room }}"
                                            readonly /></span>Rooms</dd>
                                <dd><span><input type="number" name="beds" class="inputs" value="{{ $service->bed }}"
                                            readonly /></span>Beds</dd>
                                <dd class="alt"><span><input type="number" name="baths" class="inputs"
                                            value="{{ $service->bath }}" readonly /></span>Baths</dd>
                                <dd class="last"><span><input type="number" name="prices" class="inputs"
                                            value="{{ $service->price }}" readonly /></span>Price:</dd>
                            </dl>
                            <button type="submit" class="submitForm" data-id="{{ $service->id }}" data-bs-toggle="modal"
                                data-bs-target="#serviceModal">Order Now!</button></span></span>
                        </div>
                        <!-- </form> -->
                    @endforeach
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalLabel">Services</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('booking_services.store') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="service_id" id="service">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="dateFrom">Date From</label>
                                <input name="date_from" type="date" class="form-control" id="dateFrom" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="dateTo">Date To</label>
                                <input name="date_to" type="date" class="form-control" id="dateTo">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <style>
        .inputs {
            background: none;
            border: none;
            color: white;
        }
    </style>
    <script>
        // Get the date input elements
        const dateFromInput = document.getElementById('dateFrom');
        const dateToInput = document.getElementById('dateTo');

        // Add an event listener to the "Check In" date picker
        dateFromInput.addEventListener('change', function() {
            // Get the selected date from the "Check In" date picker
            const dateFromDate = new Date(dateFromInput.value);

            // Calculate the minimum date for "Check Out" (Check In + 1 day)
            const mindateToDate = new Date(dateFromDate);
            mindateToDate.setDate(dateFromDate.getDate() + 1);

            // Format it as 'YYYY-MM-DD' and set it as the "Check Out" date picker's minimum
            dateToInput.min = mindateToDate.toISOString().split('T')[0];
        });
        $(document).ready(function() {
            $(".submitForm").click(function() {
                var id = $(this).attr('data-id');
                $("#service").val(id);
            });
        });
    </script>
@endsection
