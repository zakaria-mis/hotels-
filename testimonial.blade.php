@extends('layouts.apps')
@section('content')
    <div class="indent">
        <h2>Customers’ testimonials</h2>
        <ul class="list4">
            @foreach ($testimonials as $testimonial)
                <li>
                    <img alt="" src="{{ asset('images/img-empty.png') }}" class="png" />
                    <h6>{{ $testimonial->title }}</h6>
                    {{ $testimonial->description }}
                </li>
            @endforeach
        </ul>
        @auth
            <div class="button1" id="AddOwn" data-bs-toggle="modal" data-bs-target="#testimonialModal"><span><span><a
                            href="#">SUBMIT YOUR OWN TESTIMONIAL</a></span></span>
            </div>
        @endauth
    </div>

    <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimonialModalLabel">Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('testimonials.store') }}" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="box box-info padding-1">
                            <div class="box-body">
                                <div>
                                    {{ Form::label('title') }}
                                    {{ Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'placeholder' => 'Title']) }}
                                </div>
                                <div>
                                    {{ Form::label('description') }}
                                    {{ Form::text('description', null, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description']) }}
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit feedback</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .box.box-info.padding-1 {
            background: none
        }
    </style>
@endsection
