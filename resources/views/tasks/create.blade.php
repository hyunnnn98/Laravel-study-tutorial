@extends('layout')

@section('title')
Create Task
@endsection

@section('content')
<h1>Create Task</h1>
<form method="POST" action="/tasks">
    {{--
        csrf를 선언 -> hidden값으로 해당 action에 보안값을 넘겨준다. == 인증.
    --}}
    @csrf
    <div>
        <label for="title">Title</label>
    </div>
    <input type="text" name="title" id="title"  value="{{ old('title') ? old('title') : ''}}"><br>
    @error('title')
    <small>{{ $message }}</small>
    @enderror
    <div>
        <label for="body">Body</label>
    </div>
    <textarea name="body" id="body" cols="30" rows="10" >{{ old('body') ? old('body') : '' }}</textarea><br>
    @error('body')
    <small>{{ $message }}</small><br>
    @enderror
    <button>Submit</button>
    {{-- @if($errors->any())
    {{ $errors }}
    @endif --}}
</form>
@endsection
