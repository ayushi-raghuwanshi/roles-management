@extends('layouts.main')
@section('custom_css')
    <style>
        .container {
            max-width: 1170px;
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #eff3f4;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #f3e8e8;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #9beaf4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
            background-color: #c1f1be;
            background-image: url({{asset('assets/img/chat_users.jpg')}})
        }

        .active_chat {
            background: #64d2a0;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #e5e2e2;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
            font-weight: bold;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #145060 none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    </style>
@endsection
@section('section')
    <div class="messaging">
        <div class="inbox_msg" style="background-image: url({{asset('assets/img/chat_img.jpg')}});background-repeat:no-repeat;background-size:cover;">
            <div class="inbox_people">
                <div class="headind_srch" style="background-color:#0d5d72">
                    <div class="recent_heading">
                        <h4>Users</h4>
                    </div>
                    <div class="srch_bar">
                        <div class="stylish-input-group">
                            <input type="text" class="search-bar" placeholder="Search" style="background-color: white">
                            <span class="input-group-addon">
                                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="inbox_chat" id="messagesdiv">
                    @include('chat.usersdiv')
                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history scrolling-pagination" style="background-image: url({{url('assets/img/chat_img.jpg')}})"></div>
                <div class="type_msg">
                    <div class="input_msg_write" style="background-color: white;">
                        <input type="text" class="write_msg" placeholder="Type a message" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_scripts')
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";
    $(document).ready(function () {

        $(".type_msg").hide();
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('3d0e8008bfa418ed4d70', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            if (my_id == data.from) {
                $('#' + data.to).click();
            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {
                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.from).find('.pending').html());

                    if (pending) {
                        $('#' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#' + data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });

        let page = 1;
        let total_page = 0;
        $('.mesgs .msg_history').on('scroll', function() {
            if($(this).scrollTop() + $(this).innerHeight() + 1 >= $(this)[0].scrollHeight) {
                if(page<total_page){
                    page++;
                    infinteLoadMore(page);
                }
            }
        });
        $("#messagesdiv").on("click",".user", function(){
            $('.user').removeClass('active_chat');
            $(this).addClass('active_chat');
            $(this).find('.pending').remove();
            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "message/" + receiver_id+"?page=" + 1, // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                    $('.mesgs .msg_history').html(data.view);
                    $(".type_msg").show();
                    total_page = data.total_pages;
                    scrollToBottomFunc();
                }
            });
        });

        function infinteLoadMore(page) {
            $.ajax({
                type: "get",
                datatype: "html",
                url: "message/" + receiver_id+"?page=" + page, // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                    if (data.view.length != 0) {
                        $('.mesgs .msg_history').append(data.view);
                        $(".type_msg").show();
                        scrollToBottomFunc();
                    }
                    return;
                }
            });
        }

        $(document).on('keyup', '.write_msg', function (e) {
            var message = $(this).val();
            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "message", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {

                    },
                    error: function (jqXHR, status, err) {
                    },
                    complete: function () {
                        page = '';
                        scrollToBottomFunc();
                    }
                })
            }
        });
    });
    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.msg_history').animate({
            scrollTop: $('.msg_history').get(0).scrollHeight
        }, 50);
    }

    let nextUserPageUrl = '{{ $users->subusers->nextPageUrl() }}';
    $('.inbox_chat').scroll(function () {
        if (nextUserPageUrl) {
            loadMoreUsers();
        }
    });
    function loadMoreUsers() {
        $.ajax({
            url: nextUserPageUrl,
            type: 'get',
            beforeSend: function () {
                nextUserPageUrl = '';
            },
            success: function (data) {
                nextUserPageUrl = data.nextPageUrl;
                $('#messagesdiv').append(data.view);
            },
            error: function (xhr, status, error) {
                console.error("Error loading more users:", error);
            }
        });
    }
</script>
@endpush
