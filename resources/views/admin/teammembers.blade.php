@extends('admin.layouts.app')
@section('title','Team Member')

@section('css')
@endsection

@section('content')

<div class="dashboard-main">
  @include('admin.layouts.navbar')
  <section class="middle-section">
    <div class="middle">
      @if(session()->get('fail_msg'))
      <div class="row alert alert-danger text text-center">
          {{session()->get('fail_msg')}}
      </div>
      @elseif(session()->get('succ_msg'))
      <div class="row alert alert-success text text-center">
          {{session()->get('succ_msg')}}
      </div>
      @else
        @if($errors->any())
            {!! implode('', $errors->all('<div class="row alert alert-danger text text-center">:message</div>')) !!}
        @endif
      @endif
      <div class="top-search">
        <form action="" method="GET" >
          <input type="text" name="s" placeholder="Search" value="<?=(isset($_GET['s']))?$_GET['s']:''?>" />
          <button type="submit" value="search" name="search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
          @csrf
        </form>
      </div>
      <div class="middle-content">
      	<div class="team-single">
        	<div class="team-box">
                <label>{{$data['team']->team_name}}</label>
                <ul class="prof">
                  <?php $i=1; ?>
                  @foreach($data['team_members'] as $team_member)
                  <li><img src="{{SYSTEM_SITE_URL}}public/users/{{$team_member->image}}" alt=""></li>
                  <?php if($i==7){break;} $i++;?>
                  @endforeach
                  @if(count($data['team_members'])>$i)
                  <li>+{{count($data['team_members'])-$i}}</li>
                  @endif
                </ul>
                <div class="team-bottom"> <span>{{count($data['team_members'])}} Users</span> </div>
              </div>
        </div>
        <div class="team-list-sec">
        	<div class="ttl">Team Members</div>
          <div class="team-members">
          	<div class="user-single">
            	<div class="user-inner">
                    <a href="#addteammembermodal" data-toggle="modal">Add Team Members<i class="far fa-plus-square"></i></a>
                </div>
            </div>
            <?php $i=1; ?>
            @foreach($data['team_members'] as $team_member)
              <div class="user-single">
                  <div class="user-inner">
                  <div class="dots"><a class="slide" href="javascript:void(0)">...</a>
                  <div class="slide-div">
                    <ul>
                      <li><a href="{{ADMIN_SYSTEM_SITE_URL}}chats">Message</a></li>
                      <li><a href="javascript:void(0)" class="userdetails" data-id="{{$team_member->id}}">Details</a></li>
                      <li><a href="javascript:void(0);" onclick="removeak('{{ADMIN_SYSTEM_SITE_URL}}removefromteam/{{$team_member->tid}}');">Remove</a></li>
                    </ul>
                  </div>
                </div>
                      <div class="user-place"><img src="{{SYSTEM_SITE_URL}}public/users/{{$team_member->image}}" alt=""/></div>
                      <h4>{{$team_member->name}}</h4>
                      <p>{{$team_member->phone}}</p>
                  </div>
              </div>
            <?php $i++;?>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>
  @include('admin.layouts.rightsection')
</div>
@include('admin.layouts.notificationmodal')

<!-- User Modal profile -->
<div class="modal fade" id="user-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">User Profile
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          @csrf
          <input type="hidden" name="image_file">
          <div class="profile-top">
            <div class="profile-pict">
              <div class="circle"> 
                <img id="user_profile_pic" src=""> 
              </div>
            </div>
          </div>
          <div class="profile-middle">
            <div class="pro-grp">
              <label>Name</label>
              <input type="text" name="fname" id="user_fname1" placeholder="First Name" readonly="readonly" />
            </div>
            <div class="pro-grp">
              <label>Email</label>
              <input type="text" id="user_email1" readonly="readonly"/>
            </div>
            <div class="pro-grp">
              <label>Mobile</label>
              <input type="text" name="dob" id="user_phone1" readonly="readonly"/>
            </div>
            <div class="pro-grp last">
            </div>
            <div class="pro-buttons d-flex justify-content-center">
              
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Team User -->
<div class="modal fade" id="addteammembermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="share-header">
          <label>Add Member to team </label>
        </div>
        <div class="mode-content">
          <div class="tab-content">
            <div class="tab-pane active">
              <form action="{{ADMIN_SYSTEM_SITE_URL}}addteammember" method="POST">
                @csrf
              <input type="hidden" name="team_id"  value="{{$data['team_id']}}">
              <div class="cp-tags" id="cptag12">
                <ul>
                  <?php $i=1; $team_members = array(); ?>
                  @foreach($data['team_members'] as $team_member)
                    <li><input type="checkbox"  name="addmember[]" value="{{$team_member->uid}}" checked="checked" /><img src="{{SYSTEM_SITE_URL}}public/users/{{$team_member->image}}"/><span>{{$team_member->name}}</span></li>
                  <?php array_push($team_members,$team_member->uid); $i++;?>
                  @endforeach
                </ul>
              </div>
              <div class="cp-list" id="cplist13">
                <ul>
                  <?php $i=1; ?>
                  @foreach($data['users'] as $user)
                  <?php if(in_array($user->id, $team_members)){continue;} ?>
                    <li><input type="checkbox"  name="addmember[]" value="{{$user->id}}"/><img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}"/><span>{{$user->name}}</span></li>
                  <?php $i++;?>
                  @endforeach
                </ul>
              </div>
              <div class="cp-btns">
                <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
                <button class="share green butn" type="submit" name="submit">Add Member</button> 
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<script type="text/javascript">
$(document).on("click",'.userdetails',function (e){
  e.stopPropagation();
  var userid = $(this).attr('data-id');
  var url1 = "{{SYSTEM_SITE_URL}}";
  $.ajax({
      type: "POST",
      url:"{{SYSTEM_SITE_URL}}ajax/getuserdetails",
      data:{userid:userid, '_token':"{{csrf_token()}}"},
      success: function(data) {
        $("#user-profile-modal .modal-content").html(data.html);
        $("#user-profile-modal").modal('show');
      }
  });
});
</script>
@endsection

</body>
</html>
