@extends('layouts2.master')

@section('content')

    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
    @include('layouts2.breadcrumb')
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
            <!-- Row -->
            <div class="row">
                <div class="col-12">
                    <div class="card" id="manage-modal">
                        <div class="card-body">
                            <h4 class="card-title modalTitle">{{session()->get( 'SEO.vTitle')}}</h4>
                            <h6 class="card-subtitle">{{$vSummary or ''}}</h6>
                        </div>
                        <hr>
                        <form class="form-horizontal" data-url="{{ url('news') }}">
                            <div class="card-body messageInfo-modal">
                                <h4 class="card-title"></h4>
                                <div class="form-group row">
                                    <label for="com1" class="col-sm-3 text-right control-label col-form-label">發送者</label>
                                    <div class="col-sm-9">
                                        {{$info->iSource or 'Self'}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="com2" class="col-sm-3 text-right control-label col-form-label">目標階層</label>
                                    <div class="col-sm-9">
                                        <select class="form-control iHead" id="com2" >
                                            @if(isset($info))
                                                <option value="10" @if($info->iHead<20) selected @endif>{{$permission['2'] or ''}}</option>
                                                <option value="20" @if($info->iHead<30 && $info->iHead>19) selected @endif>1.{{$permission['10'] or ''}}</option>
                                                <option value="30" @if($info->iHead<40 && $info->iHead>29) selected @endif>2.{{$permission['20'] or ''}}</option>
                                                <option value="40" @if($info->iHead<50 && $info->iHead>39) selected @endif>3.{{$permission['30'] or ''}}</option>
                                                <option value="50" @if($info->iHead<60 && $info->iHead>49) selected @endif>4.{{$permission['40'] or ''}}</option>
                                                <option value="60" @if($info->iHead<70 && $info->iHead>59) selected @endif>5.{{$permission['50'] or ''}}</option>
                                                <option value="70" @if($info->iHead<80 && $info->iHead>69) selected @endif>6.{{$permission['60'] or ''}}</option>
                                            @else
                                                @if(isset($permission))
                                                @foreach($permission as $key => $value)
                                                    @if($key=='2')
                                                        <option value="10">{{$value or ''}}</option>
                                                    @else
                                                        <option value="{{ intval($key)+10 }}">{{$value or ''}}</option>
                                                    @endif
                                                @endforeach
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="com3" class="col-sm-3 text-right control-label col-form-label">標頭</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control vTitle" id="com3" placeholder="" value="{{$info->vTitle or ''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="com4" class="col-sm-3 text-right control-label col-form-label">概要</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control vSummary" id="com4" placeholder="" value="{{ $info->vSummary or ''}}">
                                    </div>
                                </div>
                                {{--<div class="form-group row">--}}
                                {{--<label for="com5" class="col-sm-3 text-right control-label col-form-label">Detail</label>--}}
                                {{--<div class="col-sm-9">--}}
                                {{--<input type="text" class="form-control vDetail" id="com5" placeholder="" value="{{ $info->vDetail or ''}}">--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group row">
                                    <label for="img1" class="col-sm-3 text-right control-label col-form-label">圖片</label>
                                    <div class="col-sm-9">
                                        <a class="btn-image-modal" data-modal="image-form" data-id="">
                                            <img src="{{$info->vImages or url('images/empty.jpg')}}" style="height:140px">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="form-group m-b-0 text-right">
                                    @if(isset($info))
                                        <button type="button" class="btn btn-info waves-effect waves-light btn-dosave" data-id="{{$info->iId or ''}}">Save</button>
                                    @else
                                        <button type="button" class="btn btn-info waves-effect waves-light btn-doadd">Add</button>
                                    @endif
                                    <button type="button" class="btn btn-dark waves-effect waves-light btn-cancel">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->

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
    <script type="text/javascript">
        var current_data = [];
        var url_doadd = "";
        {{--var url_dosave = "{{ url('web/'.implode( '/', $module ).'/dosave')}}";--}}
        $(document).ready(function () {
            //
            var modal = $("#manage-modal");
            current_modal = modal.find('.messageInfo-modal');
            //
            $(".btn-cancel").click(function () {
                history.back();
            });
            //
            $(".btn-doadd").click(function () {
                let self = this;
                //
                var data = {"_token": "{{ csrf_token() }}"};
                data.title = current_modal.find(".vTitle").val();
                data.detail = current_modal.find(".vSummary").val();
                //
                $.ajax({
                    url: modal.find('form').data('url'),
                    type: "POST",
                    data: data,
                    resetForm: true,
                    success: function (rtndata) {
                        if (rtndata.status) {
                            //
                            //sendNotifyMessage(rtndata.newid , rtndata.heads_token , current_modal.find(".vTitle").val() , current_modal.find(".vSummary").val());
                            //
                            toastr.success(rtndata.message, "{{trans('_web_alert.notice')}}");
                            setTimeout(function () {
                                location.href = rtndata.redirectUrl;
                            }, 1000)
                        } else {
                            toastr.error(rtndata.message, "{{trans('_web_alert.notice')}}");
                        }
                    },
                    error: function (err) {
                        console.log(err.responseJSON);
                        toastr.error(JSON.stringify(err.responseJSON), "{{trans('_web_alert.notice')}}");
                    }
                });
            });
            //
            $(".btn-dosave").click(function () {
                //
                var data = {"_token": "{{ csrf_token() }}"};
                data.iId = $(this).data('id');
                data.iSource = current_modal.find(".iSource").val();
                data.iHead = current_modal.find(".iHead").val();
                data.vTitle = current_modal.find(".vTitle").val();
                data.vSummary = current_modal.find(".vSummary").val();
                data.vImages = current_modal.find("img").attr('src');
                //
                $.ajax({
                    url: url_dosave,
                    type: "POST",
                    data: data,
                    resetForm: true,
                    success: function (rtndata) {
                        if (rtndata.status) {
                            //
                            //sendNotifyMessage(rtndata.newid , rtndata.heads_token , current_modal.find(".vTitle").val() , current_modal.find(".vSummary").val());
                            //
                            toastr.success(rtndata.message, "{{trans('_web_alert.notice')}}");
                            setTimeout(function () {
                                location.href = rtndata.rtnurl;
                            }, 1000)
                        } else {
                            toastr.error(rtndata.message, "{{trans('_web_alert.notice')}}");
                        }
                    }
                });
            });
        });
        //
        //送出推播、掛在WEB通知
        let send_notify = function sendNotifyMessage( id , DeliverList , title , message){
            //要送的標題
            // var title = "緊急通知";
            //要送的內文
            // var message = "XX水庫因地震發現裂痕！";
            //需要通知手機的token
            // var token = "fk9IJMONhCs:APA91bGq9zJ9eYS5kXQjgyk2p3UUsRhOxehXBSifmFV65B1kyE6sGDJvtP4uMS8-mpc1XYkjOwHsYfV-1rZdCemh4KK2RrcnDMX7l3riqtwvM8u3o4YhfLIO7nkrLfwAMZm1Qk8WulO9";
            //該則通知的所屬網址 如 http://reservoir.kahap.com/web/message/center/attr/2564
            var url = "http://reservoir.kahap.com/web/message/center" + /attr/ + id;
            //傳送token 找哪些是要收到的機子、A水庫所屬的管理員
            // var DeliverList = [];
            // DeliverList.push(token);//新增token
            /*上方為所需變更之資料*/

            $.ajax({
                type:"post",
                url:"https://fcm.googleapis.com/fcm/send",
                cache:false,
                {{--headers: {!! urldecode($sendNotifyMessageHeaders) !!},--}}
                data:JSON.stringify({
                    "priority":"high",
                    "data":{
                        "Title" : title,
                        "body" : message,
                        "url" : url
                    },
                    "registration_ids":DeliverList
                }),
                success:function(result){
                    JSON.stringify(result);
                },
                error:function(result){
                    JSON.stringify(result);
                }
            });
        }
    </script>
@endsection
<!-- ================== /inline-js ================== -->