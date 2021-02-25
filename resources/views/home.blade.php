@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

                        <div class="card mt-5">
                            <div class="card-header">
                                <div class="col-md-12">
                                    <h4 class="card-title">
                                        <a class="btn btn-success ml-5" href="javascript:void(0)" id="createNewUser"> Create New User</a>
                                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target=".bd-add-modal-lg">Add</button>
                                    </h4>

                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>


                        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ajaxModel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading2"></h4>
            </div>
            <div class="modal-body">
                <form id="UserForm2" name="UserForm2" class="form-horizontal">
                    <input type="hidden" name="User_id" id="User_id">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name2" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name2" name="name2" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">email</label>
                        <div class="col-sm-12">
                            <input type="email" id="email2" name="email2" required="" placeholder="Enter email" class="form-control"></input>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">is admin </label>
                        <div class="col-sm-12">
                            <input align="right" id="admintoggle" name="is_admin2" type="checkbox" checked data-toggle="toggle" data-on="Admin" data-off="Not Admin" data-onstyle="success" data-offstyle="danger">
                        </div>
                    </div>



                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="updateBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-add-modal-lg" id="ajaxModel"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content modal-lg">
                <form method="POST" id="UserForm">
                    <div class="modal-header text-center">
                        {{ __('Add')}}

                    </div>
                    <div class="modal-body">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('User Type') }}</label>
                            <div class="col-md-6">
                                <input align="right" name="is_admin" type="checkbox" checked data-toggle="toggle" data-on="Admin" data-off="Not Admin" data-onstyle="success" data-offstyle="danger">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="form-group row mb-0">

                            <button type="submit" class="btn btn-primary" id="saveBtn">
                                {{ __('Add User') }}
                            </button>
                            <button  type="button" class="btn btn-danger" id="myBtn" data-dismiss="modal" aria-label="Close">
                                Close
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
           var table =  $('#data-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax" : "{{ route('allUsers') }}",
                "columns" : [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]});
            $('#createNewUser').click(function () {
                $('#saveBtn').val("create-User");
                $('#User_id').val('');
                $('#UserForm').trigger("reset");
                $('#modelHeading').html("Create New User");
                $('#ajaxModel').modal('show');
            });
            $('body').on('click', '.editUser', function () {
                var User_id = $(this).data('id');

                $.ajax({
                    url:"{{route('userId')}}",
                    method:'get',
                    data:{id:User_id},
                    dataType:'json',
                    success:function(data)
                    {
                        console.log(data);
                        $('#modelHeading2').html("Edit User");
                        $('#saveBtn').val("edit-user");
                        $('#ajaxModel2').modal('show');
                        $('#User_id').val(data.id);
                        $('#name2').val(data.name);
                        $('#email2').val(data.email);
                        if(data.is_admin == false){
                            $('#admintoggle').bootstrapToggle('off');
                        }
                        else {
                            $('#admintoggle').bootstrapToggle('on');
                        }
                    }
                });
            });
            $('#saveBtn').click(function (e) {
                e.preventDefault();

                $.ajax({
                    data: $('#UserForm').serialize(),
                    url: "{{ route('addUser') }}",
                    method : "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#UserForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        console.log(data);
                    },
                    error: function (data) {
                        console.log('Error:', data.responseText);
                        $('#saveBtn').html('Add Changes');
                    }
                });
                $(this).html('Add user');
            });
            $('#updateBtn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
                console.log($('#UserForm2').serialize());
                $.ajax({
                    data: $('#UserForm2').serialize(),
                    url: "{{ route('updateUser') }}",
                    method : "POST",
                    dataType: 'json',
                    success: function (data) {

                        $('#UserForm2').trigger("reset");
                        $('#ajaxModel2').modal('hide');
                        table.draw();
                        console.log(data);

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#updateBtn').html('Save Changes');
                    }
                });
            });
            $('body').on('click', '.deleteUser', function () {

                var User_id = $(this).data("id");
                confirm("Are You sure want to delete !");
                $.ajax({
                    url:"{{route('deleteUser')}}",
                    type: "GET",
                    data:{id:User_id},
                    dataType:'json',
                    success:function(data)
                    {
                        console.log(data);
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                })
            });


        });
    </script>
@stop
