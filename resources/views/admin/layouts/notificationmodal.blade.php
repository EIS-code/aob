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

<!-- Modal Settings -->
<div class="modal fade" id="setting-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">Settings
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="note-list">
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#profile-modal">Profile</a></li>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#changepassword-modal">Change Password</a></li>
          <li><a href="{{ADMIN_SYSTEM_SITE_URL}}logout">Logout</a></li>
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
                <input type="checkbox" name="reminder_email" value="1">
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