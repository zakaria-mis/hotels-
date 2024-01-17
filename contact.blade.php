@extends('layouts.apps')
@section('content')

<div class="container-fluid pt-5">
    <div class="container">
        <div class="section-title">
            <h4 class="text-uppercase" style="letter-spacing: 5px;">Contact Us</h4>
            <h1 class="display-4">Feel Free To Contact</h1>
        </div>
        <div class="row px-3 pb-2">
            <div class="col-sm-4 text-center mb-3">
                <i class="fa fa-2x fa-map-marker-alt mb-3"></i>
                <h4 class="font-weight-bold">Address</h4>
                <p>hermel city al dardara</p>
            </div>
            <div class="col-sm-4 text-center mb-3">
                <i class="fa fa-2x fa-phone-alt mb-3"></i>
                <h4 class="font-weight-bold">Phone</h4>
                <p>+961 71 348 501</p>
            </div>
            <div class="col-sm-4 text-center mb-3">
                <i class="far fa-2x fa-envelope mb-3"></i>
                <h4 class="font-weight-bold">Email</h4>
                <p>zakaria.choker54@gmail.com</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pb-5">
                <iframe style="width: 100%; height: 443px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d417.9679740151373!2d35.5059927238612!3d33.80902742904398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slb!4v1697809314039!5m2!1sen!2slb"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="col-md-6 pb-5">
                <div class="contact-form">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('send-mail') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control bg-transparent p-4" id="name"
                                placeholder="Your Name" required="required" name="name"
                                data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control bg-transparent p-4" id="email"
                                placeholder="Your Email" required="required" name="email"
                                data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control bg-transparent p-4" id="subject"
                                placeholder="Subject" required="required" name="subject"
                                data-validation-required-message="Please enter a subject" />
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control bg-transparent py-3 px-4" rows="5" id="message" placeholder="Message" name="message"
                                required="required" data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                        <div>
                            <button class="btn btn-primary font-weight-bold py-3 px-5" type="submit"
                                id="sendMessageButton">Send
                                Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.bg-transparent {
    color: white !important;
}
</style>
@endsection
