@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Create Account</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Account</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('electricity-accounts.store') }}">
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
                                <div class="form-group">
                                    <label class="">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="Address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Cost</label>
                                    <select class="form-control" name="cost" id="">
                                        <option>Please Select</option>
                                        @foreach ($costs as $cost)
                                            <option value="{{ $cost->id }}">
                                                {{ $cost->power . ' kWh - Rp.' . $cost->cost_per_kwh }}</option>
                                        @endforeach
                                    </select>
                                    @error('cost')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('cost') }}
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
