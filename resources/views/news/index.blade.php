@extends('layout.master')

@section('content')

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
    {{--@include('_web._layouts.breadcrumb')--}}
    <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- basic table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{--<h4 class="card-title">{{$vTitle or ''}}</h4>--}}
                            {{--<h6 class="card-subtitle">{{$vSummary or ''}}</h6>--}}
                            <div class="table-responsive waitme">
                                <table id="dt_basic" class="table table-striped table-bordered " data-url="{{route('news.list')}}">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>

@endsection



<!-- ================== inline-js ================== -->
@section('inline-js')
    <!--  -->
    <!-- Public Crop_Image -->
    {{--@include('_web._js.crop_image')--}}
    <!-- end -->
    <!-- Public SummerNote -->
    {{--@include('_web._js.summernote')--}}
    <!-- end -->
    <script>
        // var current_data = [];
        {{--var ajax_source = "{{ url('web/'.implode( '/', $module ).'/getlist')}}";--}}
        {{--var ajax_Table = "{{ url('web/'.implode( '/', $module ).'/getlist')}}";--}}
        {{--var url_dosave_show = "{{ url('web/'.implode( '/', $module ).'/dosaveshow')}}";--}}
        {{--var url_add = "{{ url('news/create')}}";--}}
        {{--var url_doadd = "{{ url('news/store')}}";--}}
        var url_ = "{{ url('news')}}";
        {{--var url_dosave = "{{ url('news')}}";--}}
        {{--var url_dodel = "{{ url('web/'.implode( '/', $module ).'/dodel')}}";--}}
        {{--var url_attr = "{{ url('web/'.implode( '/', $module ).'/attr')}}";--}}
        {{--var url_sub = "{{ url('web/'.implode( '/', $module ).'/sub')}}";--}}

        $(document).ready(function () {
            /* BASIC ;*/
            // loading .....
            run_waitMe($('.waitme'));
            var i = 0;
            let data_table = $('#dt_basic');
            var table = data_table.dataTable({
                "serverSide": true,
                "stateSave": true,
                "scrollX": true,
                "scrollY": '60vh',
                // 'bProcessing': true,
                'sServerMethod': 'GET',
                "aoColumns": [
                    {
                        "sTitle": "ID",
                        "mData": "id",
                        "width": "40px",
                        "sName": "id",
                        "bSearchable": false,
                        "mRender": function (data, type, row) {
                            return data;
                        }
                    },
                    {"sTitle": "標頭", "mData": "title", "width": "300px", "sName": "title"},
                    {"sTitle": "content", "mData": "detail", "width": "300px", "sName": "detail"},
                    {
                        "sTitle": "",
                        "bSortable": false,
                        "bSearchable": false,
                        "width": '140px',
                        "mRender": function (data, type, row) {
                            // current_data[row.id] = row;
                            var btn = "無功能";
                                btn = '<button class="btn btn-xs btn-default btn-attributes" title="全部資訊"><i class="fa fa-book" aria-hidden="true"></i></button>';
                                <?php if (session("member.iAcType")<10){ ?>
                                    btn += '<button class="btn btn-xs btn-default btn-edit" title="修改"><i class="fa fa-pencil" aria-hidden="true">修改</i></button>';
                                btn += '<button class="pull-right btn btn-xs btn-danger btn-del" title="刪除"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                                <?php } ?>
                            $('.waitme').waitMe('hide');
                            return btn;
                        }
                    },
                ],
                "sAjaxSource": data_table.data('url'),
                "ajax": data_table.data('url'),
                // "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                //     "t" +
                //     "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "autoWidth": true,
                "oLanguage": {
                    "sSearch": 'Search:<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
            });
            $('div.dataTables_wrapper div.dataTables_paginate').click(function () {
                run_waitMe($('.waitme'));
                setTimeout(function(){ $('.waitme').waitMe('hide') }, 1000);   //逾時1秒關閉讀取
            });
            $('#dt_basic_length select').change(function () {
                run_waitMe($('.waitme'));
                setTimeout(function(){ $('.waitme').waitMe('hide') }, 1000);   //逾時1秒關閉讀取
            });
            setTimeout(function(){ $('.waitme').waitMe('hide') }, 10000);   //逾時10秒關閉讀取
            /* END BASIC */


            //
            $("#dt_basic").on('click', '.btn-edit', function () {
                //var id = $(this).closest('tr').attr('id');
                var id = $(this).closest('tr').find('td').first().text();
                location.href = url_ + '/' + id + '/edit';
            });
            //
            $("#dt_basic").on('click', '.btn-del', function () {
                //var id = $(this).closest('tr').attr('id');
                var id = $(this).closest('tr').find('td').first().text();
                var data = {
                    "_token": "{{ csrf_token() }}"
                };
                data.id = id;
                swal({
                    title: "{{trans('_web_alert.del.title')}}",
                    text: "{{trans('_web_alert.del.note')}}",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "{{trans('_web_alert.cancel')}}",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{trans('_web_alert.ok')}}",
                    closeOnConfirm: true
                }, function () {
                    $.ajax({
                        url: url_dodel,
                        data: data,
                        type: "DELETE",
                        //async: false,
                        success: function (rtndata) {
                            if (rtndata.status) {
                                toastr.success(rtndata.message, "{{trans('_web_alert.notice')}}")
                                setTimeout(function () {
                                    table.api().ajax.reload(null, false);
                                }, 100);
                            } else {
                                swal("{{trans('_web_alert.notice')}}", rtndata.message, "error");
                            }
                        },
                        error: function (err) {
                            console.log(err.responseJSON);
                            toastr.error(JSON.stringify(err.responseJSON), "{{trans('_web_alert.notice')}}");
                        }
                    });
                });
            });
            //
            $("#dt_basic").on('click', '.btn-attributes', function () {
                //var id = $(this).closest('tr').attr('id');
                var id = $(this).closest('tr').find('td').first().text();
                location.href = url_attr + '/' + id;
            });
            //
            var ii = 1;
            $('thead>tr>th').each(function () {
                if (ii==4){
                    $(this).click();
                    $(this).click();
                }
                ii++;
            });
        });
    </script>
@endsection
<!-- ================== /inline-js ================== -->