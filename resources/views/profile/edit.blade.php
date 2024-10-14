@extends('layout.app')

@section('title', 'User Profile Edit - Pendarasa')

@push('after-style')
    <link rel="stylesheet" href="{{ asset('css/profileEdit.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="page__center container" style="width: 100%;">
                @foreach ($data as $item)
                    <div class="profile_header">
                        <div class="pic_wrapper">
                            @if ($item->foto == '' || null)
                                <img src="https://i.pinimg.com/736x/0d/64/98/0d64989794b1a4c9d89bff571d3d5842.jpg"
                                    alt="Avatar">
                            @else
                                <img src="{{ asset('img/foto/' . $item->foto) }}" alt="Avatar">
                            @endif
                        </div>
                        <div class="name_wrapper">
                            <h2 style="color: #003366; font-weight: bold;">{{ $item->nama }}</h2>
                            <h5 style="color: black;">{{ $item->nik }}</h5>
                        </div>
                        <div class="pull_right">
                            <a href="{{ route('profile') }}" class="btn btn-primary mt-4">Back</a>
                        </div>
                    </div>
                    <div class="profile-info edit_profile">
                        <div class="tab-content">
                            <div class="personal-info" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="{{ route('profile.insert') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" class="form-control"
                                                value="{{ Auth::user()->id }}">
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control" value="{{ $item->nama }}"
                                                    name="nama" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Gender</label>
                                                <select class="form-control" name="gender">
                                                    <option value="{{ $item->gender }}">
                                                        {{ $item->gender ?? '-' }}
                                                    </option>
                                                    <option value="Pria">Pria</option>
                                                    <option value="Wanita">Wanita</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="color: black; font-weight:bold;">
                                                <label>Unit</label>
                                                <select class="form-control" name="unit">
                                                    <option value="{{ $item->unit }}">
                                                        {{ $item->unit }}
                                                    </option>
                                                    @foreach ($unit as $u)
                                                        <option value="{{ $u->kodeunit }}">{{ $u->kodeunit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="color: black; font-weight:bold;">
                                            <label>Password</label>
                                            <input type="text" class="form-control" name="password"
                                                placeholder="***********">
                                        </div>
                                        <Button type="submit" class="btn btn-primary">Simpan Perubahan Tanpa
                                            Foto</Button>
                                        <h6 class="mt-2" style="color: black; font-weight: bold;">Foto Profil</h6>
                                        <div class="form-group mt-3">
                                            <input type="file" id="fotoInput" name="foto" class="form-control"
                                                accept="image/*">
                                            <img id="imagePreview" style="display: none; width: 100%; margin-top: 10px;">
                                        </div>
                                        <button type="button" id="cropButton" class="btn btn    -secondary"
                                            style="display: none;">Crop Image</button>
                                        <button type="submit" id="submitButton" class="btn btn-primary"
                                            style="display: none;">Simpan Perubahan</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('after-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        let cropper;
        const imagePreview = document.getElementById('imagePreview');
        const fotoInput = document.getElementById('fotoInput');
        const cropButton = document.getElementById('cropButton');
        const submitButton = document.getElementById('submitButton');

        fotoInput.addEventListener('change', function(event) {
            const files = event.target.files;
            const done = (url) => {
                imagePreview.src = url;
                imagePreview.style.display = 'block';
                cropButton.style.display = 'inline-block';
                submitButton.style.display = 'none';

                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(imagePreview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    ready: function() {
                        //
                    },
                });
            };

            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    done(e.target.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });

        cropButton.addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas();
            const croppedImage = canvas.toDataURL('image/png');

            // Show the cropped image in the input
            imagePreview.src = croppedImage;
            submitButton.style.display = 'inline-block';
        });

        submitButton.addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas();
            const dataURL = canvas.toDataURL('image/png');

            // Convert data URL to Blob
            fetch(dataURL)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], 'cropped-image.png', {
                        type: 'image/png'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fotoInput.files = dataTransfer.files;

                    fotoInput.form.submit();
                });
        });
    </script>
@endpush
