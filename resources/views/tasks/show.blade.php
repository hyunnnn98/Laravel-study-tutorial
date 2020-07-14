@extends('layout')

@section('title')
Task detail
@endsection

@section('content')
<h1>Task</h1>
{{-- {{ $task }} --}}
Title: {{ $task -> title }} <small>Created at {{ $task->created_at }}</small><br>
Body
<div>{{ $task -> body }}</div>

@endsection
