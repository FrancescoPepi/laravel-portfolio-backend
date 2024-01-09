<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\ProjectsImage;
use App\Models\Type;
use App\Models\User;

use App\Models\Language;
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
        // $user = Auth::user();

        $projects = Project::orderBy('id', 'DESC')->paginate(10);
        $images = ProjectsImage::all();
        // $languages = Language::all();
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
        $languages = Language::all();
        return view('admin.projects.create', compact('types', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = Auth::user();
        // dd($request->all());
        $data = $request->all();
        $project = new Project();
        $project->fill($data);
        $project->visible = Arr::exists($data, 'visible') ? ($project->visible = 1) : null;
        $project->save();
        if (Arr::exists($data, 'languages')) {
            $project->languages()->attach($data['languages']);
        }

        // dd($photo);
        if (Arr::exists($data, 'photos')) {
            foreach ($request->photos as $photo) {
                $image_path = Storage::put("uploads/projects/{$project->id}/images", $photo);
                // dd($image_path, $image_name);
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
        $types = Type::all();
        $languages = Language::all();
        $language_ids = $project->languages->pluck('id')->toArray();

        $images = ProjectsImage::where('project_id', $project->id)->get();
        return view('admin.projects.edit', compact('project', 'types', 'images', 'languages', 'language_ids'));
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

        $images = ProjectsImage::where('project_id', $project->id)->get();

        // dd($data, json_decode($data['eliminateImage']), $images);
        if (Arr::exists($data, 'languages')) {
            $project->languages()->sync($data['languages']);
        }

        if (json_decode($data['eliminateImage']) != null) {
            foreach ($images as $image) {
                foreach (json_decode($data['eliminateImage']) as $imgDelete) {
                    if ($image->id == $imgDelete) {
                        Storage::delete("$image->filename");
                        $image->delete();
                    }
                }
            }
        }

        // dd($images = ProjectsImage::where('project_id', $project->id)->get());
        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {
                $image_path = Storage::put("uploads/projects/{$project->id}/images", $photo);
                ProjectsImage::create([
                    'project_id' => $project->id,
                    'filename' => $image_path,
                ]);
            }
        }
        $project->update($data);
        // dd($data, $project);
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
