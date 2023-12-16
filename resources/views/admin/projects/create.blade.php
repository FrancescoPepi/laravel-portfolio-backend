@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="mt-5">ADD A PROJECT</h1>
            <div class="col form p-4 mt-5">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- LABEL PROJECT --}}
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class=" form-control @error('label') is-invalid @enderror"
                                    name="label" id="label" placeholder="Name Project">
                                <label for="label">Name Project</label>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- SELECT TYPE --}}
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="type_id" class=" form-select" id="floatingSelectGrid">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            @if (old('type_id') == $type->id) selected @endif>{{ $type->label }}</option>
                                    @endforeach
                                </select>
                                <label for="floatingSelectGrid">Category</label>
                            </div>
                        </div>

                        {{-- VISIBILITY YES OR NO --}}

                        <div class="col-1">
                            <label class="switch">
                                <input name="visible" type="checkbox">
                                <span class="slider mx-0 mt-1 checked-visible""></span>
                            </label>
                        </div>
                    </div>

                    {{-- URL PROJECT --}}
                    <div class="form-floating">
                        <input type="url" class="my-3 form-control @error('url') is-invalid @enderror" name="url"
                            id="url" placeholder="Url Project">
                        <label for="url">Url Project</label>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- IGM PROJECT --}}
                    <div class="form-floating">
                        <div class="my-3">
                            <label for="img" class="form-label">Select preview</label>
                            <input name="img_label" class="form-control @error('img') is-invalid @enderror" type="file"
                                id="img">
                        </div>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DESCRIPTION PROJECT --}}
                    <div class="form-floating">
                        <textarea class="my-3 form-control @error('description') is-invalid @enderror" name="description" id="description"
                            placeholder="Url Project" style="height: 75px"></textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Salva</button>
                </form>
            </div>

        </div>

    </div>
@endsection
