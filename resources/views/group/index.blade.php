@extends('layouts.master')

@section('content')

    <div class="container">
        <br/>
        <h3 align="center">Datatables Server Side Processing in Laravel</h3>
        <br/>
        <div align="right">
            <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
        </div>
        <br/>
        <table id="group_table" class="table table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Action</th>
                <th>
                    <button type="button" name="bulk_delete" id="bulk_delete" class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                </th>
            </tr>
            </thead>
        </table>
    </div>

    <div id="groupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="group_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Data</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label>Enter name</label>
                            <input type="text" name="group_name" id="group_name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Enter type</label>
                            <input type="text" name="type" id="type" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="group_id" id="group_id" value="" />
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



<!-- ================== inline-js ================== -->
@section('inline-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#group_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('group.list') }}",
                "columns": [
                    {"data": "name"},
                    {"data": "type"},
                    { "data": "action", orderable:false, searchable: false},
                    { "data":"checkbox", orderable:false, searchable:false}
                ]
            });

            $('#add_data').click(function () {
                $('#groupModal').modal('show');
                $('#group_form')[0].reset();
                $('#form_output').html('');
                $('#button_action').val('insert');
                $('#action').val('Add');
                $('.modal-title').text('Add Data');
            });

            $('#group_form').on('submit', function (event) {
                event.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: "{{ route('group.store') }}",
                    method: "POST",
                    data: form_data,
                    dataType: "json",
                    success: function (data) {
                        if (data.error.length > 0) {
                            var error_html = '';
                            for (var count = 0; count < data.error.length; count++) {
                                error_html += '<div class="alert alert-danger">' + data.error[count] + '</div>';
                            }
                            $('#form_output').html(error_html);
                        }
                        else {
                            $('#form_output').html(data.success);
                            $('#group_form')[0].reset();
                            $('#action').val('Add');
                            $('.modal-title').text('Add Data');
                            $('#button_action').val('insert');
                            $('#group_table').DataTable().ajax.reload();
                        }
                    },
                    error: function (err) {
                        console.log(err.responseJSON);
                        toastr.error(JSON.stringify(err.responseJSON), "{{trans('_web_alert.notice')}}");
                    }
                })
            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr("id");
                $('#form_output').html('');
                $.ajax({
                    url:"{{route('group.edit')}}",
                    method:'get',
                    data:{id:id},
                    dataType:'json',
                    success:function(data)
                    {
                        $('#group_name').val(data.name);
                        $('#type').val(data.type);
                        $('#group_id').val(id);
                        $('#groupModal').modal('show');
                        $('#action').val('Edit');
                        $('.modal-title').text('Edit Data');
                        $('#button_action').val('update');
                    }
                })
            });

            $(document).on('click', '.delete', function(){
                var id = $(this).attr('id');
                var data = {"_token": "{{ csrf_token() }}"};
                data.id = id;
                data._method = 'DELETE';
                if(confirm("Are you sure you want to Delete this data?"))
                {
                    $.ajax({
                        url:"{{route('group.destroy')}}",
                        mehtod:"get",
                        data: data,
                        success:function(data)
                        {
                            alert(data);
                            $('#group_table').DataTable().ajax.reload();
                        }
                    })
                }
                else
                {
                    return false;
                }
            });

            $(document).on('click', '#bulk_delete', function(){
                var id = [];
                if(confirm("Are you sure you want to Delete this data?"))
                {
                    $('.group_checkbox:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0)
                    {
                        $.ajax({
                            url:"{{ route('group.mass_destroy')}}",
                            method:"delete",
                            data:{id:id},
                            success:function(data)
                            {
                                alert(data);
                                $('#group_table').DataTable().ajax.reload();
                            }
                        });
                    }
                    else
                    {
                        alert("Please select atleast one checkbox");
                    }
                }
            });


        });
    </script>
@endsection
<!-- ================== /inline-js ================== -->