@extends('layouts.app')

@section('title', 'Home')

@section('mainMenu')
@parent
@endsection

@section('content')
<h2>
    My tasks
    <a type="button" class="btn btn-success" href="/newTask">New Task</a>
</h2>

<div class="row mt-2">
    <div class="col-md-12 col-sm-12 mb-3">
        <select id="filter">
            <option value="">All</option>
            <option value="Running">Running</option>
            <option value="Completed">Completed</option>
        </select>
    </div>
    <div class="col-md-7 col-sm-12" id="tasks">

    </div>
</div>
<script>
    $(document).on('change', '#filter', function() {
        getTasks($(this).val());
    });
    getTasks('');

    function getTasks(status) {
        let userId = {{session('data')->id}};
        $.post("/getTasks", {
            user: userId,
            status: status
        }, function(data) {
            let json = JSON.parse(data);
            if (json.success) {
                let taskHtml = "";
                if (json.data.length > 0) {
                    json.data.forEach(function(task) {
                        taskHtml += templateTask(task);
                    });
                } else {
                    taskHtml = templateTask({name:"No result found", due:"", status:""});
                }
                $("#tasks").html(taskHtml);
            }
        });
    }

    function templateTask(task) {
        return `
<div class="row taskList">
    <div class="col-md-12 col-sm-12">
        <h5>${task.name}</h5>
    </div>
    <div class="col-md-6 col-sm-6 text-left"><span class="badge badge-primary badge-pill">${task.status}</span></div>
    <div class="col-md-6 col-sm-6 text-right"><span class="badge badge-light">${task.due}</span></div>
</div>`;
    }
</script>
@endsection