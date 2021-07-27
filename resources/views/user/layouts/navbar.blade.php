<div class="dashboard-user-main">
  <div class="main-menu-mobile">
    <div id="mobile-navigation" class="show-for-small-only" style="display:none;">
      <div class="mobile-main-menu-wrapper">
        <div id="mobile-main-navigation" class="menu-menu-container">
          <ul class="menu">
            <li><a href="{{SYSTEM_SITE_URL}}"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/m1.png" alt="" /></span>Dashboard</a></li>
            <li><a href="{{SYSTEM_SITE_URL}}user/folder"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/m2.png" alt="" /></span>My Files</a></li>
            <li><a href="{{SYSTEM_SITE_URL}}user/fixfolders"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/m3.png" alt="" /></span>What's new!</a></li>
            <li><a href="{{SYSTEM_SITE_URL}}user/questionnaire/{{sp_decryption(session()->get('user_id'))}}"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/m4.png" alt="" /></span>Questionnaires</a></li>
            <li><a href="{{SYSTEM_SITE_URL}}user/reports"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/m5.png" alt="" /></span>Reports</a></li>
            <li><a href="{{SYSTEM_SITE_URL}}user/chats"><span><img src="{{SYSTEM_SITE_URL}}assets/user/images/chats.png" alt="" /></span>Chat <span class="sp-count">({{$data1['unread_count']}})</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="top-strip">
  	<div class="container">
    <div class="top-middle">
    	<div class="top-menu">
            <div id="nav-toggle" class="show-for-small-only"> <span class="menu-toggle"><span></span></span><h6>Menu</h6></div>
          </div>
          <div class="middle-logo">
          	<a href="javascript:void(0);" class="main-logo"><img src="{{SYSTEM_SITE_URL}}assets/user/images/main-logo.png" alt=""/></a>
          </div>
          <div class="top-right">
          	<div class="notify"> <a href="javascript:void(0)" data-toggle="modal" data-target="#notify-modal"><img src="{{SYSTEM_SITE_URL}}assets/user/images/bell.png" alt=""></a> </div>
            <div class="profile-main">
        <figure><a href="javascript:void(0)" data-toggle="modal" data-target="#profile-modal"><img src="{{SYSTEM_SITE_URL}}public/users/{{$data['user']->image}}" alt=""></a></figure>
      </div>
      <div class="settings"> <a href="javascript:void(0)" data-toggle="modal" data-target="#setting-modal"><img src="{{SYSTEM_SITE_URL}}assets/user/images/settings.png" alt=""></a> </div>
          </div>
          </div>
    </div>
</div>