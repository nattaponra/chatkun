@extends('chatkun.app')



@section('user_list')
    @foreach($userData as $user)
        <li class="left clearfix chat_user"  data-title="{{$user->id}}"  data-user_name="{{$user->name}}" >
                     <span class="chat-img pull-left">
                     <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                     </span>
            <div class="chat-body clearfix">
                <div class="header_sec">
                    <strong class="primary-font">{{$user->name}}</strong> <strong class="pull-right">
                    </strong>
                </div>
                <div class="contact_sec">
                    <strong class="primary-font">{{$user->email}}</strong> <span class="badge pull-right"></span>
                </div>
            </div>
        </li>

    @endforeach


@endsection



@section('chat_box')
    @foreach($userData as $user)
        <li class="left clearfix">
                     <span class="chat-img1 pull-left">
                     <img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">
                     </span>
            <div class="chat-body1 clearfix">
                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia.</p>
                <div class="chat_time pull-right">09:40PM</div>
            </div>
        </li>


    @endforeach


@endsection



@section('script')


    <script>

        $(document).ready(function() {


      var drawMessage;
            $(".chat_user").click(function(e){
                $("#chat_area").html('');
                $("#chat_area").hide();

                 var user_id=$(this).data('title');
                $("#user_name").text($(this).data('user_name'));
                 $('#to_user_id').val(user_id);
                $.ajax({
                    method: "GET",
                    url: "http://192.168.1.10/chatkun/history/"+user_id,
                    data: { name: "John", location: "Boston" }
                })
                        .done(function( data ) {


                            for(var index=0;index<data.length;index++){
                                if(data[index].user_id==$("#user_id").val()){
                                    drawMessage(data[index].message,data[index].created_at,'left');

                                }else{
                                    drawMessage(data[index].message,data[index].created_at,'right');

                                }

                            }
                            $("#chat_area").fadeIn(500);
                        });


            });

            if(!("WebSocket" in window)){
                $('#chatLog, input, button, #examples').fadeOut("fast");
                $('<p>Oh no, you need a browser that supports WebSockets. How about <a href="http://www.google.com/chrome">Google Chrome</a>?</p>').appendTo('#container');
            }else {
                //The user has WebSockets

                connect();

                function connect() {
                    var socket;
                    var host = "ws://192.168.1.10:9090";
                    try {
                        var socket = new WebSocket(host);
                        socket.onopen = function () {
                            var inputData = {};
                            inputData["message"] = 'connect';
                            inputData["user_id"] = $("#user_id").val();
                            inputData["to_user_id"] = 'connect';
                            socket.send(JSON.stringify(inputData));
                        }
                        socket.onmessage = function (msg) {

                            var newMessage=JSON.parse(msg.data);
                            console.log(newMessage.message);
                            drawMessage(newMessage.message,'', 'right');
                        }
                        socket.onclose = function () {

                        }

                    } catch (exception) {

                    }

                    drawMessage=  function(message,time, side) {
                        $("#chat_area").append('<li class="'+side+' clearfix ">' +
                                '<span class="chat-img1 pull-' + side + '">' +
                                '<img src="https://lh6.googleusercontent.com/-y-MY2satK-E/AAAAAAAAAAI/AAAAAAAAAJU/ER_hFddBheQ/photo.jpg" alt="User Avatar" class="img-circle">' +
                                '</span>' +
                                '<div class="chat-body1 clearfix">' +
                                '<p>' + message + '</p>' +
                                '<div class="chat_time pull-'+side+'">'+time+'</div>' +
                                '</div>' +
                                '</li>');
                        $(".chat_area").animate({ scrollTop: 10000 }, "fast");
                    }

                    function send() {
                        var text = $('.message_input').val();
                        drawMessage(text,'', 'left');
                        if (text != "") {


                            try {
                                var inputData = {};
                                inputData["message"] = text;
                                inputData["user_id"] = $("#user_id").val();
                                inputData["to_user_id"] = $("#to_user_id").val();
                                socket.send(JSON.stringify(inputData));
                                // message('<p class="event">Sent: '+JSON.stringify(inputData))

                            } catch (exception) {

                            }
                            $('.message_input').val('');
                        }

                    }
                        $('.message_input').keypress(function (event) {
                            if (event.keyCode == '13') {
                                send();
                            }
                        });

                        $('#disconnect').click(function () {
                            socket.close();
                        });

                    }//End connect

                 //End else
            }
        });

    </script>
@endsection
