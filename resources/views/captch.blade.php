<!DOCTYPE html>
<html lang="en">
<head>
    <title>How to Add Google reCAPTCHA v3 to form in Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    <!-- Include script -->
    <script type="text/javascript">
        function callbackThen(response) {

            // read Promise object
            response.json().then(function(data) {
                console.log(data);
                if(data.success && data.score >= 0.6) {
                    console.log('valid recaptcha');
                } else {
                    document.getElementById('contactForm').addEventListener('submit', function(event) {
                        event.preventDefault();
                        alert('recaptcha error');
                    });
                }
            });
        }

        function callbackCatch(error){
            console.error('Error:', error)
        }
    </script>

    {!! htmlScriptTagJsApi([
       'callback_then' => 'callbackThen',
       'callback_catch' => 'callbackCatch',
    ]) !!}
</head>
<body>
​
<!-- Alert message (start) -->
@if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
<!-- Alert message (end) -->

<div class="container">
    <h2>Contact form</h2>
    <form action="{{ route('post-login') }}" method="post" id="contactForm">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="name" class="form-control" id="email" placeholder="Enter name" name="name" value="{{ old('name') }}">
            @if($errors->has('name'))
                <small class="text-danger">{{ $errors->first('name') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
                <small class="text-danger">{{ $errors->first('email') }}</small>
            @endif
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" placeholder="Enter message" name="message">{{ old('message') }}</textarea>
            @if($errors->has('message'))
                <small class="text-danger">{{ $errors->first('message') }}</small>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
​
</body>
</html>
