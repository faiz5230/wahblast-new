@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Bot Auto Reply</li>
                </ol>
              </nav>
        </div>
        {{-- <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.bot-auto-reply.create') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Create Bot</a>
            </div>
        </div> --}}
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
                        <div class="d-flex">
                            <div class="col-6">
                                <div>
                                    <h4 class="card-title">Incoming Message</h4>
                                    <hr width="60px">
                                </div>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-sm" style="float: right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Add new step
                                  </button>
                            </div>
                        </div>
                        <!-- title -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableID">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="border-top-0">#</th>
                                        <th class="border-top-0">Incoming Message</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incomingMessage as $key => $incoming)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input incoming-checkbox" type="checkbox" value="" data-incoming-id="{{ $incoming->id }}" id="flexCheckChecked">
                                            </div>
                                        </td>
                                        <td>
                                            {{ $incoming->message }}
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                        </div>  

                        <hr>

                        <div class="d-md-flex">
                            <div>
                                <h4 class="card-title">Reply Message</h4>
                                <hr width="60px">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover align-middle text-nowrap table-bordered" id="tableReply">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="border-top-0">Incoming Message</th>
                                        <th class="border-top-0">Reply Message</th>
                                        <th class="border-top-0">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($replyMessage as $key => $reply)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $reply->incoming->message }}
                                        </td>
                                        <td>
                                            {{ $reply->message }}
                                        </td>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                    @endforeach
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
<!-- Modal Incoming message -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-incoming-message') }}" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">New step</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">Incoming Message</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="Masukkan pesan..." class="form-control form-control-line @error('message') is-invalid @enderror" name="message">
                            @error('message')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" id="bot_id" name="bot_id" value="{{ $id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Reply message -->
<div class="modal fade" id="replyMessageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="form-horizontal form-material mx-2" action="{{ route('admin.process-reply-message') }}" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reply Message</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-sm-12">Type</label>
                        <div class="col-sm-12">
                            <select class="form-select shadow-none form-control-line @error('type') is-invalid @enderror" name="type">
                                <option value="">-- PILIH --</option>
                                <option value="Text">Text</option>
                                <option value="Image">Image</option>
                                <option value="Video">Video</option>
                                <option value="PDF">PDF/Dokumen</option>
                            </select>
                            @error('type')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Reply Message</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="Masukkan balasan..." class="form-control form-control-line @error('message') is-invalid @enderror" name="message">
                            @error('message')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group files">
                        <label class="col-sm-12">File</label>
                        <div class="col-sm-12">
                            <input type="file" id="input-file-now" class="file-upload" name="url_file" />
                        </div>
                    </div>
                    <input type="hidden" id="incoming_message_id" name="incoming_message_id">
                    <input type="hidden" id="bot_id" name="bot_id" value="{{ $id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button> 
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableReply').DataTable({ });
    });
    $(document).ready(function() {
        var currentCheckbox = null;

        // Event handler ketika checkbox di checklist
        $('.incoming-checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                var incomingMessageId = $(this).data('incoming-id');
                
                // Simpan reference ke checkbox yang sedang aktif
                currentCheckbox = $(this);

                // Set nilai incoming_message_id ke dalam input hidden di modal
                $('#replyMessageModal #incoming_message_id').val(incomingMessageId);
                
                // Tampilkan modal reply message
                $('#replyMessageModal').modal('show');
            }
        });

        // Event handler ketika modal ditutup
        $('#replyMessageModal').on('hidden.bs.modal', function () {
            if (currentCheckbox) {
                // Uncheck checkbox yang sedang aktif
                currentCheckbox.prop('checked', false);

                // Reset currentCheckbox menjadi null setelah uncheck
                currentCheckbox = null;
            }
        });
    });
</script>
@stop