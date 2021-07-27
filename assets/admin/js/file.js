var base_url = "http://phpstack-529148-1805466.cloudwaysapps.com/";
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
            url: base_url+'admin/sendMessage',
            data: {msg: msg,toid:userid,id:'','_token':"{{csrf_token()}}"},
            dataType: 'json',
            type: 'POST',
            success: function (result){
                console.log(result.msg);
                if(parseInt(result.code)==1){
                    $("#user_message_"+userid).val('');
                    $("#cta-cont-"+userid).append('<li><div class="ct-img"><figure><img src="{{SYSTEM_SITE_URL}}public/users/'+image+'" alt=""/></figure></div><div class="ct-right"><div class="ct-top">{{$data["admin"]->name}}<span>{{date("H:i A")}}</span></div><div class="ct-bottom"><p>'+msg+'</p></div></div></li>');
                }else{
                    alert('Something went wrong !!');
                    return false;
                }
            }
        });
    }
}
