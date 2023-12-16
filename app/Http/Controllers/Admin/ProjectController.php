<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectsImage;
use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'DESC')->paginate(10);
        $images = ProjectsImage::all();
        return view('admin.projects.index', compact('projects', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->all();
        $project = new Project();
        $project->fill($data);
        $project->visible = Arr::exists($data, 'visible') ? ($project->visible = 1) : null;
        $project->save();

        // dd($photo);
        if (Arr::exists($data, 'photos')) {
            foreach ($request->photos as $photo) {
                $image_path = Storage::put("uploads/projects/{$project->id}/images", $photo);
                ProjectsImage::create([
                    'project_id' => $project->id,
                    'filename' => $image_path,
                ]);
            }
        }

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Project $project)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        $project = update($data);
        // $project->save();
        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }

    public function toggleVisible(Project $project, Request $request)
    {
        $data = $request->all();
        $project->visible = !Arr::exists($data, 'visible') ? ($project->visible = 1) : null;
        $project->save();
        return redirect()->back();
    }
}
