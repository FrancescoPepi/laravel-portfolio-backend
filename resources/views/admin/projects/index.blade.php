@extends('layouts.app')



@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.projects.create') }}" class=" my-4 btn btn-primary">create</a>
        <div class="row row-cols-3 g-3">

            @foreach ($projects as $project)
                <div class="col">
                    <div class="card h-100">
                        {{-- TITOLE + TUTTON EDIT-DELETE --}}
                        <div class="card-header position-relative">
                            <h3 class="">
                                {{ substr($project->label, 0, 12) }}@if (strlen($project->label) >= 12)
                                    ...
                                @endif
                                <span class="fs-5">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class=" zoom-hover mx-1">
                                        <i class="fa-solid fa-pen-to-square"></i></a>
                                    <!-- Button trigger modal -->

                                    <i class="fa-solid fa-trash-can zoom-hover" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $project->id }}" style="color: #da0b0b;"></i>

                                </span>
                            </h3>
                            <span class="position-absolute p-2 top-50 end-0 translate-middle badge rounded-pill"
                                style="background-color:{{ $project->type->color }} ">
                                {{ $project->type->label }}
                            </span>
                        </div>
                        {{-- BODY CARD --}}
                        <div class="card-body position-relative">
                            {{-- BUTTON VISIBLE OR NO  --}}
                            <div class="position-relative">
                                <form action="{{ route('admin.projects.toggleVisible', $project) }}" method="post"
                                    id="form-visible-{{ $project->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="col-1 position-absolute p-2 top-100 end-0 translate-middle">
                                        <label class="switch">
                                            <input name="visible" type="checkbox"
                                                @if ($project->visible) checked @endif>
                                            <span class="slider mx-0 mt-1 checked-visible"
                                                data-id="{{ $project->id }}"></span>
                                        </label>
                                    </div>
                                </form>

                                <h2>N Photo: {{ $images->where('project_id', $project->id)->count() }}</h2>
                            </div>
                            {{-- COVER IMAGE --}}
                            <div class="card-img h-50 w-25">
                                {{-- ottenere il primo valore della colonna filename per le immagini associate a un determinato progetto. --}}
                                {{-- @dd($images->where('project_id', $project->id)->pluck('filename')); --}}
                                <img src="{{ asset('/storage/' .$images->where('project_id', $project->id)->pluck('filename')->first()) }}"
                                    class="w-100 d-block image-fluid" alt="">
                            </div>
                            {{-- CARD TEXT --}}
                            <div class="card-text">
                                <hr>
                                <h3>
                                    {{ $project->description }}

                                </h3>
                                <hr>
                                <h3>
                                    Link: {{ substr($project->url, 0, 40) }}@if (strlen($project->label) >= 12)
                                        ...
                                    @endif
                                </h3>
                            </div>
                        </div>

                        <div class="card-footer"></div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('modals')
    <!-- Modal -->
    @foreach ($projects as $project)
        <div class="modal fade" id="exampleModal-{{ $project->id }}" tabindex="-1"
            aria-labelledby="exampleModal-{{ $project->id }}-Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModal-{{ $project->id }}-Label">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        const checkboxVisible = document.getElementsByClassName('checked-visible');
        // console.log(checkboxVisible);
        for (checkbox of checkboxVisible) {
            checkbox.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                console.log(id);
                const form = document.getElementById(`form-visible-${id}`);
                form.submit();
            });
        }
    </script>
@endsection
