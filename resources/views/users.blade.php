@extends('layout.master')

@section('style')
    <style type="text/css">
        .box{
            width:600px;
            margin:0 auto;
            border:1px solid #ccc;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3 align="center">Export Data to Excel in Laravel using Maatwebsite</h3><br />
        <div align="center">
            <a href="{{ route('export_excel.excel') }}" class="btn btn-success">Export to Excel</a>
        </div>
        <br />
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Customer Name</td>
                    <td>Address</td>
                    <td>City</td>
                    <td>Postal Code</td>
                    <td>Country</td>
                </tr>
                @foreach($customer_data as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->password }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>{{ $customer->updated_at }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>
@endsection


<!-- ================== inline-js ================== -->
@section('inline-js')
    <script>
        $(document).ready(function () {
            $('.delete_form').on('submit', function () {
                if (confirm("Are you sure you want to delete it ?")) {
                    return true
                } else {
                    return false
                }
            })



            fetch_customer_data();

            function fetch_customer_data(query = '')
            {
                $.ajax({
                    url:"{{ route('live_search.search') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function(data)
                    {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function(){
                var query = $(this).val();
                fetch_customer_data(query);
            });

        });
    </script>
@endsection
<!-- ================== /inline-js ================== -->