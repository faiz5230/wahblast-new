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

    .editor-buttons {
            margin-bottom: 10px;
        }

        .editor-buttons button {
            padding: 10px;
            margin-right: 5px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .editor-buttons button:hover {
            background-color: #0056b3;
        }

        textarea {
            width: 100%;
            height: 200px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: #fff;">
                <h2>Template Message Setting</h2>
            </div>
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.update-template-message-setting') }}" method="post" enctype="multipart/form-data">
                    @csrf
                
                    <div class="form-group">
                        <label class="col-md-12">Template Message</label>
                        <div class="col-md-12">
                            <div class="editor">
                                <textarea id="textEditor" class="form-control @error('setting_template_message') is-invalid @enderror" name="setting_template_message">{{  App\Models\SystemSetting::getValue('setting_template_message') }}</textarea>
                            </div>
                        </div>
                    </div>
                    @error('setting_template_message')
                        <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success text-white">Update Template</button>
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
