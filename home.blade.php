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
                                <input type="text" class="select2" readonly id="price" name="price"
                                    style="width:100px !important" />
                            </div>
                            @guest
                                <div class="button" id="check" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <span><span><a href="javascript:void(0)">Check Availability & Book</a></span></span>
                                </div>
                            @else
                                <div class="button"><span><span>
                                            <button type="submit" class="submitForm">Check Availability &
                                                Book</button></span></span>
                                </div>
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
                <h2>FiveStar is happy to welcome you!</h2>
                <img class="img-indent png" alt="" src="{{ asset('images/daradara.jpg') }}" />
                <p class="alt-top">Come alone or bring your family with you, stay here for a night or for weeks,
                    stay here while on business trip or at some kind of conference - either way our hotel is the
                    best possible variant.</p>
                Feel free to contact us anytime in case you have any questions or concerns.
                <div class="clear"></div>
                <div class="line-hor"></div>
                <div class="wrapper line-ver">
                    <div class="col-1">
                        <h3>Special Offers</h3>
                        <ul>
                            <li>FREE wide-screen TV</li>
                            <li>50% Discount for Restaraunt service</li>
                            <li>30% Discount for 3 days+ orders</li>
                            <li>FREE drinks and beverages in rooms</li>
                            <li>Exclusive souvenirs</li>
                        </ul>

                    </div>
                    <div class="col-2">
                        <h3>Location</h3>
                        <p>We are located in the center of hermel  surrounded by al asi and restaurant  and a
                            wobderfull view .</p>
                        <dl class="contacts-list">
                            <dt>hermel  </dt>
                            <dd>+961 71 348 501</dd>
                            <dd>+961 71 974 951</dd>
                        </dl>
                    </div>
                </div>
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
