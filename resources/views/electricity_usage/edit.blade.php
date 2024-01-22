@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Create Usage</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create Usage</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('electricity-usages.update', $usage->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Account</label>
                                    <input type="text" class="form-control"
                                        value="{{ $usage->electricityAccount->kwh_number . ' - ' . $usage->electricityAccount->name }}"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="">Month</label>
                                    <select class="form-control" name="month" id="">
                                        <option>Please Select</option>
                                        @for ($month = 1; $month <= 12; $month++)
                                            <option value='{{ $month }}'
                                                {{ $usage->month == $month ? 'selected' : '' }}>
                                                {!! date('F', mktime(0, 0, 0, $month, 1)) !!}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('month')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('month') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Year</label>
                                    <select class="form-control" name="year" id="">
                                        <option>Please Select</option>
                                        @for ($year = 2015; $year <= date('Y'); $year++)
                                            <option value='{{ $year }}'
                                                {{ $usage->year == $year ? 'selected' : '' }}>
                                                {{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('year')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('year') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Meter From</label>
                                    <input type="number" class="form-control @error('meter_from') is-invalid @enderror"
                                        name="meter_from" placeholder="Meter From"
                                        value="{{ old('meter_from') ?? $usage->meter_from }}" required>
                                    @error('meter_from')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('meter_from') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Meter To</label>
                                    <input type="number" class="form-control @error('meter_to') is-invalid @enderror"
                                        name="meter_to" placeholder="Meter To"
                                        value="{{ old('meter_to') ?? $usage->meter_to }}" required>
                                    @error('meter_to')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('meter_to') }}
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
