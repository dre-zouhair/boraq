@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-add-modal-lg">Add</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-add-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-content modal-lg">
                <form method="POST" id="addUser">
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

                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
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
        document.getElementById("myBtn").addEventListener("click", f);


        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        /*
        function go(){
            let token = document.querySelector('input[name="_token"]').value;

            let name = document.querySelector('input[name="name"]').value;
            let email = document.querySelector('input[name="email"]').value;
            let password = document.querySelector('input[name="password"]').value;
            let url = '{{route('addUser')}}';
            let redirect = '{{route('home')}}';
            let form = document.querySelector('#addUser');

            const response =  await fetch(url, {
                headers: {
                    "Content-Type": "application/json",*/
                 //   "Accept": "application/json, text-plain, */*",*/
                /*    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password : password,
                    is_admin : 0
                })
            }).then(function(response){
                return await response.json();
            })  .then(function(json){
                const data = await response.json();
                console.log(data);

            }).catch(function(error) {
                    console.log(error);
                });

            .then((data) => {
                    form.reset();
                    console.log('ok');
                   // window.location.href = redirect;
                })

        }*/
        function f() {
            console.log(document.querySelector('input[name="_token"]').value);
            var csrfToken =  $('[name="_token"]').val();

            (async () => {
                const rawResponse = await fetch("{{route('addUser')}}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        '_token': csrfToken
                    },
                    body: JSON.stringify({name: 'ali', email: 'Textual content',password:'password', token : document.querySelector('input[name="_token"]').value})
                });
                const content = await rawResponse.json();

                console.log(content);
            })();


        }

    </script>
@stop
