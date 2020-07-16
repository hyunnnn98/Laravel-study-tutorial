<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
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
    public function store()
    {
        /*
            [Validation]
            request로 받아온 데이터 검사.
        */
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        /*
            [CREATE]
            Task 레코드를 생성 -> 생성된 Task에 title, body에 데이터를 넣기.
        */
        $task = Task::create(request(['title', 'body']));
        /*
            $task = Task::create([
                'title' => request('title'),
                'body' => request('body'),
            ]);
        */
        // tasks 페이지로 redirect.
        return redirect('/tasks/' . $task->id);
    }

    /*
        [READ]
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

    /*
        GET 방식으로 받아온 아이디를 통해 View를 뿌려주는 형식.
        다음 => View -> Controller -> DB 로 가는 과정은 GET이 아닌 PUT으로 처리.
    */
    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    /*
        [UPDATE]
        View (넘어온 데이터 바인딩 하는 법 2가지)
            -> 1) 파라메터(Request $request)로 부터 받아온 데이터 바인딩
            -> 2) 파라메터로 받지 않고, function에서 request('key값')으로 선언해 데이터 바인딩
        Controller -> DB 로 가는 과정은 GET이 아닌 PUT으로 처리.
    */
    public function update(Task $task)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        /*
            $task->update([
                'title' => request('title'),
                'body' => request('body')
            ]);
        */
        $task->update(request(['title', 'body']));

        return redirect('/tasks/' . $task->id);
    }

    /*
        [DELETE]
        Url에 get 방식으로 같이 온 id를 통해
        Task의 모델로 접근 -> 해당 id 데이터 조회 후 리턴.
        => 리턴 된 데이터 삭제 명령.
    */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks');
    }
}
