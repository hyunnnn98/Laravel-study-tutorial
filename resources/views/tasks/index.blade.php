@extends('layout')

@section('title')
Tasks
@endsection

@section('content')
<h1>Task List</h1>
<ul>
    {{-- {{$tasks}} --}}
    @foreach ($tasks as $task)
    <li>Title: {{ $task->title }} <small>Created at {{ $task -> created_at}}</small></li>
    @endforeach
</ul>
@endsection
