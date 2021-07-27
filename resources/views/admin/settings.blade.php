@extends('admin.layouts.app')
@section('title','Settings')

@section('css')
@endsection

@section('content')

<div class="dashboard-main">
  @include('admin.layouts.navbar')
  <section class="middle-section">
    <div class="middle">
      <div class="middle-content">
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
        <div class="info-tab">
          <ul class="nav nav-tabs ">
            <li><a class="<?php if(isset($_GET['active'])){ if($_GET['active']=='teams'){ echo 'active'; } }?>" href="#team" data-toggle="tab">Team</a></li>
            <li><a class="<?php if(isset($_GET['active'])){ if($_GET['active']=='users'){ echo 'active'; } }?>" href="#user" data-toggle="tab">Users</a></li>
            <li><a class="<?php if(isset($_GET['active'])){ if($_GET['active']=='uploads'){ echo 'active'; } }?>" href="#uploads" data-toggle="tab">Uploads</a></li>
          </ul>
        </div>
        <div class="info-middle-content">
          <div class="tab-content">
            <div class="tab-pane <?php if(isset($_GET['active'])){ if($_GET['active']=='teams'){ echo 'active'; } }?>" id="team">
              <div class="top-search">
                <form action="" method="GET" >
                  <input type="hidden" name="active" value="teams">
                  <input type="text" name="ts" placeholder="Search" value="<?=(isset($_GET['ts']))?$_GET['ts']:''?>" />
                  <button type="submit" value="search" name="team_search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                  @csrf
                </form>
              </div>
              <div class="cmn-mid">
              <div class="cmn-left">
              <label>Sorting</label>
              <select name="team_sort" class="team_sorting">
                      <option value="1" <?= (isset($_GET['team_sorting']) && $_GET['team_sorting'] == 1) ? 'selected' : '' ?> >Newest to Oldest</option>
                      <option value="2" <?= (isset($_GET['team_sorting']) && $_GET['team_sorting'] == 2) ? 'selected' : '' ?>>A-Z</option>
                      <option value="3" <?= (isset($_GET['team_sorting']) && $_GET['team_sorting'] == 3) ? 'selected' : '' ?>>Z-A</option>
                    </select>
              </div>
              	<div id="btngridcontain" class="grid-sec">
              	<label>View:</label>
  				<button class="btn-list btn-set"><img src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/grid.png"><img class="act" src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/grid-active.png"></button>	
                <button class="btn-grid btn-set active"><img src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/list.png"><img class="act" src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/list-active.png"></button>
              </div>
              </div>
              <div class="grid-container team-lnt">
              <ul class="team-list team-tab">
                <li class="add"> <a href="#crt-team-modal" data-toggle="modal" >Add Team<i class="far fa-plus-square"></i></a> </li>
                @foreach($data['teams'] as $team)
                <?php $model = app("App\\admin\\Team"); $team_members = $model::getMembersByTeam($team->id); ?>
                  <li>
                    <div class="team-box"  onclick="location.href='{{ADMIN_SYSTEM_SITE_URL}}addteamuser/{{$team->id}}'">
                      <label>{{$team->team_name}}</label>
                      <ul class="prof">
                        <?php $i=1; ?>
                        @foreach($team_members as $team_member)
                          <li><img src="{{SYSTEM_SITE_URL}}public/users/{{$team_member->image}}" alt=""></li>
                        <?php if($i==7){break;} $i++;?>
                        @endforeach
                        @if(count($team_members)>$i)
                        <li>+{{count($team_members)-$i}}</li>
                        @endif
                      </ul>
                      <div class="team-bottom"> <span>{{count($team_members)}} Users</span> </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
            </div>
            <div class="tab-pane <?php if(isset($_GET['active'])){ if($_GET['active']=='users'){ echo 'active'; } }?>" id="user">
              <div class="top-search">
                <form action="" method="GET" >
                  <input type="hidden" name="active" value="users">
                  <input type="text" name="us" placeholder="Search" value="<?=(isset($_GET['us']))?$_GET['us']:''?>" />
                  <button type="submit" value="search" name="user_search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                  @csrf
                </form>
              </div>
              <div class="selectall">
              <a href="javascript:void(0);" class="ceate_team_btn"><button class="btn">Create Team</button></a>
              </div>
              <div class="cmn-mid">
              <div class="cmn-left">
              <label>Sorting</label>
              <select name="user_sort" class="user_sorting">
                      <option value="1" <?= (isset($_GET['user_sorting']) && $_GET['user_sorting'] == 1) ? 'selected' : '' ?> >Newest to Oldest</option>
                      <option value="2" <?= (isset($_GET['user_sorting']) && $_GET['user_sorting'] == 2) ? 'selected' : '' ?>>A-Z</option>
                      <option value="3" <?= (isset($_GET['user_sorting']) && $_GET['user_sorting'] == 3) ? 'selected' : '' ?>>Z-A</option>
              </select>
              </div>
              	<div id="btngridcontain" class="grid-sec">
              	<label>View:</label>
  				<button class="btn-list btn-set"><img src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/grid.png"><img class="act" src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/grid-active.png"></button>	
                <button class="btn-grid btn-set active"><img src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/list.png"><img class="act" src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/list-active.png"></button>
              </div>
              </div>
              <div class="team-members grid-container">
                <div class="user-single">
                  <div class="user-inner"> <a href="#addusermodal" data-toggle="modal">Add Users<i class="far fa-plus-square"></i></a> </div>
                </div>
                <?php $i=1; ?>
                @foreach($data['users'] as $user)
                  <div class="user-single">
                    <div class="user-inner">
                      <div class="dots"><a class="slide" href="javascript:void(0)">...</a>
                        <div class="slide-div">
                          <ul>
                            <li><a href="{{ADMIN_SYSTEM_SITE_URL}}chats/?userid={{$user->id}}">Message</a></li>
                            <li><a href="javascript:void(0)" class="userdetails" data-id="{{$user->id}}" >Details</a></li>
                            <li><a href="javascript:void(0);" onclick="removeak('{{ADMIN_SYSTEM_SITE_URL}}removeuser/{{$user->id}}');">Remove</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="user-place"><img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}" alt=""/></div>
                      <div class="select-div">
                      <input type="checkbox" value="{{ $user->id }}" class="selectedUsers" name="selectedUsers[]"/><label></label>
                      </div>
                      <h4>{{$user->name}}</h4>
                      <p>{{$user->phone}}</p>
                    </div>
                  </div>
                <?php $i++;?>
                @endforeach
              </div>
            </div>
            <div class="tab-pane <?php if(isset($_GET['active'])){ if($_GET['active']=='uploads'){ echo 'active'; } }?>" id="uploads">
              <div class="top-search">
                <form action="" method="GET" >
                  <input type="hidden" name="active" value="uploads">
                  <input type="text" name="ups" placeholder="Search" value="<?=(isset($_GET['ups']))?$_GET['ups']:''?>" />
                  <button type="submit" value="search" name="usearch"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                  @csrf
                </form>
              </div>
              <div class="top-upload">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#createfile-modal">Upload New</a>
              </div>
              <div class="ttl">Recent Uploads</div>
              <div class="upload-sc d-flex">
                <div class="upd-left">
                  <div class="up-header">
                    <label>Name</label>
                    <label>Members</label>
                    <label>Uploaded</label>
                    <label>&nbsp;</label>
                  </div>
                  <div class="up-content">
                    <ul>
                      <?php $i=1; ?>
                      @foreach($data['recentfiles'] as $recentfile)
                        <li>
                          <div class="up-col">
                            @if($recentfile->ext=='pdf')
                             {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/>' !!}
                            @elseif($recentfile->ext=='png')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/>' !!}
                            @elseif($recentfile->ext=='txt')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/>' !!}
                            @elseif($recentfile->ext=='doc')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/>' !!}
                            @else
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/>' !!}
                            @endif
                            <span>{{$recentfile->name}}</span></div>
                          <div class="up-col">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($recentfile->id); $share_teams = $share_model::getsharedteamsbyfile($recentfile->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                            
                          </div>
                          <div class="up-col">{{date('F d, Y',strtotime($recentfile->updated_at))}}</div>
                          <div class="up-col">
                            <div class="dots"> <a class="slide" href="javascript:void(0)">...</a>
                              <div class="slide-div">
                                <ul>
                                  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#share-modal" class="sharefile" data-id="{{$recentfile->id}}" >Share to<small>›</small></a></li>
                                  <li><a href="{{ADMIN_SYSTEM_SITE_URL}}download/{{$recentfile->id}}">Download</a></li>
                                  <li><a href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefile/{{$recentfile->id}}');">Delete</a></li>
                                  <li><a href="javascript:void(0)" class="usermodal" data-id="{{$recentfile->id}}" data-type="file">View</a></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </li>
                      <?php $i++;?>
                      @endforeach
                    </ul>
                  </div>
                </div>
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
<div class="modal fade" id="addUsersiInTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
              <form action="{{ADMIN_SYSTEM_SITE_URL}}addUsersToTeams" method="POST">
                @csrf
        <input type="hidden" name="users[]" class="selected_users">
              <div class="cp-tags" id="cptag12">
                <ul>
                  <?php $i=1; $team_members = array(); ?>
                  
                </ul>
              </div>
              <div class="cp-list" id="cplist13">
                <ul>
                  <?php $i=1; ?>
                  @foreach($data['teams'] as $team)
                  <?php if(in_array($team->id, $team_members)){continue;} ?>
                    <li><input type="checkbox"  name="addmember[]" value="{{$team->id}}"/><img src="{{SYSTEM_SITE_URL}}public/team/{{$team->profile_picture}}"/><span>{{$team->team_name}}</span></li>
                  <?php $i++;?>
                  @endforeach
                </ul>
              </div>
              <div class="cp-btns">
                <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
                <button class="share green butn" type="submit" name="submit">Add Members</button> 
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
$(document).ready(function() {
	var selectedUsers = []
	$('.ceate_team_btn').on('click', function() {
		$("input[name='selectedUsers[]']:checked").each(function () {
			selectedUsers.push(parseInt($(this).val()));
		});
		$('.selected_users').val(selectedUsers);
		$('#addUsersiInTeam').modal('show');
	})
});

$(document).on("change", '.team_sorting', function(e) {
    var sorting_order = $(this).val();
    var search = $("input[name=ts]").val();
    window.location.href =  "setting?active=teams&team_sorting="+sorting_order+ "&ts=" + search+ "&team_search=search";
  });

  $(document).on("change", '.user_sorting', function(e) {
    var sorting_order = $(this).val();
    var search = $("input[name=us]").val();
    window.location.href =  "setting?active=users&user_sorting="+sorting_order+ "&us=" + search+ "&user_search=search";
  });

$(document).on("click", '.usermodal', function(e) {
        e.stopPropagation();
        var id = $(this).attr('data-id');
        var datatYpe = $(this).attr('data-type');
        var url1 = "{{SYSTEM_SITE_URL}}";
        $.ajax({
            type: "POST",
            url: "{{SYSTEM_SITE_URL}}ajax/getSharedUserDetails",
            data: {
                id: id,
                datatYpe: datatYpe,
                '_token': "{{csrf_token()}}"
            },
            success: function(data) {
                //data = JSON.parse(data);
                $("#folder-share-modal .modal-content").html(data.html);
                $("#folder-share-modal").modal('show');
            }
        });
    });
</script>
@endsection

</body>
</html>
