@extends('layouts.apps')
@section('content')
    <div class="wrapper">
        <div class="aside maxheight">
            <!-- box begin -->
            <div class="box maxheight">
                <div class="inner">
                    <h3>Reservation:</h3>
                    <form method="POST" action="{{ route('check') }}" role="form" enctype="multipart/form-data"
                        id="reservation-form">
                        @csrf
                        <input type="hidden" name="room_id"  id="room_id" >
                        <fieldset>
                            <div class="field">
                                <label>Check In:</label>
                                <input type="date" class="select2" id="checkIn" name="check_in"
                                    min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                            <div class="field">
                                <label>Check Out:</label>
                                <input type="date" class="select2" id="checkOut" name="check_out">
                            </div>
                            <div class="field">
                                <label style="width: 100px; float: left;">Persons:</label>
                                <input type="number" class="select2" min="0" id="persons" name="persons"
                                    style="width:100px !important">
                            </div>
                            <div class="field">
                                <label style="width: 100px; float: left;">Rooms:</label>
                                <select id="rooms" name="rooms" style="width:100px !important">
                                </select>
                            </div>
                            <div class="field">
                                <label style="width: 100px; float: left;">Price:</label>
                                <input type="text" class="select2" id="price" name="price"
                                    style="width:100px !important" readonly />
                            </div>
                            @guest
                                <div class="button" id="check" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <span><span><a href="javascript:void(0)">Check Availability & Book</a></span></span>
                                </div>
                            @else
                                <div class="button"><span><span>
                                            <button type="submit" class="submitForm">Check Availability &
                                                Book</button></span></span></div>
                            @endguest
                        </fieldset>
                    </form>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- box end -->
        </div>
        <div class="content">
            <div class="indent">
                <h2>Our location</h2>
                <img class="img-indent png" alt="" src="{{ asset('images/asi.jpg') }}" />
                <div class="extra-wrap">
                    <p class="alt-top">Our hotel is located in the most spectacular part of hermel - surrounded by
                       restaurants and al asi river.</p>
                    <p>Please feel free to come visit us at the following adress:</p>
                    <dl class="contacts-list">
                        <dt>hermel city </dt>
                        <dd>+961 71 348 501</dd>
                        <dd>+961 71 974 951</dd>
                    </dl>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">You Must Login To Book / Check Availability</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Get the date input elements
        const checkInInput = document.getElementById('checkIn');
        const checkOutInput = document.getElementById('checkOut');

        // Add an event listener to the "Check In" date picker
        checkInInput.addEventListener('change', function() {
            // Get the selected date from the "Check In" date picker
            const checkInDate = new Date(checkInInput.value);

            // Calculate the minimum date for "Check Out" (Check In + 1 day)
            const minCheckOutDate = new Date(checkInDate);
            minCheckOutDate.setDate(checkInDate.getDate() + 1);

            // Format it as 'YYYY-MM-DD' and set it as the "Check Out" date picker's minimum
            checkOutInput.min = minCheckOutDate.toISOString().split('T')[0];
        });

        $(document).ready(function() {
            $("#persons").on('input keyup keydown', function(event) {
                var numbers = $("#persons").val();
                $.post('getRoom', {
                    'persons': numbers,
                    "_token": "{{ csrf_token() }}"
                }, function(data) {
                    $('#rooms').empty();
                    var result = JSON.parse(data);
                    if (Array.isArray(result) && result.length == 1) {
                        var selected = result[0].id;
                        $.post('getPrice', {
                            'id': selected,
                            "_token": "{{ csrf_token() }}"
                        }, function(data) {
                            $("#price").val(data + ' $');
                        });
                    }
                    if (Array.isArray(result) && result.length > 0) {
                        for (var i = 0; i < result.length; i++) {
                            $('#rooms').append('<option value="' + result[i].id + '">' +
                                result[i].room_number + ' floor ' + result[i].floor +
                                '</option>');
                        }
                    } else {
                        alert('No Rooms Available');
                    }
                });
            });


            $(document).on('change', '#rooms', function() {
                var selected = $('option:selected', this).val();
                $("#room_id").val(selected);
                $.post('getPrice', {
                    'id': selected,
                    "_token": "{{ csrf_token() }}"
                }, function(data) {
                    $("#price").val(data + ' $');
                });
            });
        });
    </script>
@endsection
