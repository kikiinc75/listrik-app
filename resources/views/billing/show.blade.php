@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Billing Detail</h1>
@stop

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Billing Detail</div>
                <div class="card-body">
                    <form role="form" method="post" action="{{ route('billings.updateStatus', $billing->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="PAID">
                        <div class="row">
                            <div class="col-12">
                                @include('layouts.partials.session')
                                <div class="form-group">
                                    <label class="">Account</label>
                                    <input type="text" class="form-control"
                                        value="{{ $billing->electricityUsage->electricityAccount->kwh_number . ' - ' . $billing->electricityUsage->electricityAccount->name }}"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label class="">Month</label>
                                    <input type="text" class="form-control"
                                        value="{{ \Carbon\Carbon::create()->month($billing->month)->format('F') }}"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label class="">Year</label>
                                    <input type="number" class="form-control" value="{{ $billing->year }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="">Billing Fee</label>
                                    <input type="number" class="form-control" value="{{ $billing->usage_fee }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="">Admin Fee</label>
                                    <input type="number" class="form-control" value="{{ $billing->admin_fee }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="">Total Fee</label>
                                    <input type="number" class="form-control" value="{{ $billing->total_fee }}" disabled>
                                </div>

                                <button type="reset" class="btn btn-danger float-right ml-2"
                                    onclick="history.back()">Back</button>
                                @if (Auth::user()->roles[0]->slug === 'administrator' && $billing->status === 'UNPAID')
                                    <button type="submit" class="btn btn-info float-right">Pay</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop
