<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::paginate(10);
        return view('adminlte::projects.index',['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminlte::projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project();
        $data = array();

        foreach ($request->all() as $key => $value)
        {
            $data[$key] = empty($request->$key) ? null : htmlspecialchars( clean( $request->$key, 'noHtml'), ENT_QUOTES );
        }

        $data['user_id'] = Auth::user()->getKey();

        if ($project->validate($data))
            if($project->create($data))
                return redirect()->route('my-projects.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return view('adminlte::projects.edit',['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $data = array();

        foreach ($request->all() as $key => $value)
        {
            $data[$key] = empty($request->$key) ? null : htmlspecialchars( clean( $request->$key, 'noHtml'), ENT_QUOTES );
        }

        if ($project->validate($data))
            if($project->update($data))
                return redirect()->route('my-projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        if($project->delete())
            return redirect()->route('my-projects.index');
    }
}
