@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Create User</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create User</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('users.store') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Fullname</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" placeholder="Name" value="{{ old('username') }}" required>
                                    @error('username')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('username') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Password" value="{{ old('password') }}" required>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('password') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Role</label>
                                    <select class="form-control" name="role" id="">
                                        <option>Please Select</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('role') }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-info float-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
