@extends('layouts.app')

@section('title', 'Login')

@section('mainMenu')
<!-- No mainMenu for login/register page-->
@endsection

@section('content')

<div class="loginBox">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span id="warning"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span id="success"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" id="loginForm" action="/login" class="loginForm">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12 form-group">
                <h2 class="text-center">Login</h2>
            </div>
            <div class="col-md-12 form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="col-md-12 form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="col-md-6 col-sm-6 text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-md-6 col-sm-6 text-right">
                <button id="register" type="button" class="btn btn-link">Register</button>
            </div>
        </div>
    </form>
    <form method="POST" id="registerForm" action="/register" class="loginForm">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12 form-group">
                <h2 class="text-center">Register</h2>
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required />
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required />
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="password" name="password1" class="form-control" placeholder="Password" required />
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="password" name="password2" class="form-control" placeholder="Re-type Password" required />
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="text" name="website" class="form-control" placeholder="Website" />
            </div>
            <div class="col-sm-12 col-md-6 form-group">
                <input type="text" name="phone" class="form-control" placeholder="Phone" />
            </div>
            <div class="col-md-6 col-sm-6 text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col-md-6 col-sm-6 text-right">
                <button id="cancel" type="button" class="btn btn-light">Cancel</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '#register', function() {
            showRegister();
        });

        $(document).on('click', '#cancel', function() {
            showLogin();
        });

        $(document).on('click', '.close', function() {
            $(this).parent().hide();
        });

        $(document).on('submit', '#loginForm', function(e) {
            e.preventDefault();

            $.post("/login", $("#loginForm").serialize(), function(data) {
                console.log(data);
                let json = JSON.parse(data);
                if (json.success) {
                    window.location.href = json.location;
                } else {
                    $("#warning").html(json.message);
                    $("#warning").parent().show();
                }
            });
        });

        $(document).on('submit', '#registerForm', function(e) {
            e.preventDefault();

            $.post("/register", $("#registerForm").serialize(), function(data) {
                let json = JSON.parse(data);
                if (json.success) {
                    showLogin();
                    $("#success").html(json.message);
                    $("#success").parent().show();
                } else {
                    $("#warning").html(json.message);
                    $("#warning").parent().show();
                }

            });
        });

        function showLogin() {
            $("#registerForm").slideUp();
            $("#loginForm").slideDown();
        }

        function showRegister() {
            $("#loginForm").slideUp();
            $("#registerForm").slideDown();
        }
    });
</script>

@endsection