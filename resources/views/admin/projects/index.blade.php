@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.projects.create') }}" class=" my-4 btn btn-primary">create</a>
        <div class="row row-cols-3 g-3">

            @foreach ($projects as $project)
                <div class="col">
                    <div class="card">
                        <div class="card-header position-relative">
                            <h2 class="">
                                {{ $project->label }}
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="btn btn-primary btn-sm">edit</a>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $project->id }}">
                                    eliminate
                                </button>

                            </h2>
                            <span class="position-absolute p-2 top-50 end-0 translate-middle badge rounded-pill"
                                style="background-color:{{ $project->type->color }} ">
                                {{ $project->type->label }}
                            </span>
                        </div>
                        <div class="card-body position-relative">
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

                                {{ $project->type_id }}
                            </div>


                            <hr>
                            {{ $project->description }}
                            <hr>
                            {{ $project->url }}
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
