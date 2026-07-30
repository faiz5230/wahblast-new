@extends('admin.layouts.master')
@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<style>
    .card-header:first-child {
        border-radius: 19px !important;
    }

    .color-primary {
        color: #024BAD;
    }

    .color-primary:hover {
        color: #2E69B6FF;
    }
    button[aria-expanded="true"] .fas {
        transform: rotate(180deg); /* Rotasi menjadi panah atas */
        transition: transform 0.3s ease-in-out;
    }

    button[aria-expanded="false"] .fas {
        transform: rotate(0deg); /* Panah bawah ketika tidak aktif */
    }

    .mdi-loading {
        display: inline-block;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header text-white">
                    <h3>API Documentation</h3>
                </div>
                <div class="card-body">
                    <!-- API Dropdown List -->
                    <div class="accordion" id="apiAccordion">
                       <!-- Section 1: Send Message -->
                       <div class="card">
                        <div class="card-header" id="headingSendMessageGroup">
                            <h5 class="mb-0">
                                <button class="btn font-bold color-primary text-left d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapseSendMessage" aria-expanded="false" aria-controls="collapseSendMessage">
                                    <span class="mdi mdi-message-text"> Message</span>
                                    <i class="fas fa-chevron-down ml-auto"></i> <!-- Ikon Panah Bawah Default -->
                                </button>
                            </h5>
                        </div>
                        <div id="collapseSendMessage" class="collapse" aria-labelledby="headingSendMessageGroup" data-parent="#apiAccordion">
                            <div class="card-body">
                                <!-- Section 1 -->
                                <h5 class="mb-3">1. Send Message Text</h5>
                                <p>Api untuk mengirim pesan text.</p>
            
                                <h6 class="mt-4">Endpoint:</h6>
                                <code>{{ url('/api/send-message') }}</code>
            
                                <h6 class="mt-4">HTTP Method:</h6>
                                <p><kbd class="bg-info text-white px-2">POST</kbd></p>
            
                                <h6 class="mt-4">Request Parameters:</h6>
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>id</strong></td>
                                            <td>Number</td>
                                            <td>Ya</td>
                                            <td>Nomor penerima (<code>6281223644660</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>text</strong></td>
                                            <td>Text</td>
                                            <td>Ya</td>
                                            <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>type</strong></td>
                                            <td>Text</td>
                                            <td>Ya</td>
                                            <td>Jika kamu mengirim pesan text, type nya isi (<code>Text</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>waKey</strong></td>
                                            <td>Uuid</td>
                                            <td>Ya</td>
                                            <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                        </tr>
                                    </tbody>
                                </table>
            
                                <!-- Response Format for all endpoints -->
                                <h5 class="mt-5 mb-3">Response Format:</h5>
                                <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan berhasil dikirim",
                "statusCode": 200
            }
            </pre>
            
                                <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan Gagal dikirim",
                "statusCode": 400
            }
            </pre>
            
            
                                <!-- Section 2 -->
                                <h5 class="mb-3">2. Send Message With Image</h5>
                                <p>Api untuk mengirim pesan dengan gambar.</p>
            
                                <h6 class="mt-4">Endpoint:</h6>
                                <code>{{ url('/api/send-message') }}</code>
            
                                <h6 class="mt-4">HTTP Method:</h6>
                                <p><kbd class="bg-info text-white px-2">POST</kbd></p>
            
                                <h6 class="mt-4">Request Parameters:</h6>
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>id</strong></td>
                                            <td>Number</td>
                                            <td>Ya</td>
                                            <td>Nomor penerima (<code>6281223644660</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>text</strong></td>
                                            <td>Text</td>
                                            <td>Opsional</td>
                                            <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>type</strong></td>
                                            <td>Image</td>
                                            <td>Ya</td>
                                            <td>Jika kamu mengirim pesan dengan image, type nya isi (<code>Image</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>url_file</strong></td>
                                            <td>File</td>
                                            <td>Ya</td>
                                            <td>Formatnya nya harus berupa image.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>waKey</strong></td>
                                            <td>Uuid</td>
                                            <td>Ya</td>
                                            <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan berhasil dikirim",
                "statusCode": 200
            }
            </pre>
            
                                <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan Gagal dikirim",
                "statusCode": 400
            }
            </pre>
            
                                <!-- Section 3 -->
                                <h5 class="mt-5 mb-3">3. Send Message with Document</h5>
                                <p>Api ini untuk mengirim pesan dengan dokumen.</p>
            
                                <h6 class="mt-4">Endpoint:</h6>
                                <code>{{ url('/api/send-message') }}</code>
            
                                <h6 class="mt-4">HTTP Method:</h6>
                                <p><kbd class="bg-info text-white px-2">POST</kbd></p>
            
                                <h6 class="mt-4">Request Parameters:</h6>
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>id</strong></td>
                                            <td>Number</td>
                                            <td>Ya</td>
                                            <td>Nomor penerima (<code>6281223644660</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>text</strong></td>
                                            <td>Text</td>
                                            <td>Opsional</td>
                                            <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>type</strong></td>
                                            <td>PDF</td>
                                            <td>Ya</td>
                                            <td>Jika kamu mengirim pesan dengan dokumen, type nya isi (<code>PDF</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>url_file</strong></td>
                                            <td>File</td>
                                            <td>Ya</td>
                                            <td>Formatnya nya harus berupa pdf, doc, dll,.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>waKey</strong></td>
                                            <td>Uuid</td>
                                            <td>Ya</td>
                                            <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                        </tr>
                                    </tbody>
                                </table>
            
                                <!-- Response Format for all endpoints -->
                                <h5 class="mt-5 mb-3">Response Format:</h5>
                                <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan berhasil dikirim",
                "statusCode": 200
            }
            </pre>
            
                                <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                <pre class="bg-light p-3 rounded">
            {
                "message": "Pesan Gagal dikirim",
                "statusCode": 400
            }
            </pre>
            
                            <!-- Section 4 -->
                            <h5 class="mt-5 mb-3">4. Send Message with Video</h5>
                            <p>Api ini untuk mengirim pesan dengan video.</p>
            
                            <h6 class="mt-4">Endpoint:</h6>
                            <code>{{ url('/api/send-message') }}</code>
            
                            <h6 class="mt-4">HTTP Method:</h6>
                            <p><kbd class="bg-info text-white px-2">POST</kbd></p>
            
                            <h6 class="mt-4">Request Parameters:</h6>
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Parameter</th>
                                        <th>Type</th>
                                        <th>Required</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>id</strong></td>
                                        <td>Number</td>
                                        <td>Ya</td>
                                        <td>Nomor penerima (<code>6281223644660</code>).</td>
                                    </tr>
                                    <tr>
                                        <td><strong>text</strong></td>
                                        <td>Text</td>
                                        <td>Opsional</td>
                                        <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                    </tr>
                                    <tr>
                                        <td><strong>type</strong></td>
                                        <td>Video</td>
                                        <td>Ya</td>
                                        <td>Jika kamu mengirim pesan dengan video, type nya isi (<code>Video</code>).</td>
                                    </tr>
                                    <tr>
                                        <td><strong>url_file</strong></td>
                                        <td>File</td>
                                        <td>Ya</td>
                                        <td>Formatnya nya harus berupa mp4, dll,.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>waKey</strong></td>
                                        <td>Uuid</td>
                                        <td>Ya</td>
                                        <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                    </tr>
                                </tbody>
                            </table>                    <!-- Response section 4 -->
                            <h5 class="mt-5 mb-3">Response Format:</h5>
                            <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                            <pre class="bg-light p-3 rounded">
            {
            "message": "Pesan berhasil dikirim",
            "statusCode": 200
            }
            </pre>
            
                            <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                            <pre class="bg-light p-3 rounded">
            {
            "message": "Pesan Gagal dikirim",
            "statusCode": 400
            }
            </pre>
            
                                <!-- HTTP Status Codes -->
                                <h5 class="mt-4 mb-3">HTTP Status Codes:</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>200 OK</strong> - Operation completed successfully.
                                    </li>
                                    <li class="list-group-item">
                                        <strong>400 Bad Request</strong> - Missing or invalid parameters.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                        <!-- Section 2: Send Message Group -->
                        <div class="card">
                            <div class="card-header" id="headingSendMessageGroup">
                                <h5 class="mb-0">
                                    <button class="btn font-bold color-primary text-left d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapseSendMessageGroup" aria-expanded="false" aria-controls="collapseSendMessageGroup">
                                        <span class="mdi mdi-account-group"> Group</span>
                                        <i class="fas fa-chevron-down ml-auto"></i> <!-- Ikon Panah Bawah Default -->
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseSendMessageGroup" class="collapse" aria-labelledby="headingSendMessageGroup" data-parent="#apiAccordion">
                                <div class="card-body">
                                    <!-- Section 1 -->
                                    <h5 class="mb-3">1. Send Message Text</h5>
                                    <p>Api untuk mengirim pesan text.</p>
                
                                    <h6 class="mt-4">Endpoint:</h6>
                                    <code>{{ url('/api/send-group-message') }}</code>
                
                                    <h6 class="mt-4">HTTP Method:</h6>
                                    <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                
                                    <h6 class="mt-4">Request Parameters:</h6>
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Type</th>
                                                <th>Required</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>id</strong></td>
                                                <td>Number</td>
                                                <td>Ya</td>
                                                <td>Nomor penerima (<code>6281223644660</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>text</strong></td>
                                                <td>Text</td>
                                                <td>Ya</td>
                                                <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>type</strong></td>
                                                <td>Text</td>
                                                <td>Ya</td>
                                                <td>Jika kamu mengirim pesan text, type nya isi (<code>Text</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>waKey</strong></td>
                                                <td>Uuid</td>
                                                <td>Ya</td>
                                                <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                            </tr>
                                        </tbody>
                                    </table>
                
                                    <!-- Response Format for all endpoints -->
                                    <h5 class="mt-5 mb-3">Response Format:</h5>
                                    <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan berhasil dikirim",
                    "statusCode": 200
                }
                </pre>
                
                                    <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan Gagal dikirim",
                    "statusCode": 400
                }
                </pre>
                
                
                                    <!-- Section 2 -->
                                    <h5 class="mb-3">2. Send Message With Image</h5>
                                    <p>Api untuk mengirim pesan dengan gambar.</p>
                
                                    <h6 class="mt-4">Endpoint:</h6>
                                    <code>{{ url('/api/send-group-message') }}</code>
                
                                    <h6 class="mt-4">HTTP Method:</h6>
                                    <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                
                                    <h6 class="mt-4">Request Parameters:</h6>
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Type</th>
                                                <th>Required</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>id</strong></td>
                                                <td>Number</td>
                                                <td>Ya</td>
                                                <td>Nomor penerima (<code>6281223644660</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>text</strong></td>
                                                <td>Text</td>
                                                <td>Opsional</td>
                                                <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>type</strong></td>
                                                <td>Image</td>
                                                <td>Ya</td>
                                                <td>Jika kamu mengirim pesan dengan image, type nya isi (<code>Image</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>url_file</strong></td>
                                                <td>File</td>
                                                <td>Ya</td>
                                                <td>Formatnya nya harus berupa image.</td>
                                            </tr>
                                            <tr>
                                                <td><strong>waKey</strong></td>
                                                <td>Uuid</td>
                                                <td>Ya</td>
                                                <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan berhasil dikirim",
                    "statusCode": 200
                }
                </pre>
                
                                    <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan Gagal dikirim",
                    "statusCode": 400
                }
                </pre>
                
                                    <!-- Section 3 -->
                                    <h5 class="mt-5 mb-3">3. Send Message with Document</h5>
                                    <p>Api ini untuk mengirim pesan dengan dokumen.</p>
                
                                    <h6 class="mt-4">Endpoint:</h6>
                                    <code>{{ url('/api/send-group-message') }}</code>
                
                                    <h6 class="mt-4">HTTP Method:</h6>
                                    <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                
                                    <h6 class="mt-4">Request Parameters:</h6>
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Type</th>
                                                <th>Required</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>id</strong></td>
                                                <td>Number</td>
                                                <td>Ya</td>
                                                <td>Nomor penerima (<code>6281223644660</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>text</strong></td>
                                                <td>Text</td>
                                                <td>Opsional</td>
                                                <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>type</strong></td>
                                                <td>PDF</td>
                                                <td>Ya</td>
                                                <td>Jika kamu mengirim pesan dengan dokumen, type nya isi (<code>PDF</code>).</td>
                                            </tr>
                                            <tr>
                                                <td><strong>url_file</strong></td>
                                                <td>File</td>
                                                <td>Ya</td>
                                                <td>Formatnya nya harus berupa pdf, doc, dll,.</td>
                                            </tr>
                                            <tr>
                                                <td><strong>waKey</strong></td>
                                                <td>Uuid</td>
                                                <td>Ya</td>
                                                <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                            </tr>
                                        </tbody>
                                    </table>
                
                                    <!-- Response Format for all endpoints -->
                                    <h5 class="mt-5 mb-3">Response Format:</h5>
                                    <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan berhasil dikirim",
                    "statusCode": 200
                }
                </pre>
                
                                    <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                    <pre class="bg-light p-3 rounded">
                {
                    "message": "Pesan Gagal dikirim",
                    "statusCode": 400
                }
                </pre>
                
                                <!-- Section 4 -->
                                <h5 class="mt-5 mb-3">4. Send Message with Video</h5>
                                <p>Api ini untuk mengirim pesan dengan video.</p>
                
                                <h6 class="mt-4">Endpoint:</h6>
                                <code>{{ url('/api/send-group-message') }}</code>
                
                                <h6 class="mt-4">HTTP Method:</h6>
                                <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                
                                <h6 class="mt-4">Request Parameters:</h6>
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Parameter</th>
                                            <th>Type</th>
                                            <th>Required</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>id</strong></td>
                                            <td>Number</td>
                                            <td>Ya</td>
                                            <td>Nomor penerima (<code>6281223644660</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>text</strong></td>
                                            <td>Text</td>
                                            <td>Opsional</td>
                                            <td>Pesan yang akan kamu dikirim (<code>Halo, saya ingin menginformasikan.</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>type</strong></td>
                                            <td>Video</td>
                                            <td>Ya</td>
                                            <td>Jika kamu mengirim pesan dengan video, type nya isi (<code>Video</code>).</td>
                                        </tr>
                                        <tr>
                                            <td><strong>url_file</strong></td>
                                            <td>File</td>
                                            <td>Ya</td>
                                            <td>Formatnya nya harus berupa mp4, dll,.</td>
                                        </tr>
                                        <tr>
                                            <td><strong>waKey</strong></td>
                                            <td>Uuid</td>
                                            <td>Ya</td>
                                            <td>Isi dengan key yang ada pada device (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                        </tr>
                                    </tbody>
                                </table>                    <!-- Response section 4 -->
                                <h5 class="mt-5 mb-3">Response Format:</h5>
                                <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                                <pre class="bg-light p-3 rounded">
                {
                "message": "Pesan berhasil dikirim",
                "statusCode": 200
                }
                </pre>
                
                                <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                                <pre class="bg-light p-3 rounded">
                {
                "message": "Pesan Gagal dikirim",
                "statusCode": 400
                }
                </pre>
                
                                    <!-- HTTP Status Codes -->
                                    <h5 class="mt-4 mb-3">HTTP Status Codes:</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>200 OK</strong> - Operation completed successfully.
                                        </li>
                                        <li class="list-group-item">
                                            <strong>400 Bad Request</strong> - Missing or invalid parameters.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Device -->
                        <div class="card">
                            <div class="card-header" id="headingDevice">
                                <h5 class="mb-0">
                                    <button class="btn font-bold color-primary text-left d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapseDevice" aria-expanded="false" aria-controls="collapseDevice">
                                        <span class="mdi mdi-devices"> Device</span>
                                        <i class="fas fa-chevron-down ml-auto"></i> <!-- Ikon Panah Bawah Default -->
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseDevice" class="collapse" aria-labelledby="headingDevice" data-parent="#apiAccordion">
                                <div class="card-body">
                                    {{-- Coming Soon <span class="mdi mdi-loading"></span> --}}
                                    <!-- Content for Device -->
                                        <!-- Section 1 -->
                                            <h5 class="mb-3">1. Get Active Device</h5>
                                            <p>Api mendapatkan device yang aktif.</p>
                        
                                            <h6 class="mt-4">Endpoint:</h6>
                                            <code>{{ url('/api/devices') }}</code>
                        
                                            <h6 class="mt-4">HTTP Method:</h6>
                                            <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                        
                                            <h6 class="mt-4">Request Parameters:</h6>
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <th>Type</th>
                                                        <th>Required</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>account_key</strong></td>
                                                        <td>Uuid</td>
                                                        <td>Ya</td>
                                                        <td>Isi dengan account key yang ada pada My profile (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                        
                                            <!-- Response Format for all endpoints -->
                                            <h5 class="mt-5 mb-3">Response Format:</h5>
                                            <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
                    <pre class="bg-light p-3 rounded">
{
    "message": "Semua device berhasil ditarik",
    "statusCode": 200,
    "data": [
        {
            "id": "6482dbc4-5a33-4832-ab14-53cd8803ab33",
            "number": "628978347440",
            "name": "testing",
            "description": "test",
            "multidevice": "YES",
            "status": "connected",
            "waKey": "6482dbc4-5a33-4832-ab14-53cd8803ab33"
        }
    ]
}
</pre>

                    <p><strong>Error:</strong> Returns a JSON object with an error message.</p>
                    <pre class="bg-light p-3 rounded">
{
    "message": "Device gagal ditarik",
    "statusCode": 400
}
</pre>

                                            <!-- Section 2 -->
                                            <h5 class="mb-3">2. Scan Device</h5>
                                            <p>Api untuk scan device.</p>
                        
                                            <h6 class="mt-4">Endpoint:</h6>
                                            <code>{{ url('/api/device/scan') }}</code>
                        
                                            <h6 class="mt-4">HTTP Method:</h6>
                                            <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                        
                                            <h6 class="mt-4">Request Parameters:</h6>
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Parameter</th>
                                                        <th>Type</th>
                                                        <th>Required</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>waKey</strong></td>
                                                        <td>Uuid</td>
                                                        <td>Ya</td>
                                                        <td>Isi dengan key yang ada pada di device (<code>a564dbc3-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>account_key</strong></td>
                                                        <td>Uuid</td>
                                                        <td>Ya</td>
                                                        <td>Isi dengan account key yang ada pada My profile (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                        
                                            <!-- Response Format for all endpoints -->
                                            <h5 class="mt-5 mb-3">Response Format:</h5>
                                            <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
        <pre class="bg-light p-3 rounded">
{
    "message": "Data berhasil ditarik",
    "statusCode": 200,
    "data": {
        "result": "data:image/png;base64,url",
        "page_title": "Scan Device"
    }
}
</pre>
                        
<p><strong>Error:</strong> Returns a JSON object with an error message.</p>
<pre class="bg-light p-3 rounded">
{
    "message": "Gagal melakukan scan",
    "statusCode": 400
}
</pre>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Contact -->
                        <div class="card">
                            <div class="card-header" id="headingContact">
                                <h5 class="mb-0">
                                    <button class="btn font-bold color-primary text-left d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                                        <span class="mdi mdi-contacts"> Contact</span>
                                        <i class="fas fa-chevron-down ml-auto"></i> <!-- Ikon Panah Bawah Default -->
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseContact" class="collapse" aria-labelledby="headingContact" data-parent="#apiAccordion">
                                <div class="card-body">
                                    {{-- Coming Soon <span class="mdi mdi-loading"></span> --}}
                                          <!-- Section 2 -->
                                          <h5 class="mb-3">1. Get all contact</h5>
                                          <p>Api untuk mendapatkan semua data kontak.</p>
                      
                                          <h6 class="mt-4">Endpoint:</h6>
                                          <code>{{ url('/api/contacts') }}</code>
                      
                                          <h6 class="mt-4">HTTP Method:</h6>
                                          <p><kbd class="bg-info text-white px-2">POST</kbd></p>
                      
                                          <h6 class="mt-4">Request Parameters:</h6>
                                          <table class="table table-bordered">
                                              <thead class="thead-light">
                                                  <tr>
                                                      <th>Parameter</th>
                                                      <th>Type</th>
                                                      <th>Required</th>
                                                      <th>Description</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <tr>
                                                      <td><strong>account_key</strong></td>
                                                      <td>Uuid</td>
                                                      <td>Ya</td>
                                                      <td>Isi dengan account key yang ada pada My profile (<code>2a4c843c-3f2a-439c-a637-a564dbc2832f</code>).</td>
                                                  </tr>
                                              </tbody>
                                          </table>
                      
                                          <!-- Response Format for all endpoints -->
                                          <h5 class="mt-5 mb-3">Response Format:</h5>
                                          <p><strong>Success:</strong> Returns a JSON object indicating success for all endpoints.</p>
      <pre class="bg-light p-3 rounded">
{
    "message": "Berhasil mendapatkan data kontak",
    "data": [
        {
            "id": 1,
            "name": "Nazman",
            "phone_number": "628978347440"
        }
    ],
    "statusCode": 200
}
</pre>
                      
<p><strong>Error:</strong> Returns a JSON object with an error message.</p>
<pre class="bg-light p-3 rounded">
{
    "message": "Gagal mengambil data contact",
    "statusCode": 400
}
</pre>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Webhook -->
                        <div class="card">
                            <div class="card-header" id="headingWebhook">
                                <h5 class="mb-0">
                                    <button class="btn font-bold color-primary text-left d-flex justify-content-between align-items-center w-100" type="button" data-toggle="collapse" data-target="#collapseWebhook" aria-expanded="false" aria-controls="collapseWebhook">
                                        <span class="mdi mdi-webhook"> Webhook</span>
                                        <i class="fas fa-chevron-down ml-auto"></i> <!-- Ikon Panah Bawah Default -->
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseWebhook" class="collapse" aria-labelledby="headingWebhook" data-parent="#apiAccordion">
                                <div class="card-body">
                                    {{-- Coming Soon <span class="mdi mdi-loading"></span> --}}
                                    <!-- Content for Webhook -->
                                    <h5 class="mb-3">Webhook (Json Response)</h5>
                                    <div class="json-container">
<pre>
 {
    "number": "628978348444",
    "message": "Halo saya mau kasih tau"
    "from": "62821100044323",
    "from_name": "Notification System",
}
</pre>
                                      </div>
                                    <!-- Table and other contents go here as per your initial structure -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of API Dropdown List -->
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
</div>
@stop
