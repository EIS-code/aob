@extends('admin.layouts.app')
@section('title','Team Member')

@section('css')
@endsection

@section('content')

<div class="dashboard-main">
  @include('admin.layouts.navbar')
  <section class="middle-section">
    <div class="middle">
      <div class="top-search">
        <input type="text" name="search" placeholder="Search"/>
        <button type="button" name="search-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
      </div>
      <div class="middle-content">
      	<div class="team-single">
        	<div class="team-box">
                <label>{{$data['team']->team_name}}</label>
                <ul class="prof">
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i1.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i2.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i3.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i4.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i5.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i3.png" alt=""></li>
                  <li><img src="{{SYSTEM_SITE_URL}}assets/admin/images/i4.png" alt=""></li>
                  <li>+4</li>
                </ul>
                <div class="team-bottom"> <span>175 Users</span> <span>3 Months</span> </div>
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
                      <li><a href="javascript:void(0)" data-toggle="modal" data-target="#shareadmin-modal">Share<small>›</small></a></li>
                      <li><a href="javascript:void(0)">Message</a></li>
                      <li><a href="javascript:void(0)">Details</a></li>
                      <li><a href="javascript:void(0)" data-toggle="modal" data-target="#moveto-modal">Move to<small>›</small></a></li>
                      <li><a href="javascript:void(0)">Remove</a></li>
                    </ul>
                  </div>
                </div>
                      <div class="user-place"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/u1.png" alt=""/></div>
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
              <form action="{{ADMIN_SYSTEM_SITE_URL}}addteamuser" method="POST">
                @csrf
              <input type="text" name="team123"  value="{{$data['team_id']}}">
              <input type="hidden" name="team_id"  value="{{$data['team_id']}}">
              <div class="cp-tags" id="cptag12">
                <ul>
                 
                </ul>
              </div>
              <div class="cp-list" id="cplist13">
                <ul>
                  <?php $i=1; ?>
                  @foreach($data['users'] as $user)
                    <li><input type="checkbox"  name="addmember[]" value="{{$user->id}}"/><img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}"/><span>{{$user->name}}</span></li>
                  <?php $i++;?>
                  @endforeach
                </ul>
              </div>
              <div class="cp-btns">
                <a href="javascript:void(0)" class="cancel pink butn">Cancel</a>
                <button class="share green butn" type="submit" name="submit">Share</button> 
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
@endsection

</body>
</html>
