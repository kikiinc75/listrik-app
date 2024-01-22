@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="row justify-content-center pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Daftar User</div>

                <div class="card-body">
                    @include('layouts.partials.session')
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success mb-2">Tambah Data</a>
                    <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Role</th>
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
        $(document).ready(function() {
            $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role_name',
                        name: 'role_name',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        name: 'action',
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            // Edit Button
                            action_button = `<a title="Edit Data" href="{{ env('APP_URL') }}/users/${data}/edit" class="btn btn-success btn-md">
                            <i class="fa fa-edit"></i>
                            </a>`;

                            // Delete Button
                            action_button += `<form class="d-inline" method="post" id="delete-form" action="{{ env('APP_URL') }}/users/${data}">
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
            console.log('click');
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
