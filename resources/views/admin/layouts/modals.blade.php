<!-- Modal Notify -->
<div class="modal fade" id="notify-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">Notifications
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <?php $day12=''; ?>
          @foreach($data['recentnotifications'] as $recentnotification)
          
          <?php if(date('Y-m-d')==date('Y-m-d',strtotime($recentnotification->created_at))){
            $new_day = 'Today';
            if($day12!=$new_day){
              echo "<li><strong>".$new_day."</strong></li>";
              $day12 = $new_day;
            }
          }elseif (date('Y-m-d',strtotime('-1 days'))==date('Y-m-d',strtotime($recentnotification->created_at))) {
            $new_day = 'Yesterday';
            if($day12!=$new_day){
              echo "<li><strong>".$new_day."</strong></li>";
              $day12 = $new_day;
            }
          }else{
            $new_day = date('D d, F Y',strtotime($recentnotification->created_at));
            if($day12!=$new_day){
              echo "<li><strong>".$new_day."</strong></li>";
              $day12 = $new_day;
            }
          } ?>
          <li>
            <img src="{{SYSTEM_SITE_URL}}assets/admin/images/i2.png" alt=""/> {{$recentnotification->title}}
            <span>
              <?php
                if($new_day=='Today'){
                $time2 = date('Y-m-d h:i:s');
                $time1 = strtotime($recentnotification->created_at);
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
                }else{
                  echo date('h:i',strtotime($recentnotification->created_at));
                }
                ?>
            </span>
          </li>
          @endforeach
        </ul>
        <div class="text-center all"><a href="{{ADMIN_SYSTEM_SITE_URL}}notifications">View All</a></div>
      </div>
    </div>
  </div>
</div>

<!-- Folder Create -->
<div class="modal fade" id="create-folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">Create New Folder
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdatefolder" method="POST" >
            <div class="form-group">
              @csrf
              <input type="text" class="form-control" name="name" id="foldername">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Add Folder" name="submit" id="submit1">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Hr Folder Create -->
<div class="modal fade" id="create-hr-folder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">Create New Folder
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <form action="{{ADMIN_SYSTEM_SITE_URL}}addfolder" method="POST" >
            <div class="form-group">
              @csrf
              <input type="text" class="form-control" name="name" id="foldername">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Add Folder" name="submit" id="submit1">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- File Create -->
<div class="modal fade" id="createfile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Create File
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="file-upld fileupload-buttonbar">
          
            <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdatefile" enctype="multipart/form-data" method="POST" id="crtfile" >
              @csrf
              <span class="btn btn-success fileinput-button"><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/file-upload.png" alt=""/><span>Upload File</span></span>
              <input type="file" name="fileToUpload" id="fileToUpload" class="myfile">
              </span>
              <input type="submit" value="Submit" name="submit" id="sube">
            </form>
            
        </div>
      </div>
      <div id="pageloader">
   <img src="{{SYSTEM_SITE_URL}}assets/admin/images/loading.gif" alt="processing..." />
</div>
    </div>
  </div>
</div>

<!-- Report Create -->
<div class="modal fade" id="createreport-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Upload Report
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="file-upld fileupload-buttonbar">
            
              <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdatereport" enctype="multipart/form-data" method="POST" >
                @csrf
                <span class="btn btn-success fileinput-button"><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/file-upload.png" alt=""/><span>Upload Report</span></span>
                <input type="file" class="myfile" name="fileToUpload" id="fileToUpload">
                </span>
                <input type="submit" value="Submit" name="submit">
              </form>
          </div>
      </div>
    </div>
  </div>
</div>
<!-- Fix File Create -->
<div class="modal fade" id="createfixfile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Upload File
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="file-upld fileupload-buttonbar">
              <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdatefixfile" enctype="multipart/form-data" method="POST" >
                @csrf
                <span class="btn btn-success fileinput-button"><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/file-upload.png" alt=""/><span>Upload File</span></span>
                <input type="file" name="fileToUpload" id="fileToUpload" class="myfile">
                </span>
                <input type="submit" value="Submit" name="submit">
              </form>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- NEW TEAM CREATE -->
<div class="modal fade" id="crt-team-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line"><strong>Create Team</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="crt-team-box">
          <form action="{{ADMIN_SYSTEM_SITE_URL}}addteamwithuser" enctype="multipart/form-data" method="POST">
            <div class="tm-top">
              <label>Team Name</label>
                <input type="text" name="team_name" placeholder="Write team name here" required />
            </div>
            <div class="team-tabing">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="Commentary">
                  <div class="tm-group">
                    <label>Upload Picture</label>
                      <div class="fileupload-buttonbar"> 
                        <span class="btn btn-success fileinput-button">
                          <input type="file" name="fileToUpload" class="myfile upld">
                        </span> 
                      </div>
                    </div>
                    <div class="cp-label">Add user to team</div>
                      @csrf
                      <div class="cp-search">
                        <input type="text" name="search" placeholder="Search"/>
                        <button class="cs-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                      </div>
                      <div class="cp-tags">
                        <ul>
                        </ul>
                      </div>
                      <div class="cp-list">
                        <ul>
                          <?php $i=1; ?>
                          @foreach($data['users'] as $user)
                            <li><input type="checkbox" name="useradd[]" onclick='deRequireCb("acb")'  class="acb" required value="{{$user->id}}"/><img src="{{SYSTEM_SITE_URL}}public/users/{{$user->image}}"/><span>{{$user->name}}</span></li>
                          <?php $i++;?>
                          @endforeach
                        </ul>
                      </div>
                </div>
              </div>
            </div>
            <div class="cp-btns"> 
              <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
              <button class="share green butn" type="submit" name="submit" value="submit">Create Team</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- DELETE LINK modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line"><strong>Delete</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="crt-team-box">
            <div class="tm-top">
              <label>Sure, Do you want to delete?</label>
            </div>
            <div class="cp-btns"> 
              <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
              <a href="#" id="deletelink" class="share green butn">Yes</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="restore-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line"><strong>Restore</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="crt-team-box">
            <div class="tm-top">
              <label>Sure, Do you want to restore?</label>
            </div>
            <div class="cp-btns"> 
              <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
              <a href="#" id="restorelink" class="share green butn">Yes</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="remove-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line"><strong>Remove</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="crt-team-box">
            <div class="tm-top">
              <label>Sure, Do you want to remove?</label>
            </div>
            <div class="cp-btns"> 
              <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
              <a href="#" id="removelink" class="share green butn">Yes</a>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Team Create -->
<div class="modal fade" id="addteammodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">Create New Team
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdateteam" method="POST" >
            <div class="form-group">
              @csrf
              <input type="text" class="form-control" name="name" id="teamname">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Add Team" name="submit" id="submit2">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- User Create -->
<div class="modal fade" id="addusermodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">Create New User
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <form action="{{ADMIN_SYSTEM_SITE_URL}}addupdateuser" method="POST" >
            <div class="form-group">
              @csrf
              <label>Username</label>
              <input type="text" class="form-control" name="name" id="user_name" required >
            </div>
            <div class="form-group">
            <label>Email</label>
              <input type="email" class="form-control" name="email" id="user_email" required >
            </div>
            <div class="form-group">
            <label>Mobile</label>
              <input type="text" class="form-control" name="mobile" id="user_mobile" required >
            </div>
            <div class="form-group">
            <label>Password</label>
              <input type="password" class="form-control" name="password" id="user_password" required >
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Add User" name="submit" id="submit3">
            </div>
          </form>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal Settings -->
<div class="modal fade" id="setting-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">Settings
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <li class="prof"><a href="javascript:void(0)" data-toggle="modal" data-target="#profile-modal">Profile</a></li>
          <li class="cp"><a href="javascript:void(0)" data-toggle="modal" data-target="#changepassword-modal">Change Password</a></li>
          <li class="logout"><a href="{{ADMIN_SYSTEM_SITE_URL}}logout">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal Share -->
<div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="share-header">
          <label>Share file to</label>
          <div class="share-tab">
            <ul class="nav nav-tabs">
              <li><a class="active" href="#team-tabs" data-toggle="tab">Team</a></li>
              <li><a href="#user-tabs" data-toggle="tab">User</a></li>
            </ul>
          </div>
        </div>
        <div class="mode-content">
          <div class="tab-content">
            <div class="tab-pane active" id="team-tabs">
              <div class="cp-label">Find team by name</div>
              <div class="cp-search">
                <input type="text" name="search" placeholder="Search" id="myInput" onkeyup="myFunction()"/>
                <button class="cs-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
              </div>
              <form action="{{ADMIN_SYSTEM_SITE_URL}}sharewithteam" method="POST">
                @csrf
                <input type="hidden" name="type" id="team_share_type">
                <input type="hidden" name="shared_id" id="team_shared_id">
              <div class="cp-tags" id="cptag1">
                <table id="myTable1" class="cp-tags-table">
 
                </table>
                
              </div>
              <div class="cp-list" id="cplist1">
                <table id="myTable" class="cp-list-table">
                  <?php $i=1; ?>
                  @foreach($data['teams'] as $team)
                  <tr>
                    <td>
                      <?php if( file_exists(public_path('/team/'.$team->profile_picture))){
                        $image_file = SYSTEM_SITE_URL.'public/team/'.$team->profile_picture;
                      }else{
                        $image_file = SYSTEM_SITE_URL.'public/users/user.png'; 
                      }  ?>
                      <input type="checkbox" name="teamshare[]" value="{{$team->id}}"/><img src="{{$image_file}}"/><span>{{$team->team_name}}</span>
                    </td>
                  </tr>
                  <?php $i++;?>
                  @endforeach
                </table>
              </div>
              <div class="row">
                  	<div class="col-sm-6">
                    <label>Activation Date</label>
                  <input type="text" name="activation_date" placeholder="Activation Date" class="activation_date" value="{{\Carbon\Carbon::now()->format('m/d/Y')}}"/>
                </div>
                <div class="col-sm-6">
                <label>Expiration Date</label>
                  <input type="text" name="expiration_date" placeholder="Expiration Date" class="expiration_date" value="{{\Carbon\Carbon::now()->addYears(1)->format('m/d/Y')}}"/>
                </div>
              </div>
              <div class="cp-btns">
                <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
                <button class="share green butn" type="submit" name="submit" value="submit">Share</button> 
              </div>
              </form>
            </div>
            <div class="tab-pane" id="user-tabs">
              <div class="cp-label">Find User by name</div>
              <div class="cp-search">
                <input type="text" name="search" placeholder="Search" id="myInput2" onkeyup="myFunction2()"/>
                <button class="cs-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
              </div>
              <form action="{{ADMIN_SYSTEM_SITE_URL}}sharewithuser" method="POST">
                @csrf
                <input type="hidden" name="type" id="user_share_type">
                <input type="hidden" name="shared_id" id="user_shared_id">
                <div class="cp-tags">
                  <table id="myTable12" class="cp-tags-table">
                  </table>
                </div>
                <div class="cp-list">
                  <table id="myTable2" class="cp-list-table">
                    <?php $i=1; ?>
                    @foreach($data['users'] as $user)
                    <tr>
                      <td>
                        <?php if( file_exists(public_path('/users/'.$user->image))){
                          $image_file = SYSTEM_SITE_URL.'public/users/'.$user->image;
                        }else{
                          $image_file = SYSTEM_SITE_URL.'public/users/user.png'; 
                        }  ?>
                        <input type="checkbox" name="usershare[]" value="{{$user->id}}"/><img src="{{$image_file}}"/><span>{{$user->name}}</span>
                      </td>
                    </tr>
                    <?php $i++;?>
                    @endforeach
                  </table>
                </div>
                <div class="row">
                  	<div class="col-sm-6">
                    <label>Activation Date</label>
                    <input type="text" name="activation_date" placeholder="Activation Date" class="activation_date" value="{{\Carbon\Carbon::now()->format('m/d/Y')}}"/>
                  </div>
                  <div class="col-sm-6">
                  <label>Expiration Date</label>
                    <input type="text" name="expiration_date" placeholder="Expiration Date" class="expiration_date" value="{{\Carbon\Carbon::now()->addYears(1)->format('m/d/Y')}}"/>
                  </div>
                </div>
                <div class="cp-btns"> 
                  <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
                  <button class="share green butn" type="submit" name="submit" value="submit">Share</button> 
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal move -->
<div class="modal fade" id="move-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="share-header">
          <label>Move Folder or File</label>
        </div>
        <div class="mode-content">
          <div class="tab-content">
            <div class="tab-pane active" id="team">
              <div class="cp-label">Find folder by name</div>
              <div class="cp-search">
                <input type="text" name="search" placeholder="Search" id="myInput3" onkeyup="myFunction3()"/>
                <button class="cs-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
              </div>
              
              <form action="{{ADMIN_SYSTEM_SITE_URL}}movefolder" method="POST" >
              @csrf
              <input type="hidden" name="move_folder_id" id="move_folder_id">
              <input type="hidden" name="move_file" id="move_file" value="0">
              <div class="cp-files mobile-menu">
                  <div id="megaMenu">
                      <ul id="megaUber">
                        <table id="myTable3" class="cp-list-table">
                        <tr>
                              <td>
                              <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="-1" name="move" /><strong>..</strong><a></a>
                              </td>
                            </tr>
                          <?php $i=1; ?>
                          @foreach($data['movefolders'] as $movefolder)
                            <tr>
                              <td>
                              <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="{{$movefolder->folderid}}" onclick="openSubFolder('{{$movefolder->folderid}}')" name="move" /><strong>{{$movefolder->name}}</strong><a></a>
                                <ul id="subfolder_{{$movefolder->folderid}}">
                                    
                                </ul>
                              </td>
                            </tr>
                          <?php $i++;?>
                          @endforeach
                        </table>
                      </ul>
                  </div>
              </div>
              <div class="cp-btns"> 
                <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a> 
                <input type="submit" name="movefolder" class="share green butn" value="Move">
              </div>
              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal move -->
<div class="modal fade" id="copy-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="share-header">
          <label>Copy Folder or File</label>
        </div>
        <div class="mode-content">
          <div class="tab-content">
            <div class="tab-pane active" id="team">
              <div class="cp-label">Find folder by name</div>
              <div class="cp-search">
                <input type="text" name="search" placeholder="Search" id="myInput4" onkeyup="myFunction4()"/>
                <button class="cs-btn"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
              </div>
              
              <form action="{{ADMIN_SYSTEM_SITE_URL}}copyfolder" method="POST" >
              @csrf
              <input type="hidden" name="copy_folder_id" id="copy_folder_id">
              <input type="hidden" name="copy_file" id="copy_file" value="0">
              <div class="cp-files mobile-menu">
                  <div id="megaMenu">
                      <ul id="megaUber">
                        <table id="myTable4" class="cp-list-table">
                        <tr>
                              <td>
                              <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="-1" name="copy" /><strong>..</strong><a></a>
                              </td>
                            </tr>
                        <?php $i=1; ?>
                        @foreach($data['movefolders'] as $movefolder)
                          <tr>
                            <td>
                            <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="{{$movefolder->folderid}}" onclick="openCopySubFolder('{{$movefolder->folderid}}')" name="copy" /><strong>{{$movefolder->name}}</strong><a></a>
                              <ul id="copysubfolder_{{$movefolder->folderid}}">
                                  
                              </ul>
                            </td>
                          </tr>
                        <?php $i++;?>
                        @endforeach
                        </table>
                      </ul>
                  </div>
              </div>
              <div class="cp-btns"> 
                <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a> 
                <input type="submit" name="movefolder" class="share green butn" value="Copy">
              </div>
              
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal profile -->
<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Profile
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{ADMIN_SYSTEM_SITE_URL}}updateprofile" method="POST" enctype="multipart/form-data" >
          @csrf
          <input type="hidden" name="image_file" value="{{$data['admin']->image}}">
          <div class="profile-top">
            <div class="profile-pict">
              <div class="circle"> 
                <img class="profile-pic" src="{{SYSTEM_SITE_URL}}public/users/{{$data['admin']->image}}"> 
                <?php $string = explode(' ',$data['admin']->name); ?>
              </div>
              <div class="p-image"> <span class="upload-button">Upload Photo</span>
                <input class="file-upload" name="fileToUpload" type="file" accept="image/*"/>
              </div>
            </div>
          </div>
          <div class="profile-middle">
            <div class="pro-grp">
              <label>First Name</label>
              <input type="text" name="fname" placeholder="First Name" value="{{$string[0]}}" />
            </div>
            <div class="pro-grp">
              <label>Last Name</label>
              <input type="text" name="lname" placeholder="Last Name" value="{{$string[1]}}"/>
            </div>
            <div class="pro-grp">
              <label>Date of Birth</label>
              <input type="text" name="dob" placeholder="DD/MM/YYYY" value="{{$data['admin']->dob}}"/>
            </div>
            <div class="pro-grp">
              <label>Initials</label>
              <input type="text" name="initials" placeholder="Initials" value="{{$data['admin']->initials}}"/>
            </div>
            <div class="pro-grp">
              <label>Job Position</label>
              <input type="text" name="position" placeholder="Job Position" value="{{$data['admin']->position}}"/>
            </div>
            <!-- <div class="pro-grp last">
              <label class="switch">
                <input type="checkbox" name="reminder_email" value="1" <?//=($data['admin']->reminder_email=='1')?'checked':''?> >
                <span class="slider"></span> <span>Reminder emails</span> </label>
            </div> -->
            <div class="pro-buttons d-flex justify-content-center">
              <a href="#" class="butn pink" data-dismiss="modal">Cancel</a>
              <input type="submit" name="submit" value="Save" class="butn orange">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- User Modal profile -->
<div class="modal fade" id="user-profile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">User Profile
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          
              </div>
            </div>
          </div>          
            </div>
            </div>
              
            <!-- Folder Shared Details !-->
<div class="modal fade" id="folder-share-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="folder-link-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- Modal profile -->
<div class="modal fade" id="changepassword-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Change Password
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{ADMIN_SYSTEM_SITE_URL}}updatepassword" method="POST" >
          @csrf
          <div class="profile-middle">
            <div class="pro-grp">
              <label>Current Password</label>
              <input type="password" name="cpassword" placeholder="Enter Current Password" />
            </div>
            <div class="pro-grp">
              <label>New Password</label>
              <input type="password" name="npassword" placeholder="Enter New Password" />
            </div>
            <div class="pro-grp">
              <label>Re-Enter New Password</label>
              <input type="password" name="rnpassword" placeholder="Re-Enter new Password" />
            </div>
            <div class="pro-buttons d-flex justify-content-center">
              <a href="#" class="butn pink" data-dismiss="modal">Cancel</a>
              <input type="submit" name="submit" value="Save" class="butn orange">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Questionnaire File Create -->
<div class="modal fade" id="questionnairefile-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line txt-center">Upload File
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="file-upld fileupload-buttonbar">
              <form action="{{ADMIN_SYSTEM_SITE_URL}}add-questionnaire-file" enctype="multipart/form-data" method="POST" >
                @csrf
                <span class="btn btn-success fileinput-button"><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/file-upload.png" alt=""/><span>Upload File</span></span>
                <input type="file" name="fileToUpload" id="fileToUpload" class="myfile">
                </span>
                <input type="submit" value="Submit" name="submit">
              </form>
          </div>
      </div>
    </div>
  </div>
</div>

<!-- Edit Activation Deactivation -->
<div class="modal fade" id="edit-modal-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
    <div class="modal-header">Edit Date
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div class="cont-in">
      <form action="#" id="updatelink" method="POST" >
                @csrf
                
            	<div class="otp-grp"><label>Activation Date</label><input type="text" name="act-date" id="act-date" /></div>
              
              <div class="otp-grp"><label>Expiration Date</label><input type="text" name="exp-date" id="exp-date" /></div>
            </div>
            <div class="cp-btns"> 
              <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a>
              <input type="submit" value="Update" name="Update">
            </div>
            </form>
            </div>
      </div>
    </div>
  </div>
</div>