@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Contacts</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="#" id="deleteAllContact" class="btn btn-danger text-white btn-sm">
                    <i class="mdi mdi-delete"></i> Delete All Contact
                </a>       
                <a href="{{ route('admin.contacts.import-contacts') }}" class="btn btn-success text-white btn-sm"><i class="mdi mdi-file-excel"></i> Import Contacts</a>
                <a href="{{ route('admin.send-bulk-message') }}" class="btn btn-info text-white btn-sm"><i class="mdi mdi-email-fast-outline"></i> Send Bulk Message</a>
                <a href="{{ route('admin.contacts.addContact') }}" class="btn btn-primary text-white btn-sm"><i class="mdi mdi-plus"></i> Add Contact</a>
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
        <div class="col-12">
            <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex">
                            <div>
                                <h4 class="card-title">Contacts</h4>
                                <hr width="60px">
                            </div>
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="border-top-0">Nama</th>
                                        <th class="border-top-0">Nomor Telepon</th>
                                        <th class="border-top-0">Send Messages</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; ?>
                                    @if (!empty($contacts) && $contacts->count())
                                        @foreach ($contacts as $contacts)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $contacts->name }}</td>
                                                <td>{{ $contacts->phone_number }}</td>
                                                <td><a href="{{ route('admin.send-message-by-number', $contacts->phone_number) }}"><span class="badge bg-secondary">Send Message</span></a></td>
                                                <td>
                                                <a href="#" class="btn btn-danger deleteContact text-white btn-sm" data-id="{{ $contacts->id }}">
                                                    <i class="mdi mdi-delete"></i> 
                                                </a>
                                                <a href="{{ route('admin.contacts.editContact', $contacts->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-border-color"></i></a>
                                                {{-- <a href="" class="btn btn-info"><i class="mdi mdi-eye"></i></a> --}}
                                                </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('deleteAllContact').addEventListener('click', function(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Semua kontak akan dihapus dan ini tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan AJAX
                $.ajax({
                    url: "{{ route('admin.contacts.destroyAllContact') }}",
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Tampilkan alert sukses
                        Swal.fire(
                            'Terhapus!',
                            'Semua kontak berhasil dihapus.',
                            'success'
                        ).then(() => {
                            location.reload(); // Reload halaman jika diperlukan
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Gagal!',
                            'Gagal menghapus semua kontak.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    document.querySelectorAll('.deleteContact').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const contactId = this.getAttribute('data-id'); 
            const deleteUrl = `{{ route('admin.contacts.destroyContact', ':id') }}`.replace(':id', contactId); 

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kontak ini akan dihapus dan tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: deleteUrl,
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            Swal.fire(
                                'Terhapus!',
                                'Kontak berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload(); 
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Gagal!',
                                'Gagal menghapus kontak.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@stop