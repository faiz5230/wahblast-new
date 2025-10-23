@extends('admin.messages.index')
@section('content-messages')
<style>
    @media (min-width: 992px) {
        .breadcumb-custom {
            margin-top: -100px
        }
    }
    .text-message {
        display: none; /* Sembunyikan teks panjang secara default */
    }
    .show-more {
        display: none; /* Sembunyikan teks tambahan secara default */
    }
    .show-more-btn {
        cursor: pointer;
        color: blue;
        text-decoration: underline;
    }

    .message-container {
        word-wrap: break-word; /* Memungkinkan kata untuk terputus dan melanjutkan ke baris berikutnya */
        overflow-wrap: break-word; /* Alternatif untuk dukungan yang lebih baik */
        white-space: pre-wrap; /* Mempertahankan spasi dan line break */
        background-color: #f8f9fa; /* Warna latar belakang untuk membedakan */
        border-radius: 5px; /* Membuat sudut bulat */
        padding: 0px; /* Memberi padding */
        margin: 5px 0; /* Memberi margin vertikal */
    }
</style>
<div class="page-breadcrumb breadcumb-custom">
    <div class="row align-items-center">
        <div class="col-6">
            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Chats</li>
                </ol>
              </nav> --}}
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.send-bulk-message') }}" class="btn btn-info text-white"><i class="mdi mdi-email-fast-outline"></i> Send Bulk Message</a>
                <a href="{{ route('admin.messages') }}" class="btn btn-primary text-white"><i class="mdi mdi-pencil-box-outline"></i> New Message</a>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="card">
                <div class="card-body">
                        <div class="d-md-flex">
                        <div>
                            <h4 class="card-title">History Message</h4>
                            <hr width="100px">
                        </div>
                    </div>
                    <!-- title -->
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="border-top-0">From Number</th>
                                    <th class="border-top-0">From Name</th>
                                    <th class="border-top-0">Text</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0">Device ID</th>
                                    <th class="border-top-0">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @if (!empty($chats) && $chats->count())
                                    @foreach ($chats as $chat)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $chat->number }}</td>
                                            <td>{{ $chat->from_name }}</td>
                                            <td style="min-width: 300px;">
                                                <div>
                                                    <?php
                                                    $message = $chat->text;
                                                    $limit = 100;
                                                    if (strlen($message) > $limit) {
                                                        $shortMessage = substr($message, 0, $limit) . '...';
                                                    } else {
                                                        $shortMessage = $message;
                                                    }
                                                    ?>
                                                    <span class="short-message message-container">{{ $shortMessage }}</span>
                                                    <span class="text-message message-container">{{ $message }}</span>
                                                    @if (strlen($message) > $limit)
                                                        <button class="btn btn-link show-more-btn">Show More</button>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <label for="status" class="badge bg-{{ $chat->status_color }}">{{ $chat->status_name }}</label>
                                            </td>
                                            <td>{{ $chat->id_device }}</td>
                                            <td>{{ $chat->type }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align:center;">Data tidak ditemukan!</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <br>
                        <div class="col">
                            <nav aria-label="..." style="float: left;">
                                <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                                </ul>
                            </nav>

                        </div>
                    </div> 
                </div>

            </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<script>
    document.querySelectorAll('.show-more-btn').forEach(button => {
        button.addEventListener('click', function() {
            const textMessage = this.previousElementSibling;
            const shortMessage = textMessage.previousElementSibling;

            if (textMessage.style.display === 'none') {
                textMessage.style.display = 'inline'; // Tampilkan teks panjang
                shortMessage.style.display = 'none'; // Sembunyikan teks pendek
                this.textContent = 'Show Less'; // Ubah teks tombol
            } else {
                textMessage.style.display = 'none'; // Sembunyikan teks panjang
                shortMessage.style.display = 'inline'; // Tampilkan teks pendek
                this.textContent = 'Show More'; // Kembali ke teks tombol awal
            }
        });
    });
</script>
@stop