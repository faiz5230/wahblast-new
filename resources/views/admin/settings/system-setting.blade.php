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
        object-fit: cover;
        /* Menjaga proporsi gambar dan isi area */
        border-radius: 10px;
        /* Sama dengan upload area */
        display: none;
        /* Default tersembunyi, akan ditampilkan saat gambar ter-upload */
    }

    #imageInput {
        display: none;
        /* Sembunyikan input file */
    }

    #imagePreviewMini {
        width: 100px;
        height: 100px;
        object-fit: cover;
        /* Menjaga proporsi gambar dan isi area */
        border-radius: 10px;
        /* Sama dengan upload area */
        display: none;
        /* Default tersembunyi, akan ditampilkan saat gambar ter-upload */
    }

    #imageInputMini {
        display: none;
        /* Sembunyikan input file */
    }

    .custom-file-upload-full {
        display: inline-block;
        width: 300px;
        /* Lebar label */
        height: 60px;
        /* Tinggi label */
        background-color: #f0f0f0;
        border: 2px dashed #ccc;
        border-radius: 10px;
        cursor: pointer;
        position: relative;
        /* Agar posisi gambar bisa absolut di dalam label */
        overflow: hidden;
        /* Menyembunyikan bagian gambar yang melampaui area */
    }

    .custom-file-upload-full:hover {
        background-color: #e0e0e0;
    }

    #imagePreviewFull {
        width: 100%;
        /* Mengisi lebar label */
        text-align: center;
        object-fit: cover;
        /* Menjaga proporsi gambar dan mengisi area */
        position: absolute;
        /* Memungkinkan posisi gambar secara absolut */
        top: 0;
        /* Posisi atas */
        left: 0;
        /* Posisi kiri */
        display: none;
        /* Default tersembunyi */
        background-size: cover;
    }

    #imageInputFull {
        display: none;
        /* Sembunyikan input file */
    }

</style>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: #fff;">
                <h2>System Setting</h2>
            </div>
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.update-system-setting') }}"
                    method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="col-md-12">Webhook URL</label>
                        <div class="col-md-12">
                            <input type="text" name="setting_webhook" placeholder="https://namadomain.com" class="form-control form-control-line @error('setting_webhook')
                                    is-invalid
                                @enderror" value="{{  App\Models\SystemSetting::getValue('setting_webhook') }}">
                        </div>
                    </div>
                    @error('setting_webhook')
                    <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label class="col-md-12">Number of message</label>
                        <div class="col-md-12">
                            <input type="text" name="setting_number_of_message" placeholder="5" class="form-control form-control-line @error('setting_number_of_message')
                                    is-invalid
                                @enderror"
                                value="{{  App\Models\SystemSetting::getValue('setting_number_of_message') }}">
                        </div>
                    </div>
                    @error('setting_number_of_message')
                    <p style="color: red">{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label class="col-md-12">Delay (second)</label>
                        <div class="col-md-12">
                            <input type="number" name="setting_delay_message" placeholder="30" class="form-control form-control-line @error('setting_delay_message')
                                    is-invalid
                                @enderror" value="{{  App\Models\SystemSetting::getValue('setting_delay_message') }}">
                        </div>
                    </div>
                    @error('setting_delay_message')
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

            reader.onload = function (e) {
                imagePreview.src = e.target.result; // Menampilkan gambar yang dipilih
                imagePreview.style.display = 'block'; // Tampilkan gambar
                uploadText.style.display = 'none'; // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function () {

    });

    function previewImageMini(event) {
        const input = event.target;
        const imagePreviewMini = document.getElementById('imagePreviewMini');
        const uploadTextMini = document.getElementById('uploadTextMini');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreviewMini.src = e.target.result; // Menampilkan gambar yang dipilih
                imagePreviewMini.style.display = 'block'; // Tampilkan gambar
                uploadTextMini.style.display = 'none'; // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function () {

    });



    function previewImageFull(event) {
        const input = event.target;
        const imagePreviewFull = document.getElementById('imagePreviewFull');
        const uploadTextFull = document.getElementById('uploadTextFull');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreviewFull.src = e.target.result; // Menampilkan gambar yang dipilih
                imagePreviewFull.style.display = 'block'; // Tampilkan gambar
                uploadTextFull.style.display = 'none'; // Sembunyikan teks 'Upload Icon'
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tambahkan event listener ke label untuk membuka dialog file saat diklik
    document.querySelector('.custom-file-upload').addEventListener('click', function () {

    });

</script>
@endsection
