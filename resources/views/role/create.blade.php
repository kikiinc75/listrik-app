@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Create Role</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Role</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('roles.store') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Name" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('name') }}
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
