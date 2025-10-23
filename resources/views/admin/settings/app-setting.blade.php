@extends('admin.settings.index')
@section('content-settings')
<style>
    .custom-file-upload {
        display: inline-block;
        width: 100px;
        height: 100px;
        line-height: 100px;
        text-align: center;
        background-color: #f0f0f0;
        border: 2px dashed #ccc;
        border-radius: 10px;
        cursor: pointer;
    }
    .custom-file-upload:hover {
        background-color: #e0e0e0;
    }
    #imagePreview {
        width: 100px;
        height: 100px;
        object-fit: cover; /* Menjaga proporsi gambar dan isi area */
        border-radius: 10px; /* Sama dengan upload area */
        display: none; /* Default tersembunyi, akan ditampilkan saat gambar ter-upload */
    }
    #imageInput {
        display: none; /* Sembunyikan input file */
    }

    #imagePreviewMini {
        width: 100px;
        height: 100px;
        object-fit: cover; /* Menjaga proporsi gambar dan isi area */
        border-radius: 10px; /* Sama dengan upload area */
        display: none; /* Default tersembunyi, akan ditampilkan saat gambar ter-upload */
    }
    #imageInputMini {
        display: none; /* Sembunyikan input file */
    }

    .custom-file-upload-full {
        display: inline-block;
        width: 300px; /* Lebar label */
        height: 60px; /* Tinggi label */
        background-color: #f0f0f0;
        border: 2px dashed #ccc;
        border-radius: 10px;
        cursor: pointer;
        position: relative; /* Agar posisi gambar bisa absolut di dalam label */
        overflow: hidden; /* Menyembunyikan bagian gambar yang melampaui area */
    }

    .custom-file-upload-full:hover {
        background-color: #e0e0e0;
    }

    #imagePreviewFull {
        width: 100%; /* Mengisi lebar label */
        text-align: center;
        object-fit: cover; /* Menjaga proporsi gambar dan mengisi area */
        position: absolute; /* Memungkinkan posisi gambar secara absolut */
        top: 0; /* Posisi atas */
        left: 0; /* Posisi kiri */
        display: none; /* Default tersembunyi */
        background-size: cover;
    }

    #imageInputFull {
        display: none; /* Sembunyikan input file */
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: #fff;">
                <h2>App Setting</h2>
            </div>
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.update-setting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="col-md-12">Icon</label>
                        <div class="col-md-12">
                            <!-- Label yang dapat diklik untuk membuka dialog file -->
                            {{-- <label for="imageInput" class="custom-file-upload" id="uploadLabel" 
                                style="background-image: url('{{ asset(App\Models\AppSetting::getValue('app_logo')) }}');">
                                <img id="imagePreview" alt="Upload Logo" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;" />
                                <span id="uploadText" style="color: transparent;">Upload Logo</span>
                            </label> --}}
                            <label for="imageInput" class="custom-file-upload" id="uploadLabel" 
                                style="background-image: url('{{ App\Models\AppSetting::getValue('app_icon') ? asset(App\Models\AppSetting::getValue('app_icon')) : '' }}');">
                                <img id="imagePreview" 
                                    alt="Upload Logo" 
                                    style="display: {{ App\Models\AppSetting::getValue('app_icon') ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;" 
                                    src="{{ App\Models\AppSetting::getValue('app_icon') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_icon')) : '' }}" />
                                <span id="uploadText" style="color: {{ App\Models\AppSetting::getValue('app_icon') ? 'transparent' : 'initial' }};">Upload Logo</span>
                            </label>
                            <input type="file"
                                class="form-control form-control-line @error('image') is-invalid @enderror"
                                name="app_icon"
                                id="imageInput"
                                accept="image/*"
                                onchange="previewImage(event)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Logo Mini Sidebar</label>
                        <div class="col-md-12">
                            <!-- Label yang dapat diklik untuk membuka dialog file -->
                            <label for="imageInputMini" class="custom-file-upload" 
                                style="background-image: url('{{ App\Models\AppSetting::getValue('app_logo') ? asset(App\Models\AppSetting::getValue('app_logo')) : '' }}');">
                                <img id="imagePreviewMini" 
                                    alt="Upload Icon" 
                                    style="display: {{ App\Models\AppSetting::getValue('app_logo') ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;" 
                                    src="{{ App\Models\AppSetting::getValue('app_logo') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_logo')) : '' }}" />
                                <span id="uploadTextMini" style="color: {{ App\Models\AppSetting::getValue('app_logo') ? 'transparent' : 'initial' }};">Upload Logo</span>
                            </label>
                            <input type="file"
                                class="form-control form-control-line @error('image') is-invalid @enderror"
                                name="app_logo"
                                id="imageInputMini"
                                accept="image/*"
                                onchange="previewImageMini(event)">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-md-12">Logo Full Sidebar</label>
                        <div class="col-md-12">
                            <!-- Label yang dapat diklik untuk membuka dialog file -->
                            <label for="imageInputFull" class="custom-file-upload-full" 
                                    style="background-image: url('{{ App\Models\AppSetting::getValue('app_logo_full') ? asset(App\Models\AppSetting::getValue('app_logo_full')) : '' }}');">
                                <img id="imagePreviewFull" 
                                    alt="Upload Logo" 
                                    style="display: {{ App\Models\AppSetting::getValue('app_logo_full') ? 'block' : 'none' }}; width: 100%; height: 100%; object-fit: cover; border-radius: 10px;" 
                                    src="{{ App\Models\AppSetting::getValue('app_logo_full') ? asset('app_setting/' . App\Models\AppSetting::getValue('app_logo_full')) : asset('path/to/default/logo.png') }}" />
                                <span id="uploadTextFull" style="color: {{ App\Models\AppSetting::getValue('app_logo_full') ? 'transparent' : 'initial' }};">Upload Logo</span>
                            </label>
                            <input type="file"
                                class="form-control form-control-line @error('image') is-invalid @enderror"
                                name="app_logo_full"
                                id="imageInputFull"
                                accept="image/*"
                                onchange="previewImageFull(event)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Name Application</label>
                        <div class="col-md-12">
                            <input type="text" name="app_name"
                                class="form-control form-control-line @error('app_name')
                                    is-invalid
                                @enderror" value="{{  App\Models\AppSetting::getValue('app_name') }}">
                        </div>
                    </div>
                    @error('app_name')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label class="col-md-12">Title</label>
                        <div class="col-md-12">
                            <input type="text" name="app_title"
                                class="form-control form-control-line @error('app_title')
                                    is-invalid
                                @enderror" value="{{  App\Models\AppSetting::getValue('app_title') }}">
                        </div>
                    </div>
                    @error('app_title')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label class="col-md-12">Footer</label>
                        <div class="col-md-12">
                            <input type="text" name="app_footer"
                                class="form-control form-control-line @error('app_footer')
                                    is-invalid
                                @enderror" value="{{  App\Models\AppSetting::getValue('app_footer') }}">
                        </div>
                    </div>
                    @error('app_footer')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success text-white">Update Setting</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Column -->
    </div>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const imagePreview = document.getElementById('imagePreview');
        const uploadText = document.getElementById('uploadText');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;  // Menampilkan gambar yang dipilih
                imagePreview.style.display = 'block'; // Tampilkan gambar
                uploadText.style.display = 'none';    // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function() {

    });

    function previewImageMini(event) {
        const input = event.target;
        const imagePreviewMini = document.getElementById('imagePreviewMini');
        const uploadTextMini = document.getElementById('uploadTextMini');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreviewMini.src = e.target.result;  // Menampilkan gambar yang dipilih
                imagePreviewMini.style.display = 'block'; // Tampilkan gambar
                uploadTextMini.style.display = 'none';    // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function() {

    });

    

    function previewImageFull(event) {
        const input = event.target;
        const imagePreviewFull = document.getElementById('imagePreviewFull');
        const uploadTextFull = document.getElementById('uploadTextFull');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreviewFull.src = e.target.result;  // Menampilkan gambar yang dipilih
                imagePreviewFull.style.display = 'block'; // Tampilkan gambar
                uploadTextFull.style.display = 'none';    // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function() {

    });
</script>
@endsection
