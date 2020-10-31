@extends('layouts.app')

@section('title', 'Page Title')

@section('mainMenu')
    @parent

    This is appended to the main menu.
@endsection

@section('content')
    <p>This is my body content.</p>
@endsection