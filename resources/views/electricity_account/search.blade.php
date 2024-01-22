@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Search Account</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Search Account</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('electricity-accounts.search') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">kWh Number</label>
                                    <input type="number" class="form-control @error('kwh_number') is-invalid @enderror"
                                        name="kwh_number" placeholder="kWh Number" value="{{ old('kwh_number') }}" required>
                                    @error('kwh_number')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('kwh_number') }}
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
