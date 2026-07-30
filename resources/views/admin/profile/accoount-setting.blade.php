@extends('admin.settings.index')
@section('content-settings')

<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-header" style="background-color: #fff;">
                <h2>Change Password</h2>
            </div>
            <div class="card-body">
                <form class="form-horizontal form-material mx-2" action="{{ route('admin.account-setting.change-password', $account->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="col-md-12">Password</label>
                        <div class="col-md-12">
                            <input type="password" name="password"
                                class="form-control form-control-line">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-success text-white">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Column -->
    </div>
</div>

@endsection