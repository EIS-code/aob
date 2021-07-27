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
          <!-- <li><strong>Today</strong></li> -->
          <li>
            <img src="{{SYSTEM_SITE_URL}}assets/admin/images/i2.png" alt=""/> {{$recentnotification->title}}
            <span>
              <?php
                if($new_day=='Today'){
                $time2 = date('Y-m-d h:i:s');
                $time1 = strtotime($recentnotification->created_at);
                $time2 = strtotime($time2);
                $difference = ($time2 - $time1);
                // echo "<pre>"; print(arg)_r($difference); die();
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
        <div class="text-center all"><a href="{{SYSTEM_SITE_URL}}user/notifications">View All</a></div>
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
          <li class="logout"><a href="{{SYSTEM_SITE_URL}}logout">Logout</a></li>
        </ul>
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
        <form action="{{SYSTEM_SITE_URL}}user/updateprofile" method="POST" enctype="multipart/form-data" >
          @csrf
          <input type="hidden" name="image_file" value="{{$data['user']->image}}">
          <div class="profile-top">
            <div class="profile-pict">
              <div class="circle"> 
                <!-- User Profile Image --> 
                <img class="profile-pic" src="{{SYSTEM_SITE_URL}}public/users/{{$data['user']->image}}"> 
                <?php $string = explode(' ',$data['user']->name); ?>
                <!-- Default Image --> 
                <!-- <i class="fa fa-user fa-5x"></i> --> 
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
              <input type="text" name="lname" placeholder="Last Name" value="{{isset($string[1]) ? $string[1] : ''}}"/>
            </div>
            <div class="pro-grp">
              <label>Date of Birth</label>
              <input type="text" name="dob" placeholder="DD/MM/YYYY" value="{{$data['user']->dob}}"/>
            </div>
            <div class="pro-grp">
              <label>Initials</label>
              <input type="text" name="initials" placeholder="Initials" value="{{$data['user']->initials}}"/>
            </div>
            <div class="pro-grp">
              <label>Job Position</label>
              <input type="text" name="position" placeholder="Job Position" value="{{$data['user']->position}}"/>
            </div>
            <!-- <div class="pro-grp pref">
              <label>Preferred Video Quality</label>
              <input type="text" name="pvq" placeholder="Default"/>
            </div> -->
            <!-- <div class="pro-grp last">
              <label class="switch">
                <input type="checkbox" name="reminder_email" value="<?php //if($data['user']->reminder_email == 1) echo '1'; else echo '0';?>" <?php //if($data['user']->reminder_email == 1) echo 'checked="checked"';?>>
                <span class="slider"></span> <span>Reminder emails</span> </label>
            </div> -->
            <div class="pro-buttons d-flex justify-content-center">
              <a href="#" class="butn pink" data-dismiss="modal">Cancel</a>
              <input type="submit" name="submit" value="Save" class="butn orange">
              <!-- <a href="#" class="butn orange">Save</a> -->
            </div>
          </div>
        </form>
      </div>
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
        <form action="{{SYSTEM_SITE_URL}}user/updatepassword" method="POST" >
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
              <!-- <a href="#" class="butn orange">Save</a> -->
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
              <form action="{{SYSTEM_SITE_URL}}user/add-questionnaire-file" enctype="multipart/form-data" method="POST" >
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