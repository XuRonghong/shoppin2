@extends('layout.master')

@section('style')
    <style type="text/css">
        .box{
            width:600px;
            margin:0 auto;
            border:1px solid #ccc;
        }
        .has-error
        {
            border-color:#cc0000;
            background-color:#ffff99;
        }
    </style>
@endsection

@section('content')
    <div class="container box">
        <h3 align="center">Live Email Availability in Laravel using Ajax</h3><br />

        <div class="form-group">
            <label>Enter Your Email</label>
            <input type="text" name="email" id="email" class="form-control input-lg" />
            <span id="error_email"></span>
        </div>
        <div class="form-group">
            <label>Enter Your Password</label>
            <input type="password" name="password" id="password" class="form-control input-lg" />
        </div>
        <div class="form-group" align="center">
            <button type="button" name="register" id="register" class="btn btn-info btn-lg">Register</button>
        </div>
        {{ csrf_field() }}

        <br />
        <br />
    </div>
@endsection


<!-- ================== inline-js ================== -->
@section('inline-js')
    <script>
    $(document).ready(function () {

        $('#email').blur(function () {
            var error_email = '';
            var email = $('#email').val();
            var _token = $('input[name="_token"]').val();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!filter.test(email)) {
                $('#error_email').html('<label class="text-danger">Invalid Email</label>');
                $('#email').addClass('has-error');
                $('#register').attr('disabled', 'disabled');
            }
            else {
                $.ajax({
                    url: "{{ route('register.check') }}",
                    method: "POST",
                    data: {email: email, _token: _token},
                    success: function (result) {
                        if (result == 'unique') {
                            $('#error_email').html('<label class="text-success">Email Available</label>');
                            $('#email').removeClass('has-error');
                            $('#register').attr('disabled', false);
                        }
                        else {
                            $('#error_email').html('<label class="text-danger">Email not Available</label>');
                            $('#email').addClass('has-error');
                            $('#register').attr('disabled', 'disabled');
                        }
                    }
                })
            }
        });

    });
    </script>
@endsection
<!-- ================== /inline-js ================== -->