@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Electricity Account</div>

                <div class="card-body">
                    @include('layouts.partials.session')
                    <a href="{{ route('electricity-accounts.create') }}" class="btn btn-sm btn-success mb-2">Add Data</a>
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>kWh Number</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Cost</th>
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
                        data: 'kwh_number',
                        name: 'kwh_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: null,
                        name: "cost",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return row['power'] + ' kWh - Rp.' + row['cost_per_kwh'];
                        }
                    },
                    {
                        name: 'action',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Edit Button
                            var action_button = ''
                            if (userRoles.slug === 'administrator') {
                                action_button += `<a title="Edit Data" href="{{ env('APP_URL') }}/electricity-accounts/${data}/edit" class="btn btn-success btn-md">
                                            <i class="fa fa-edit"></i>
                                        </a>`;
                            }

                            // Delete Button
                            action_button += `<form class="d-inline" method="post" id="delete-form" action="{{ env('APP_URL') }}/electricity-accounts/${data}">
                            @csrf
                            @method('delete')
                            <a title="Delete Data" class="btn btn-danger btn-md delete-button"><i class="fa fa-trash" id="delete-button"></i></a>
                            </form>`;
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
