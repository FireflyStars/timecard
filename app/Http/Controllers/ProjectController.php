<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Project;

class ProjectController extends Controller
{
    //
    public function __construct()
    {
        
    }

    /**
     * show Projects
     */
    public function showAllProject()
    {
        return view('project')->with(['projects'=> Project::all()]);
    }

    /**
     * Add new project
     * @param \Illuminate\Http\Request $request
     * 
     * @return response
     */
    public function addProject(Request $request){
        $project  = new Project;
        $project->name = $request->name;
        $project->save();

        $request->session()->flash('added', true);
        return redirect()->back();
    }

    /**
     * update the project
     * 
     * @param projectID
     * 
     * @return success message
     */
    public function updateProject(Request $request){
        $project  = Project::find($request->project_id);
        $project->name = $request->project_name;
        $project->save();

        $request->session()->flash('updated', true);
        return redirect()->back();
    }

}
