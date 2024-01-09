@extends('layouts.app')



@section('content')
    <div class="container mt-5">
        <a href="{{ route('admin.projects.create') }}" class=" my-4 btn btn-primary">create</a>
        <div class="row row-cols-3 g-3">

            @foreach ($projects as $project)
                {{-- CART TEST --}}

                <div class="col-3">
                    <div class="card position-relative">
                        <span class="position-absolute p-2 top-0 start-50 badge rounded-pill"
                            style="background-color:{{ $project->type->color }} ">
                            {{ $project->type->label }}
                        </span>
                        <span class="fs-5 position-absolute top-50 start-50">
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class=" zoom-hover mx-1">
                                <i class="fa-solid fa-pen-to-square"></i></a>
                            <!-- Button trigger modal -->

                            <i class="fa-solid fa-trash-can zoom-hover" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-{{ $project->id }}" style="color: #da0b0b;"></i>

                        </span>
                        <img src="{{ asset('/storage/' .$images->where('project_id', $project->id)->pluck('filename')->first()) }}"
                            class="card-img-top" style="height: 250px; object-fit:cover" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fs-4 font-monospace">{{ $project->label }}</h5>
                            {{-- <div class="position-relative"> --}}
                            <form action="{{ route('admin.projects.toggleVisible', $project) }}"
                                class="mb-3 position-relative" method="post" id="form-visible-{{ $project->id }}">
                                {{-- <p class="card-text"> --}}
                                <strong>Visibile: </strong>
                                {{-- </p> --}}
                                @csrf
                                @method('PATCH')
                                {{-- <div class="position-absolute p-2 top-0 end-0"> --}}
                                <label class="switch">
                                    <input name="visible" type="checkbox" @if ($project->visible) checked @endif>
                                    <span
                                        class="slider position-absolute 
                                            bottom-0 end-0 checked-visible"
                                        data-id="{{ $project->id }}"></span>
                                </label>
                                {{-- </div> --}}
                            </form>

                            {{-- </div> --}}
                            <p class="card-text">
                                <strong>N° Photo: </strong>{{ $images->where('project_id', $project->id)->count() }}
                            </p>
                            <p class="card-text"><strong>Description: </strong>{{ substr($project->description, 0, 100) }}
                                @if (strlen($project->description) >= 100)
                                    ...
                                @endif
                            </p>
                            <p>
                                <strong>Link: </strong><a
                                    href="{{ $project->url }}"><strong>{{ $project->label }}</strong></a>

                            </p>
                            <p>
                                <strong>Languages: </strong>
                                @forelse ($project->languages as $language)
                                    {{ $language->label }}
                                @empty
                                    -
                                @endforelse


                            </p>

                        </div>
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
