@extends('layouts.app')

@section('title')
Tasks
@endsection

@section('content')
<div>
    <h1>Task List</h1>
    <a href="/tasks/create"><button>Create Task</button></a>
</div>
<ul>
    {{-- {{$tasks}} --}}
    @foreach ($tasks as $task)
    <a href="/tasks/{{$task->id}}">
        <li>Title: {{ $task->title }} <small>Created at {{ $task -> created_at}}</small></li>
    </a>
    @endforeach
</ul>
@endsection
