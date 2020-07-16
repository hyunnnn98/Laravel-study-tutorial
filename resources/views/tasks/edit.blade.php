@extends('layout')

@section('title')
Edit Task
@endsection

@section('content')
<h1>Edit Task</h1>
<form method="POST" action="/tasks/{{ $task->id }}">
    {{--
        HTML Form은 PUT, PATCH, DELETE 리퀘스트를 만들 수 없다.
        따라서, @method('리퀘스트명')을 선언하여 추가로 작업이 필요함. <blade구문>
    --}}
    @csrf
    @method('PUT')
        <div>
            <label for="title">Title</label>
        </div>
        <input type="text" name="title" id="title" value="{{ old('title') ? old('title') : $task -> title }}" ><br>
        @error('title')
        <small>{{ $message }}</small>
        @enderror
        <div>
            <label for="body">Body</label>
        </div>
        <textarea name="body" id="body" cols="30" rows="10" >{{ old('body') ? old('body') : $task -> body }}</textarea><br>
        @error('body')
        <small>{{ $message }}</small><br>
        @enderror
        <button>Submit</button>
</form>
@endsection
