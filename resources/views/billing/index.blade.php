@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Electricity Usage</div>

                <div class="card-body">
                    @include('layouts.partials.session')
                    @if (Auth::user()->roles[0]->slug === 'administrator')
                        <a href="{{ route('electricity-usages.create') }}" class="btn btn-sm btn-success mb-2">Add Data</a>
                    @endif
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Total Meter</th>
                                <th>Status</th>
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
@stop

@section('js')
    <script type="text/javascript">
        var userRoles = {!! auth()->user()->roles[0]->toJson() !!};
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: null,
                        name: 'electricity_accounts.kwh_number',
                        render: function(data, type, row) {
                            return row['kwh_number'] + ' - ' + row['name'];
                        }
                    },
                    {
                        data: 'month',
                        name: 'month',
                        render: function(data, type, row) {
                            date = new Date();
                            date.setMonth(data - 1);

                            return date.toLocaleString([], {
                                month: 'long'
                            });
                        }
                    },
                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'total_meter',
                        name: 'total_meter'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        name: 'action',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Edit Button
                            action_button = `<a title="Detail" href="{{ env('APP_URL') }}/billings/${data}" class="btn btn-info btn-md">
                            <i class="fa fa-eye"></i>
                            </a>`;
                            return action_button;
                        }
                    },
                ],
            });
        });

        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@stop
