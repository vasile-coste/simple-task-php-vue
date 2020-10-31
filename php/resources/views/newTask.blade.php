@extends('layouts.app')

@section('title', 'New Task')

@section('mainMenu')
@parent
@endsection

@section('content')
<h2>New Task</h2>

<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span id="warning"></span>
    <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form class="row" id="addTask-form">
    <div class="col-md-4 col-sm-12 newTask">Task</div>
    <div class="col-md-8 col-sm-12 newTask">
        <input type="text" name="name" class="form-control" require />
        <input type="hidden" name="user" value="{{ session('data')->id }}" />
    </div>
    <div class="col-md-4 col-sm-12 newTask">Due</div>
    <div class="col-md-8 col-sm-12 newTask">
        <input type="date" name="due" class="form-control" require />
    </div>
    <div class="col-md-4 col-sm-12 newTask">Status</div>
    <div class="col-md-8 col-sm-12 newTask">
        <select name="status" class="form-control" require>
            <option value="Running">Running</option>
            <option value="Completed">Completed</option>
        </select>
    </div>
    <div class="col-md-12 col-sm-12 newTask pt-3">
        <button type="submit" class="btn btn-primary" id="addtask">Add</button>
    </div>
</form>
<script>
    $(document).on('click', '.close', function() {
        $(this).parent().hide();
    });
    $(document).on('submit', '#addTask-form', function(e) {
        e.preventDefault();

        $.post("/newTask", $("#addTask-form").serialize(), function(data) {
            let json = JSON.parse(data);
            if (json.success) {
                window.location.href = json.location;
            } else {
                $("#warning").html(json.message);
                $("#warning").parent().show();
            }

        });
    });
</script>
@endsection