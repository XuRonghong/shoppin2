@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <br />
            <h3 align="center">Product List</h3>
            <br />
            @if($message = session()->get('success'))
                <div class="alert alert-success">
                    <p>{{$message}}</p>
                </div>
            @endif
            <div align="right">
                <a href="{{route('product.create')}}" class="btn btn-primary">Add</a>
                <br/>
                <br/>
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Total</th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td>{{$product['name']}}</td>
                    <td>{{$product['price']}}</td>
                    <td>
                        <a class="btn-default" href="{{route('product.edit', $product['id'])}}">Edit</a>
                    </td>
                    <td>
                        <form method="post" action="{{route('product.destroy', $product['id'])}}" class="delete_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
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
        });
    </script>
@endsection
<!-- ================== /inline-js ================== -->