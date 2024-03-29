<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    public function index()
    {
        // db에서 불러오기 ( 라라벨 자체 기능 all()로 모든 데이터 select.. )
        $projects = Project::all();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }
}
