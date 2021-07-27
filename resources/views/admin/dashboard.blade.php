@extends('admin.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection

@section('content')

<div class="dashboard-main">
  @include('admin.layouts.navbar')
  <section class="middle-section">
    <div class="middle">
      <div class="top-search">
        <form action="" method="GET" >
          <input type="text" name="s" placeholder="Search" value="<?=(isset($_GET['s']))?$_GET['s']:''?>" />
          <button type="submit" value="search" name="search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
          @csrf
        </form>
      </div>
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
        @endif
        <div class="dash-top d-flex justify-content-between">
            <div class="top-box active" onclick="location.href='{{ADMIN_SYSTEM_SITE_URL}}fixfolder/2'">
              <div class="tp-top"> <span class="bx-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/new.png" alt=""/></span><span>...</span> </div>
              <h4>What's new!</h4>
              <div class="tp-bottom"> <span class="files">{{$data['fixfilecount']}} files</span>
              </div>
            </div>
          <?php $i=1; ?>
          @foreach($data['recentfolders'] as $recentfolder)
            <div class="top-box" onclick="location.href='{{ADMIN_SYSTEM_SITE_URL}}folder/{{$recentfolder->id}}'">
              <div class="tp-top"> <span class="bx-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon1.png" alt=""/></span><span>...</span> </div>
              <h4>{{$recentfolder->name}}</h4>
              <div class="tp-bottom"> <span class="files">{{$recentfolder->nooffiles}} files</span>
                <ul class="prof">
                <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberes($recentfolder->id);  ?>
                  <?php $j=1; ?>
                  @foreach($share_members as $share_member)
                    <li><img src="{{SYSTEM_SITE_URL}}public/users/{{$share_member->image}}" alt=""></li>
                  <?php if($j==3){break;} $j++;?>
                  @endforeach
                  @if(count($share_members)>$j)
                  <li>+{{count($share_members)-$j}}</li>
                  @endif
                </ul>
              </div>
            </div>
          <?php $i++;?>
          @endforeach
        </div>
        <div class="dash-middle">
          <div class="mid-box">
            <div class="d-flex ttl-top justify-content-between">
              <h4>Featured</h4>
            </div>
            <div class="dash-lined">
              <?php $i=1; ?>
                @foreach($data['fixfolders'] as $folder)
                  <div class="dash-fold">
                    <div class="dash-left" onclick="location.href='{{ADMIN_SYSTEM_SITE_URL}}fixfolder/{{$folder->id}}'">
                      <div class="name">{{$folder->name}}</div>
                      <?php $file_model = app("App\\admin\\File"); $fixfile_count = $file_model::getfixfilecountbyfolder($folder->id);  ?>
                      <div class="fl-list">{{$fixfile_count}} files</div>
                    </div>
                    <div class="dash-right">
                      <div class="dots"><a class="slide" href="javascript:void(0)"><!-- ... --></a>
                        <div class="slide-div">
                          <ul>
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#move-modal" class="movemodal" data-id="{{$folder->id}}">Move to<small>&rsaquo;</small></a></li>
                            <li><a href="javascript:void(0)" class="copymodal" data-id="{{$folder->id}}" data-toggle="modal" data-target="#copy-modal">Copy</a></li>
                            <li><a onclick="return confirm('Sure, Do you want to delete?');" href="{{ADMIN_SYSTEM_SITE_URL}}folder/deletefolder/{{$folder->id}}">Delete</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php $i++;?>
                @endforeach
            </div>
          </div>
          <div class="mid-box">
            <div class="d-flex ttl-top justify-content-between">
              <h4>Folders</h4>
              <a href="{{ADMIN_SYSTEM_SITE_URL}}folder">View All</a></div>
                <div class="dash-lined">
                <?php $i=1; ?>
                @foreach($data['folders'] as $folder)
                  <div class="dash-fold">
                    <div class="dash-left" onclick="location.href='{{ADMIN_SYSTEM_SITE_URL}}folder/{{$folder->id}}'">
                      <div class="name">{{$folder->name}}</div>
                      <?php $file_model = app("App\\admin\\File"); $file_count = $file_model::getfilecountbyfolder($folder->id);  ?>
                      <div class="fl-list">{{$file_count}} files</div>
                    </div>
                    <div class="dash-right">
                      <div class="dots"><a class="slide" href="javascript:void(0)">...</a>
                        <div class="slide-div">
                          <ul>
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#share-modal" class="sharefolder" data-id="{{$folder->id}}">Share to<small>&rsaquo;</small></a></li>
                            <li><a href="javascript:void(0)" data-toggle="modal" data-target="#move-modal" class="movemodal" data-id="{{$folder->id}}">Move to<small>&rsaquo;</small></a></li>
                            <li><a href="javascript:void(0)" class="copymodal" data-id="{{$folder->id}}" data-toggle="modal" data-target="#copy-modal">Copy</a></li>
                            <li><a onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefolder/{{$folder->id}}');" href="void:javascript(0)">Delete</a></li>
                          </ul>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                <?php $i++;?>
                @endforeach
                </div>
          </div>
          <div class="mid-box">
            <div class="d-flex ttl-top justify-content-between">
              <h4>Users</h4>
              <a href="{{ADMIN_SYSTEM_SITE_URL}}setting?active=users">View All</a></div>
            <div class="user-lists">
              <ul>
                <?php $i=1; ?>
                @if(count($data['users'])>0)
                @foreach($data['users'] as $user)
                <li>
                  <div class="use-img"><img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}" alt=""/></div>
                  <label>{{$user->name}}</label>
                </li>
                <?php $i++;?>
                @endforeach
                @else
                <div class="user-lists">
                  <div class="create-usr">
                    <a href="#">
                      <span>+</span>Create User
                    </a>
                  </div>
                </div>
                @endif
              </ul>
            </div>
          </div>
          <div class="mid-box">
            <div class="d-flex ttl-top justify-content-between">
              <h4>Teams</h4>
              <a href="{{ADMIN_SYSTEM_SITE_URL}}setting?active=teams">View All</a></div>
            <div class="team-list">
              <?php $i=1; ?>
              @if(count($data['teams'])>0)
              @foreach($data['teams'] as $team)
              <?php $model = app("App\\admin\\Team"); $team_members = $model::getMembersByTeam($team->id);  ?>
                <div class="team-box">
                  <label>{{$team->team_name}}</label>
                  <ul class="prof">
                    <?php $j=1; ?>
                    @foreach($team_members as $team_member)
                      <li><img src="{{SYSTEM_SITE_URL}}public/users/{{$team_member->image}}" alt=""></li>
                    <?php if($j==7){break;} $j++;?>
                    @endforeach
                    @if(count($team_members)>$j)
                    <li>+{{count($team_members)-$j}}</li>
                    @endif
                  </ul>
                  <div class="team-bottom"> <span>{{count($team_members)}} Users</span> </div>
                </div>
              <?php if($i==4){break;} $i++;?>
              @endforeach
              @else
              <div class="user-lists">
                <div class="create-usr">
                  <a href="#" data-toggle="modal" data-target="#crt-team-modal">
                    <span>+</span>Create Teams
                  </a>
                </div>
              </div>
              @endif
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
    function openSubFolder(folderid) {
        $.ajax({
            type: "POST",
            url:"{{SYSTEM_SITE_URL}}ajax/getSubFolder",
            data:{folderid:folderid, '_token':"{{csrf_token()}}"},
            success: function(data) {
                data = JSON.parse(data);
                if(parseInt(data.code)==0){
                }else{
                    $("#subfolder_"+folderid).html(data.html);
                }
            }
        });
    }
    function openCopySubFolder(folderid) {
        $.ajax({
            type: "POST",
            url:"{{SYSTEM_SITE_URL}}ajax/getSubFolder",
            data:{folderid:folderid, '_token':"{{csrf_token()}}"},
            success: function(data) {
                data = JSON.parse(data);
                if(parseInt(data.code)==0){
                }else{
                    $("#copysubfolder_"+folderid).html(data.html);
                }
            }
        });
    }
</script>
@endsection
</body>
</html>
