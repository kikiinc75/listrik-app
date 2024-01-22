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
                    <form role="form" method="post" action="{{ route('electricity-usages.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Account</label>
                                    <select class="form-control" name="account" id="">
                                        <option>Please Select</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">
                                                {{ $account->kwh_number . ' - ' . $account->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('account')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('account') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Month</label>
                                    <select class="form-control" name="month" id="">
                                        <option>Please Select</option>
                                        @php
                                            for ($month = 1; $month <= 12; $month++) {
                                                $monthName = date('F', mktime(0, 0, 0, $month, 1));
                                                echo "<option value='$month'>$monthName</option>";
                                            }
                                        @endphp
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
                                        @php
                                            for ($i = 2015; $i <= date('Y'); $i++) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        @endphp
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
                                        name="meter_from" placeholder="Meter From" value="{{ old('meter_from') }}" required>
                                    @error('meter_from')
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('meter_from') }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="">Meter To</label>
                                    <input type="number" class="form-control @error('meter_to') is-invalid @enderror"
                                        name="meter_to" placeholder="Meter To" value="{{ old('meter_to') }}" required>
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
