@extends('components.layout')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container mt-5">
        <h2 class="mb-4">{{ __('translation.users') }}:</h2>
        <div align="right">
            <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm">
                {{ __('translation.create_record') }} </button>
        </div>
        <table class="table table-bordered yajra-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>{{ __('translation.first_name') }}</th>
                    <th>{{ __('translation.last_name') }}</th>
                    <th>{{ __('translation.email') }}</th>
                    <th>{{ __('translation.role') }}</th>
                    <th>{{ __('translation.status') }}</th>
                    <th>{{ __('translation.action') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="formModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('translation.add_new_record') }}</h4>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form method="post" id="sample_form" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4">{{ __('translation.first_name') }}: </label>
                            <div class="col-md-8">
                                <input type="text" name="first_name" id="first_name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">{{ __('translation.last_name') }}: </label>
                            <div class="col-md-8">
                                <input type="text" name="last_name" id="last_name" class="form-control" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">{{ __('translation.email') }}: </label>
                            <div class="col-md-8">
                                <input type="email" name="email" id="email" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">{{ __('translation.role') }}: </label>
                            <div class="col-md-8">
                                <select name="role" id="role" class="form-select" aria-label="Default select example">
                                    <option value="" selected disabled hidden>Select a Role</option>

                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-4">{{ __('translation.password') }}: </label>
                                <div class="col-md-8">
                                    <input type="password" name="password" id="password" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <br />
                        <div class="form-group" align="center">
                            <input type="hidden" name="action" id="action" value="Add" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button" id="action_button" class="btn btn-warning"
                                value="Add" />
                        </div>
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="modal-title">Confirmation</h2>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin:0;">Are you sure you want to remove this data?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.show') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'first_name',
                        name: 'first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'last_name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });


        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#create_record').click(function() {
                $('.modal-title').text('Add New Record');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#sample_form')[0].reset();
                $('#formModal').modal('show');
            });

            $('#sample_form').on('submit', function(event) {
                event.preventDefault();
                var action_url = '';


                if ($('#action').val() == 'Add') {

                    action_url = "{{ route('users.store') }}";
                }

                if ($('#action').val() == 'Edit') {
                    const data = new FormData(event.target);

                    var value = Object.fromEntries(data.entries());
                    var id = value['hidden_id'];

                    action_url = '{{ route('users.update', ':id') }}';
                    action_url = action_url.replace(':id', id);

                }


                $.ajax({
                    type: 'post',
                    url: action_url,
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(data) {
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                            '</div>';
                            $('#sample_form')[0].reset();
                            $('#user_table').DataTable().ajax.reload();
                            $('#formModal').modal('hide');

                        }
                        $('#form_result').html(html);
                    },
                    error: function(err) {
                        console.log("we are in ajax error");

                        console.log(err);
                        if (err.status ==422) { // when status code is 422, it's a validation issue

                        }

                    }
                });
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).attr('id');
                $('#form_result').html('');
                console.log(id);
                $.ajax({
                    url: "/users/edit/" + id,
                    type: 'post',
                    data: {
                        'id': id
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#first_name').val(data.result.first_name);
                        $('#last_name').val(data.result.last_name);
                        $('#email').val(data.result.email);
                        $('#role').val(data.result.role);
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record');
                        $('#action_button').val('Edit');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    },
                    error: function(err) {
                        console.log(err);
                        if (err.status ==422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);

                        }

                    }
                })
            });

            var user_id;

            $(document).on('click', '.delete', function() {
                user_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $('#ok_button').click(function() {
                $.ajax({
                    type: 'delete',
                    url: "users/" + user_id,
                    beforeSend: function() {
                        $('#ok_button').text('Deleting...');
                    },
                    success: function(data) {
                        setTimeout(function() {
                            $('#confirmModal').modal('hide');
                            $('#user_table').DataTable().ajax.reload();
                            alert('Data Deleted');
                        }, 2000);
                    },
                    error: function(err) {
                        console.log(err);


                    }
                })
            });

        });
    </script>

@endsection
