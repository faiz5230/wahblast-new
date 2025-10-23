@extends('admin.layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row">
       <div class="col-5">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-12">Name</label>
                        <div class="col-md-12">
                            <input type="text" placeholder="Aditya mukti"
                                class="form-control form-control-line @error('name') is-invalid @enderror" name="name">
                                @error('name')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Email</label>
                        <div class="col-md-12">
                            <input type="email" placeholder="contoh@mail.com"
                                class="form-control form-control-line @error('email') is-invalid @enderror" name="email">
                                @error('email')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Password</label>
                        <div class="col-md-12">
                            <input type="password" placeholder="Password"
                                class="form-control form-control-line @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Password Konfirmasi</label>
                        <div class="col-md-12">
                            <input type="password" placeholder="Password konfirmasi"
                                class="form-control form-control-line @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                @error('password_confirmation')
                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-12">Status</label>
                        <div class="col-md-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status">
                                <label class="form-check-label" for="flexSwitchCheckDefault" id="switchLabel">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary text-white">Save User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
       </div>
    </div>
</div>
<script>
    const toggleSwitch = document.getElementById('flexSwitchCheckDefault');
    const switchLabel = document.getElementById('switchLabel');

    toggleSwitch.addEventListener('change', function() {
        if (this.checked) {
            switchLabel.textContent = 'Active';
        } else {
            switchLabel.textContent = 'Inactive';
        }
    });
</script>
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
@endsection