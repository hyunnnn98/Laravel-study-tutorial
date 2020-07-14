<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }


    public function create()
    {
        return view('tasks.create');
    }

    /*
        5번라인에 선언한 Request에서 해당 페이지의 Request된 값 바인딩.
        (파라매터에 선언) Request $request
    */
    public function store(Request $request)
    {

        // Task 레코드를 생성 -> 생성된 Task에 title, body에 데이터를 넣기.
        $task = Task::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        // tasks 페이지로 redirect.
        return redirect('/tasks/'.$task->id);
    }

    /*
        게시글을 선택하여 페이지 선택된 게시글 불러오기.
        1) public function show($task) {
            => get 방식으로 받아지는 data를 변수명으로 해서 받아올 수 있다.
        2) public function show(Task $task) {
            => get 방식으로 받아지는 data의 변수를 통해 Task 모델에 접근.
            => 해당 id값으로 db 조회 후 넘어오는 select값을 $task에 담아준다.
    */
    public function show(Task $task)
    {
        return view('tasks.show', [
            'task' => $task
        ]);
    }
}
