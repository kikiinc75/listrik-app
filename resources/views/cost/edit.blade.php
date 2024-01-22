@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Edit Cost</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Cost</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('costs.update', $cost->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Power</label>
                                    <input type="number" class="form-control @error('power') is-invalid @enderror"
                                        name="power" placeholder="Power" value="{{ old('power') ?? $cost->power }}"
                                        required>
                                    @error('power')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('power') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Cost per kWh</label>
                                    <input type="number" class="form-control @error('cost_per_kwh') is-invalid @enderror"
                                        name="cost_per_kwh" placeholder="Cost Per kWh"
                                        value="{{ old('cost_per_kwh') ?? $cost->cost_per_kwh }}" required>
                                    @error('cost_per_kwh')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('cost_per_kwh') }}
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
