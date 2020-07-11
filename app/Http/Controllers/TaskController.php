<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index() {
        $tasks = Task::all();
        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }


    public function create() {
        return view('tasks.create');
    }

    /*
        5번라인에 선언한 Request에서 해당 페이지의 Request된 값 바인딩.
        (파라매터에 선언) Request $request
    */
    public function store(Request $request) {

        // Task 레코드를 생성 -> 생성된 Task에 title, body에 데이터를 넣기.
        $task = Task::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        // tasks 페이지로 redirect.
        return redirect('/tasks');
    }

}
