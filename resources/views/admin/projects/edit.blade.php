@extends('layouts.app')

@section('cdn')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <h1 class="mt-5">EDIT A PROJECT</h1>
            <div class="col form p-4 mt-5">
                <form id="form-upload" action="{{ route('admin.projects.update', $project) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" id="eliminate-image" name="eliminateImage">
                    <div class="row">
                        {{-- LABEL PROJECT --}}
                        {{-- @dd($images) --}}
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class=" form-control @error('label') is-invalid @enderror"
                                    name="label" id="label" value="{{ $project->label }}" placeholder="Name Project">
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
                                <input name="visible" type="checkbox" @if ($project->visible == 1) checked @endif>
                                <span class="slider mx-0 mt-1 checked-visible"></span>
                            </label>
                        </div>
                    </div>

                    {{-- URL PROJECT --}}
                    <div class="form-floating">
                        <input type="url" class="my-3 form-control @error('url') is-invalid @enderror" name="url"
                            id="url" placeholder="Url Project" value="{{ $project->url }}">
                        <label for="url">Url Project</label>
                        @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- IGM PROJECT --}}
                    <div class="form-floating">
                        <div class="my-3">
                            <label for="img" class="form-label">Select Image</label>
                            <input multiple="multiple" name="photos[]"
                                class="form-control @error('img') is-invalid @enderror" type="file" id="img">
                        </div>
                        @error('img')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PREVIEW IMG --}}
                    <div class="row g-3 my-3">
                        @foreach ($images as $image)
                            <div class="col-auto">
                                <div class="box-img position-relative conferma" key="{{ $image->id }}">
                                    {{-- <div class="  p-1"></div> --}}
                                    <img src="{{ asset('storage/' . $image->filename) }}" alt="">
                                </div>
                            </div>
                        @endforeach
                        <span id="separatore" class="col-11 mx-auto"></span>
                    </div>
                    <div class="row g-3 my-3" id="preview">
                    </div>

                    {{-- DESCRIPTION PROJECT --}}
                    <div class="form-floating">
                        <textarea class="my-3 form-control @error('description') is-invalid @enderror" name="description" id="description"
                            placeholder="Url Project" style="height: 75px"></textarea>
                        <label for="description">
                            @if ($project->description)
                                {{ $project->description }}
                            @else
                                Description
                            @endif
                        </label>
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

@section('scripts')
    {{-- <script type="text/javascript">
        const inputImg = document.getElementById('img');
        const previewImg = document.getElementById('preview');
        inputImg.addEventListener('change', function() {
            console.log(Array.from(inputImg.files));
            const files = Array.from(inputImg.files);
            // previewImg.innerHTML = '';
            files.forEach(file => {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    const image = new Image();
                    image.src = String(this.result);
                    image.addEventListener('load', function() {
                        const div = document.createElement('div');
                        div.classList.add('col-auto');
                        const box = document.createElement('div');
                        box.classList.add('box-img');
                        const img = document.createElement('img');
                        img.src = String(this.result);
                        box.appendChild(img);
                        div.appendChild(box);
                        previewImg.appendChild(div);
                    });
                });
                reader.readAsDataURL(file);
            });
        });
    </script> --}}

    {{-- <script type="text/javascript">
        const inputImg = document.getElementById('img');
        const previewImg = document.getElementById('preview');
        const buttonProva = document.getElementById('prova');
        // const form = document.getElementById('form-upload');
        let filesIn = [];
        inputImg.addEventListener('change', function() {
            filesIn.push(...this.files);
            [fileNow] = [this.files];
            console.log(filesIn);

            for (let i = 0; i < fileNow.length; i++) {
                // console.log(files[i]);
                const urlImgGenerator = URL.createObjectURL(fileNow[i]);
                console.log(urlImgGenerator);
                previewImg.innerHTML += `<div class="col-auto">
                                <div class="box-img">
                                    <img src="${urlImgGenerator}" alt="">
                                </div>
                            </div>`;
            }
        });


        $(document).ready(function() {

            $('#form-upload').on('submit', function(event) {
                event.preventDefault();
                jQuery.ajax({
                    url: "{{ route('admin.projects.update', $project) }}",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    files: filesIn,

                    success: function(result) {
                        console.log("successo", result, files);
                    },
                    error: function(result) {
                        console.log("errato", result);
                    }
                }),
            }),
        }),
    </script> --}}

    <script type="text/javascript">
        const inputImg = document.getElementById('img');
        const previewImg = document.getElementById('preview');
        const eliminateImg = document.getElementById('eliminate-image');
        const buttonEliminate = document.querySelectorAll('.box-img');
        let jSon = [];
        for (let i = 0; i < buttonEliminate.length; i++) {
            buttonEliminate[i].addEventListener("click", function() {
                console.log(buttonEliminate[i].getAttribute('key'));
                if (jSon.includes(buttonEliminate[i].getAttribute('key'))) {
                    let test = jSon.filter(item => item !== buttonEliminate[i].getAttribute('key'));
                    jSon = test;
                    this.classList.remove('opacity-50');
                    this.classList.remove('non-conferma');
                    this.classList.add('conferma');
                    console.log(this);

                } else {
                    jSon.push(buttonEliminate[i].getAttribute('key'));
                    this.classList.add('opacity-50');
                    this.classList.add('non-conferma');
                    this.classList.remove('conferma');

                }
                // console.log(jSon);
                let newJson = JSON.stringify(jSon);
                console.log(newJson);
                eliminateImg.value = newJson;
                console.log(eliminateImg);
            });

        }

        // const buttonProva = document.getElementById('prova');
        // let filesIn = [];
        // let fileNow; // Sposta la dichiarazione fuori dalla funzione

        inputImg.addEventListener('change', function() {
            // filesIn.push(...this.files);
            let [fileNow] = [this.files];
            // console.log(filesIn);
            previewImg.innerHTML = "";
            for (let i = 0; i < fileNow.length; i++) {
                const urlImgGenerator = URL.createObjectURL(fileNow[i]);
                const newImg = document.createElement("div");
                newImg.classList.add("col-auto");

                // console.log(urlImgGenerator);
                newImg.innerHTML += `
                                <div class="box-img">
                                    <img src="${urlImgGenerator}" alt="">
                                </div>`;
                previewImg.appendChild(newImg);
            }
        });
    </script>
@endsection
