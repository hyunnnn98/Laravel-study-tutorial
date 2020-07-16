<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        // 관계를 설정함으로써, 보다 직관적인 코드로 변경이 가능하다.
        $tasks = auth()->user()->tasks()->latest()->get();

        // 유저 아이디값으로 검색하여 data return.
        // $tasks = Task::latest()->where('user_id', auth()->id())->get();

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }


    public function create()
    {
        return view('tasks.create');
    }

    /*
        [CREATE]
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
        // 1) request로 넘어온 값 배열에 바인딩.
        $values = request(['title', 'body']);
        // 2) 배열에 추가로 Key값 아이디 데이터 바인딩.
        $values['user_id'] = auth()->id();

        // Task 레코드를 생성 -> 생성된 Task에 title, body에 데이터를 넣기.
        $task = Task::create($values);
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
        /*
        [ 사용자 권한 설정 ]
        show data 뿌려주기 전,
        현재 로그인 한 아이디와 게시물의 user_id가 일치하는지 검사하기.

        1) if(auth()->id() != $task -> user_id) {
               abort(403);
           }
        2) abort_if(auth()->id() != $task->user_id, 403);

        3) abort_if(!auth()->user()->owns($task), 403);

        */
        abort_unless(auth()->user()->owns($task), 403);

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
        abort_unless(auth()->user()->owns($task), 403);

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
        // [ 사용자 권한 설정 ]
        abort_unless(auth()->user()->owns($task), 403);

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
        abort_unless(auth()->user()->owns($task), 403);

        $task->delete();
        return redirect('/tasks');
    }
}
