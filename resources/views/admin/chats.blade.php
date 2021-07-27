@extends('admin.layouts.app')
@section('title','Chats')

@section('css')
@endsection

@section('content')

<div class="dashboard-main chats">
    @include('admin.layouts.navbar')
    <section class="middle-section">
        <div class="middle">
            <div class="middle-content">
                <div class="info-middle-content">
                    <div class="chats-main">
                        <div class="chat-left">
                            <div class="top-search">
                            <form action="" method="GET" >
                                <input type="text" name="s" placeholder="Search" value="<?=(isset($_GET['s']))?$_GET['s']:''?>" />
                                <button type="submit" value="search" name="search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                                @csrf
                            </form>
                            </div>
                            <div class="all-message">
                            	<div class="al-title d-flex align-items-center justify-content-between">
                                    <h5>
                                        All Messages
                                        <span class="count">{{$data['unread_messages']}}</span>
                                    </h5>
                                    <!-- <div class="dots">...</div> -->
                                </div>
                                <ul class="nav nav-tabs user-list">
                                    <?php $i=1; ?>
                                    @foreach($data['users'] as $user)
                                    <?php $recent_chat = App\admin\Chat::getLastChatByUser(sp_decryption(session()->get('admin_id')),$user->id);  ?>

                                	<li>
                                        <a href="#userchat{{$user->id}}" <?php if(isset($_GET['userid'])){ if($_GET['userid']==$user->id){ echo 'class="active user-lnk"'; } }else{?> class="<?=($i==1)?'active user-lnk':''?><?php } ?>" data-toggle="tab">
                                        	<div class="msg-body d-flex">
                                            	<div class="msg-img">
                                                	<img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}" alt=""/>
                                                </div>
                                                <div class="msg-center">
                                                	<span class="msg-name">{{$user->name}}</span>
                                                    <p>
                                                        @if($recent_chat)
                                                            {{$recent_chat->messages}}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="msg-right">
                                                	<small>
                                                        @if($recent_chat)
                                                            <?php
                                                            $time2 = date('Y-m-d h:i:s');
                                                            $time1 = strtotime($recent_chat->created_at);
                                                            $time2 = strtotime($time2);
                                                            $difference = ($time2 - $time1);
                                                            $min = (int) $difference;
                                                            if($min > (3600*24)){
                                                                $time = $min/(3600*24);
                                                                $day = (int)$time;
                                                                echo $day.' Days ago';
                                                            }elseif($min > 3600){
                                                                $time = $min/3600;
                                                                $day = (int)$time;
                                                                echo $day.' Hours ago';
                                                            }elseif($min > 60){
                                                                $time = $min/60;
                                                                $day = (int)$time;
                                                                echo $day.' Min ago';
                                                            }else{
                                                                echo $min.' Second ago';
                                                            }
                                                            ?>
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php $i++;?>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="chat-right">
                            <div class="tab-content">
                                <?php $i=1; ?>
                                @foreach($data['users'] as $user)
                                <?php $chats = App\admin\Chat::getChatByUser(sp_decryption(session()->get('admin_id')),$user->id); ?>
                                    <div class="tab-pane <?php if(isset($_GET['userid'])){ if($_GET['userid']==$user->id){ echo 'active'; } }else{?> <?=($i==1)?'active':''?><?php } ?>" id="userchat{{$user->id}}">
                                    	<div class="cta-title">{{$user->name}}
                                        <!-- <span class="dots">...</span> -->
                                        </div>
                                        <div class="cta-content">
                                        	<ul class="cta-cont" id="cta-cont-{{$user->id}}">
                                                @if($chats)
                                                @foreach($chats as $chat)
                                                <?php $user_details = App\admin\User::getRecordById($chat->fromid); ?>
                                                <li id="chat_{{$chat->id}}">
                                                	<div class="ct-img"><figure><img src="{{SYSTEM_SITE_URL}}public/users/{{$user_details->image}}" alt=""/></figure></div>
                                                    <div class="ct-right">
                                                    	<div class="ct-top">{{$user_details->name}}<span>{{date('H:i A',strtotime($chat->created_at))}}</span></div>
                                                        <div class="ct-bottom"><p>{{$chat->messages}}</p></div>
                                                    </div>
                                                </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                            <ul class="cta-cont">
                                                <li class="blank">
                                                	<textarea id="user_message_{{$user->id}}"></textarea>
                                                    <div class="send-upload">
                                                
                                                <button class="send-msg" onclick="sendMessage('{{$user->id}}')" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/send.png"></button>
                                                </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php $i++;?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.layouts.rightsection')    
</div>
  
@include('admin.layouts.modals')

@endsection

@section('js')
<script type="text/javascript">
function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}
function sendMessage(userid){
    var msg = $("#user_message_"+userid).val();
    var image = "{{$data['admin']->image}}";
    if(msg==''){
        alert('Please enter a message....');
        return false;
    }else{
        $.ajax({
            url: '<?php echo SYSTEM_SITE_URL;?>admin/sendMessage',
            data: {msg: msg,toid:userid,id:'','_token':"{{csrf_token()}}"},
            dataType: 'json',
            type: 'POST',
            success: function (result){
                console.log(result.msg);
                if(parseInt(result.code)==1){
                    $("#user_message_"+userid).val('');
                    $("#cta-cont-"+userid).append('<li><div class="ct-img"><figure><img src="{{SYSTEM_SITE_URL}}public/users/'+image+'" alt=""/></figure></div><div class="ct-right"><div class="ct-top">{{$data["admin"]->name}}<span>{{date("H:i A")}}</span></div><div class="ct-bottom"><p>'+msg+'</p></div></div></li>');
                    getUsersListForChat();
                }else{
                    alert('Something went wrong !!');
                    return false;
                }
            }
        });
    }
}

function getUsersListForChat(){
    var search = "{{ isset($_GET['s']) ? $_GET['s'] : ''}}";
    $.ajax({
        url: '<?php echo SYSTEM_SITE_URL;?>ajax/getUpdatedUsersList',
        data: {search: search,'_token':"{{csrf_token()}}"},
        dataType: 'json',
        type: 'POST',
        success: function (result){
            if(parseInt(result.code)==1){
                var data = result.data;
                var html = '';
                $.each(data, function( index, value ) {
                    html += '<li>';
                    html += '<a href="#userchat'+value.id+'" class="'+(index == 0 ? "active" : "")+' user-lnk"  data-toggle="tab" data-id="'+value.id+'">';
                    html += '<div class="msg-body d-flex">';
                    html += '<div class="msg-img">';
                    html += '<img src="{{SYSTEM_SITE_URL}}public/users/'+value.image+'" alt=""/>';
                    html += '</div>';
                    html += '<div class="msg-center">';
                    html += '<span class="msg-name">'+value.name+'</span>';
                    html += '<p>';
                    if(typeof(value.recent_chat) != "undefined" && value.recent_chat !== null) {
                        html += value.recent_chat.messages;
                    }
                    html += '</p>';
                    html += '</div>';
                    html += '<div class="msg-right">';
                    html += '<small>';
                    if(typeof(value.recent_chat) != "undefined" && value.recent_chat !== null) {
                        html += value.interval;
                    }
                    html += '</small>';
                    html += '</div>';
                    html += '</div>';
                    html += '</a>';
                    html += '<li>';
                });
                $('.user-list').empty();
                $('.user-list').html(html);
            }else{
                alert('Something went wrong !!');
                return false;
            }
        }
    });
}
$(document).ready(function() {
    setTimeout(() => {
        $('.active.user-lnk').trigger('click');
    }, 100);
    $(document).on('click', '.user-lnk', function() {
        var id = $(this).attr('data-id');
        console.log(id);
        $.ajax({
            url: '<?php echo SYSTEM_SITE_URL;?>ajax/readMessages',
            data: {id: id, count: $('.count').text(), '_token':"{{csrf_token()}}"},
            dataType: 'json',
            type: 'POST',
            success: function (result){
                if(parseInt(result.code)==1){
                    $(".count").text(result.count);
                }else{
                    alert('Something went wrong !!');
                    return false;
                }
            }
        });
    })
})
</script>
@endsection

</body>
</html>
