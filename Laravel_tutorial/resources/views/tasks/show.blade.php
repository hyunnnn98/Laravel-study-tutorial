@extends('layouts.app')

@section('title')
Task detail
@endsection

@section('content')
<div>
    <h1>Task</h1>
    <a href="/tasks/{{ $task->id }}/edit">
        <button>Edit</button>
    </a>
    <form method="POST" action="/tasks/{{$task->id}}">
        @csrf
        @method('DELETE')
        <button>Delete</button>
    </form>
</div>
Title: {{ $task -> title }}<br>
<small>Created at {{ $task->created_at }}</small><br>
<small>Updated at {{ $task->updated_at }}</small><br>
Body
<div>{{ $task -> body }}</div>

@endsection
