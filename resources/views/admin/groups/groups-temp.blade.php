@extends('admin.layouts.master')
@section('content')
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 d-flex align-items-center">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Chats</li>
                </ol>
              </nav>
        </div>
        <div class="col-6">
            <div class="text-end upgrade-btn">
                <a href="{{ route('admin.chats.addGroup') }}" class="btn btn-primary text-white"><i class="mdi mdi-plus"></i> Send Group Chat</a>
            </div>
        </div>
    </div>
</div>
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
    <div class="row">
        <div class="col-12">
            {{-- wa template --}}
                        
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card chat-app">
                            <div id="plist" class="people-list" style="background-color: #fff">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-account-search"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search...">
                                </div>
                                <ul class="list-unstyled chat-list mt-2 mb-0">
                                    @foreach ($getListGroups as $groups)
                                        <a href="{{ route('admin.groupChats', $groups->id) }}" style="color:black;">
                                            <li class="clearfix">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                                <div class="about">
                                                    <div class="name">{{ trim($groups->name, "@g.us") }}<button type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="Group ID: {{ trim($groups->id, "@g.us") }}" style="border: none; background: none;" onclick="copyToClipboard()"><span hidden>{{ trim($groups->id, "@g.us") }}</span><i class="mdi mdi-alert-circle-outline"></i></button></div>
                                                    <div class="status"> <i class="fa fa-circle offline"></i> {{ date('d-M G:i:s',$groups->conversationTimestamp) }} </div>                                            
                                                </div>
                                            </li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            <script>
                                function copyToClipboard(element) {
                                    var $temp = $("<input>");
                                    $("body").append($temp);
                                    $temp.val($(element).text()).select();
                                    document.execCommand("copy");
                                    $temp.remove();
                                    }
                            </script>
                            {{-- @if($detailChat['data']->count()>0)
                            <div class="chat">
                                <div class="chat-header clearfix">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="avatar">
                                            </a>
                                            <div class="chat-about">
                                                <h4 class="m-b-0" style="padding-top: 10px;">+{{ Session::get('number') }}</h4>
                                                <small>Last seen: 2 hours ago</small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 hidden-sm text-right">
                                            <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-history" style="opacity: 0.7; display: flex;
                                flex-direction: column-reverse;">
                                    <ul class="m-b-0" > --}}
                                        {{-- @foreach ($detailChat['data'] as $chat)

                                        <li class="clearfix">
                                            <div class="message-data text-right" style="text-align: center;">
                                                @if(date('d', strtotime($chat->created_at)) == date('d'))
                                                <span class="message-data-time badge bg-secondary" style="color: white; border-radius: 5px;">today {{ date('G:i:s', strtotime($chat->created_at)) }}</span>
                                                @else
                                                <span class="message-data-time badge bg-secondary" style="color: white; border-radius: 5px;">{{ date('d-M G:i:s', strtotime($chat->created_at)) }}</span>
                                                @endif
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                            </div>
                                            <div class="message other-message float-right"> {{ $chat->text }} </div>
                                            @if($chat->status == 1)
                                                <div class="float-right" style="padding-top: 20px; padding-right: 5px;"><i class="mdi mdi-check-all" style="color: #05bdf5;"></i></div>
                                            @else
                                                <div class="float-right" style="padding-top: 20px; padding-right: 5px;"><i class="mdi mdi-close-circle-outline" style="color: red;"></i></div>
                                            @endif
                                        </li>
                                        
                                        @endforeach --}}
                                        {{-- <li class="clearfix">
                                            <div class="message-data text-right">
                                                <span class="message-data-time">10:10 AM, Today</span>
                                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                                            </div>
                                            <div class="message other-message float-right"> Hi Aiden, how are you? How is the project coming along? </div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:12 AM, Today</span>
                                            </div>
                                            <div class="message my-message">Are we meeting today?</div>                                    
                                        </li>                               
                                        <li class="clearfix">
                                            <div class="message-data">
                                                <span class="message-data-time">10:15 AM, Today</span>
                                            </div>
                                            <div class="message my-message">Project has been already finished and I have results to show you.</div>
                                        </li> --}}
                                    {{-- </ul>
                                </div>
                                <form action="{{ route('admin.chats.postChat') }}">
                                <div class="chat-message clearfix">
                                    <div class="input-group mb-0">
                                            <div class="input-group-prepend">
                                                <a href="" class="input-group-text" style="background: none; border: none;"><i class="mdi mdi-attachment"></i></a>
                                            </div>
                                            <div class="input-group-prepend">
                                                <button type="submit" class="input-group-text"><i class="mdi mdi-send"></i></button>
                                            </div>
                                            <input type="text" name="text" class="form-control" placeholder="Enter text here...">                                    
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @else
                            <div class="chat" style="height: 570px; opacity: 0.5;">
                                <div class="chat-history" style="height: 570px">
                                    <h2 style="text-align: center; padding-top: 250px;"><i><u>SELECT CHAT</u></i></h2>
                                </div>
                            </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        <style type="text/css">
                    body{
                        background-color: #f4f7f6;
                        margin-top:20px;
                    }
                    .card {
                        background: #fff;
                        transition: .5s;
                        border: 0;
                        margin-bottom: 30px;
                        border-radius: .55rem;
                        position: relative;
                        width: 100%;
                        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
                    }
                    .chat-app .people-list {
                        width: 400px;
                        position: absolute;
                        left: 0;
                        top: 0;
                        padding: 20px;
                        z-index: 7;
                    }
                    
                    .chat-app .chat {
                        margin-left: 280px;
                        border-left: 1px solid #eaeaea
                    }
                    
                    .people-list {
                        -moz-transition: .5s;
                        -o-transition: .5s;
                        -webkit-transition: .5s;
                        transition: .5s
                    }
                    
                    .people-list .chat-list li {
                        padding: 10px 15px;
                        list-style: none;
                        border-radius: 3px
                    }
                    
                    .people-list .chat-list li:hover {
                        background: #efefef;
                        cursor: pointer
                    }
                    
                    .people-list .chat-list li.active {
                        background: #efefef
                    }
                    
                    .people-list .chat-list li .name {
                        font-size: 15px
                    }
                    
                    .people-list .chat-list img {
                        width: 45px;
                        border-radius: 50%
                    }
                    
                    .people-list img {
                        float: left;
                        border-radius: 50%
                    }
                    
                    .people-list .about {
                        float: left;
                        padding-left: 8px
                    }
                    
                    .people-list .status {
                        color: #999;
                        font-size: 13px
                    }
                    
                    .chat .chat-header {
                        padding: 15px 20px;
                        border-bottom: 2px solid #f4f7f6
                    }
                    
                    .chat .chat-header img {
                        float: left;
                        border-radius: 40px;
                        width: 40px
                    }
                    
                    .chat .chat-header .chat-about {
                        float: left;
                        padding-left: 10px
                    }
                    
                    .chat .chat-history {
                        padding: 20px;
                        border-bottom: 2px solid #fff;
                        background-image: url("/assets/images/wa-bg.jpg") ;
                    }
                    
                    .chat .chat-history ul {
                        padding: 0
                    }
                    
                    .chat .chat-history ul li {
                        list-style: none;
                        margin-bottom: 30px
                    }
                    
                    .chat .chat-history ul li:last-child {
                        margin-bottom: 0px
                    }
                    
                    .chat .chat-history .message-data {
                        margin-bottom: 15px
                    }
                    
                    .chat .chat-history .message-data img {
                        border-radius: 40px;
                        width: 40px
                    }
                    
                    .chat .chat-history .message-data-time {
                        color: #434651;
                        padding-left: 6px
                    }
                    
                    .chat .chat-history .message {
                        color: #444;
                        padding: 18px 20px;
                        line-height: 26px;
                        font-size: 16px;
                        border-radius: 7px;
                        display: inline-block;
                        position: relative
                    }
                    
                    .chat .chat-history .message:after {
                        bottom: 100%;
                        left: 7%;
                        border: solid transparent;
                        content: " ";
                        height: 0;
                        width: 0;
                        position: absolute;
                        pointer-events: none;
                        border-bottom-color: #fff;
                        border-width: 10px;
                        margin-left: -10px
                    }
                    
                    .chat .chat-history .my-message {
                        background: #efefef
                    }
                    
                    .chat .chat-history .my-message:after {
                        bottom: 100%;
                        left: 30px;
                        border: solid transparent;
                        content: " ";
                        height: 0;
                        width: 0;
                        position: absolute;
                        pointer-events: none;
                        border-bottom-color: #efefef;
                        border-width: 10px;
                        margin-left: -10px
                    }
                    
                    .chat .chat-history .other-message {
                        background: #e8f1f3;
                        text-align: right
                    }
                    
                    .chat .chat-history .other-message:after {
                        border-bottom-color: #e8f1f3;
                        left: 93%
                    }
                    
                    .chat .chat-message {
                        padding: 20px
                    }
                    
                    .online,
                    .offline,
                    .me {
                        margin-right: 2px;
                        font-size: 8px;
                        vertical-align: middle
                    }
                    
                    .online {
                        color: #86c541
                    }
                    
                    .offline {
                        color: #e47297
                    }
                    
                    .me {
                        color: #1d8ecd
                    }
                    
                    .float-right {
                        float: right
                    }
                    
                    .clearfix:after {
                        visibility: hidden;
                        display: block;
                        font-size: 0;
                        content: " ";
                        clear: both;
                        height: 0
                    }
                    
                    @media only screen and (max-width: 767px) {
                        .chat-app .people-list {
                            height: 465px;
                            width: 100%;
                            overflow-x: auto;
                            background: #fff;
                            left: -400px;
                            display: none
                        }
                        .chat-app .people-list.open {
                            left: 0
                        }
                        .chat-app .chat {
                            margin: 0
                        }
                        .chat-app .chat .chat-header {
                            border-radius: 0.55rem 0.55rem 0 0
                        }
                        .chat-app .chat-history {
                            height: 300px;
                            overflow-x: auto
                        }
                    }
                    
                    @media only screen and (min-width: 768px) and (max-width: 992px) {
                        .chat-app .chat-list {
                            height: 650px;
                            overflow-x: auto
                        }
                        .chat-app .chat-history {
                            height: 600px;
                            overflow-x: auto
                        }
                    }
                    
                    @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
                        .chat-app .chat-list {
                            height: 480px;
                            overflow-x: auto
                        }
                        .chat-app .chat-history {
                            height: calc(100vh - 350px);
                            overflow-x: auto
                        }
                    }

                    @media only screen and (min-device-width: 1024px) and (max-device-width: 2048px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
                        .chat-app .chat-list {
                            height: 480px;
                            overflow-x: auto
                        }
                        .chat-app .chat-history {
                            height: calc(100vh - 350px);
                            overflow-x: auto
                        }
                    }
                    </style>
                    </div>

            {{-- wa template --}}
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
@stop