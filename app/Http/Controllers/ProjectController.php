<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('project.index');
    }
    
    public function edit($project_id)
    {
        return view('project.edit', ["projectId" => $project_id]);
    }

    public function store(Request $request)
    {
        $data = $request->all(); 
        $response = Project::create($data);
        
        return response()->json([
            'status'=> 'success',
            'data' => $response
        ], 201);
    }

    public function update(Request $request, $project_id)
    {
        $data = $request->except(['created_at', 'updated_at']);
        $updated = Project::where('id', $project_id)->update($data);

        return response()->json([
            'status' => 'success',
            'data'=> $updated
        ], 200);
    }

    public function list()
    {
        $projects = Project::where('user_id', auth()->user()->id)->paginate(5);

        return response()->json([
            'status'=> 'success',
            'data'=> $projects
            ], 200);
    }

    public function show($project_id)
    {
        $response = Project::find($project_id);
        if ($response != null && $response->user_id == auth()->user()->id) {
            return response()->json(
                [   
                    'status' => 'success',
                    'data' => $response
                ], 200);
        }

        return response()->json([
            'status'=> 'error',
            'data'=> null,
            ], 404);
    }

    public function delete($project_id)
    {
        return view('project.delete', ["projectId" => $project_id]);
    }

    public function destroy($project_id)
    {
        Project::where("id", $project_id)->delete();

        return response()->json([
            'status' => 'success',
            'data'=> "No content"
        ], 200);
    }
}
