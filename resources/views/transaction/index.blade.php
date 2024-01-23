@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List Transaction</div>

                <div class="card-body">
                    @include('layouts.partials.session')
                    {{-- <a href="{{ route('electricity-usages.create') }}" class="btn btn-sm btn-success mb-2">Add Data</a> --}}
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Billing Month</th>
                                <th>Billing Year</th>
                                <th>Admin Fee</th>
                                <th>Total Fee</th>
                                <th>Paid At</th>
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
                        data: null,
                        name: 'billings.month',
                        render: function(data, type, row) {
                            date = new Date();
                            date.setMonth(row['month'] - 1);

                            return date.toLocaleString([], {
                                month: 'long'
                            });
                        }
                    },
                    {
                        data: 'year',
                        name: 'billings.year',
                    },
                    {
                        data: 'admin_fee',
                        name: 'admin_fee'
                    },
                    {
                        data: 'total_fee',
                        name: 'total_fee'
                    },
                    {
                        data: 'paid_at',
                        name: 'paid_at',
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
