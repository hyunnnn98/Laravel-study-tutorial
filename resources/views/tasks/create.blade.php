@extends('layout')

@section('title')
Create Task
@endsection

@section('content')
<h1>Create Task</h1>
<form method="POST" action="/tasks">
    // csrf를 선언 -> hidden값으로 해당 action에 보안값을 넘겨준다. == 인증.
    @csrf
    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
    </div>
    <div>
        <label for="body">Body</label>
        <textarea name="body" id="body" cols="30" rows="10"></textarea>
    </div>
    <button>Submit</button>
</form>
@endsection
