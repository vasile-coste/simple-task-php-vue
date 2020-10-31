@extends('layouts.app')

@section('title', 'Home')

@section('mainMenu')
@parent
@endsection

@section('content')
<div class="modal fade show" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<h2>Personal information</h2>
<form class="row" id="updateProfile-form" method="POST">
    <div class="col-md-4 col-sm-12 profile">Username</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="text" name="username" value="{{ session('data')->username }}" class="form-control" disabled />
    </div>
    <div class="col-md-4 col-sm-12 profile">Email</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="text" name="email" value="{{ session('data')->email }}" class="form-control" disabled />
    </div>
    <div class="col-md-4 col-sm-12 profile">Phone</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="text" name="phone" value="{{ session('data')->phone }}" class="form-control" require />
        <input type="hidden" name="id" value="{{ session('data')->id }}" />
    </div>
    <div class="col-md-4 col-sm-12 profile">Website</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="text" name="website" class="form-control" value="{{ session('data')->website }}" require />
    </div>
    <div class="col-md-12 col-sm-12 profile">
        <button type="submit" class="btn btn-success mt-2" id="updateProfile">Update Profile</button>
    </div>
</form>

<h2 class="mt-2">Update password</h2>
<form class="row" id="updatePassword-form" method="POST">
    <div class="col-md-4 col-sm-12 profile">Old Password</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="password" name="old" class="form-control" require />
        <input type="hidden" name="id" value="{{ session('data')->id }}" />
    </div>
    <div class="col-md-4 col-sm-12 profile">New Password</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="password" name="password1" class="form-control" require />
    </div>
    <div class="col-md-4 col-sm-12 profile">Retype Password</div>
    <div class="col-md-8 col-sm-12 profile">
        <input type="password" name="password2" class="form-control" require />
    </div>
    <div class="col-md-12 col-sm-12 profile">
        <button type="submit" class="btn btn-success mt-2" id="updatePassword">Update Password</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $(document).on('submit', '#updateProfile-form', function(e) {
            e.preventDefault();

            $.post("/updateProfile", $("#updateProfile-form").serialize(), function(data) {
                console.log(data);
                let json = JSON.parse(data);
                $(".modal-body").html(json.message != 0 ? json.message : "Nothing to update!");
                $("#notificationModal").modal('show');
            });
        });
        $(document).on('submit', '#updatePassword-form', function(e) {
            e.preventDefault();

            $.post("/updatePassword", $("#updatePassword-form").serialize(), function(data) {
                console.log(data);
                let json = JSON.parse(data);
                $(".modal-body").html(json.message != 0 ? json.message : "Nothing to update!");
                $("#notificationModal").modal('show');
            });
        });
    });
</script>
@endsection