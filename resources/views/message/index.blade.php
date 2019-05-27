<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel 5.8 - DataTables Server Side Processing using Ajax</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br />
    <h3 align="center">Dynamically Add / Remove input fields in Laravel 5.8 using Ajax jQuery</h3>
    <br />
    <div class="table-responsive">
        <form method="post" id="dynamic_form">
            <span id="result"></span>
            <table class="table table-bordered table-striped" id="user_table">
                <thead class="thead">
                <tr>
                    <th width="35%">Title</th>
                    <th width="35%">Message</th>
                    <th width="30%">Action</th>
                </tr>
                @foreach($messages as $row)
                    <tr>
                        <td>{{ $row->title }}</td>
                        <td>{{ $row->content }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </thead>
                <tbody class="tbody">

                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" align="right">&nbsp;</td>
                    <td>
                        {{--@csrf--}}
                        {{ csrf_field() }}
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){

        var count = 1;

        dynamic_field(count);

        function dynamic_field(number)
        {
            html = '<tr>';
            html += '<td><input type="text" name="title[]" class="form-control" /></td>';
            html += '<td><input type="text" name="content[]" class="form-control" /></td>';
            if(number > 1)
            {
                html += '<td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('.tbody').append(html);
            }
            else
            {
                html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                $('.tbody').html(html);
            }
        }

        $(document).on('click', '#add', function(){
            count++;
            dynamic_field(count);
        });

        $(document).on('click', '.remove', function(){
            count--;
            $(this).closest("tr").remove();
        });

        $('#dynamic_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:'{{ route("message.insert") }}',
                method:'post',
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function(){
                    $('#save').attr('disabled','disabled');
                },
                success:function(data)
                {
                    if(data.error)
                    {
                        var error_html = '';
                        for(var count = 0; count < data.error.length; count++)
                        {
                            error_html += '<p>'+data.error[count]+'</p>';
                        }
                        $('#result').html('<div class="alert alert-danger">'+error_html+'</div>');
                    }
                    else
                    {

                        let html = '';
                        data.data.forEach(function (message){
                            html += '<tr>'
                            html += '<td>'+message.title+'</td>'
                            html += '<td>'+message.content+'</td>'
                            html += '<td></td>'
                            html += '</tr>'
                        })
                        $('.thead').append(html);


                        dynamic_field(1);
                        $('#result').html('<div class="alert alert-success">'+data.success+'</div>');
                    }
                    $('#save').attr('disabled', false);
                }
            })
        });

    });
</script>