<section class="sidebar">
  <div class="left-section">
    <div class="logo"> <a href="javascript:void(0)"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/logo.png" alt=""/></a> </div>
    <div class="menu">
      <ul>
                      
        <li><a class="<?=($data['page']=='dashboard')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}" data-toggle="tooltip" title="Dashboard" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m1.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='folder')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}folder" data-toggle="tooltip" title="Folder"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m2.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='setting')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}setting?active=teams" data-toggle="tooltip" title="Tools"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m4.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='share')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}recentshare"data-toggle="tooltip" title="Shared"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m5.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='reports')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}report" data-toggle="tooltip" title="Reports"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m6.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='chats')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}chats" data-toggle="tooltip" title="Chats"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m7.png" alt=""/><span class="sp-count">({{$data1['unread_count']}})</span></a></li>
        <li><a class="<?=($data['page']=='questionnaire')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}questionnaire" data-toggle="tooltip" title="Questionnaire"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m2.png" alt=""/></a></li>
        <li><a class="<?=($data['page']=='hrfolder')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder" data-toggle="tooltip" title="Hrfolder"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/m2.png" alt=""/></a></li>
      </ul>
    </div>
    <div class="delete">
      <a class="<?=($data['page']=='trash')?'active':''?>" href="{{ADMIN_SYSTEM_SITE_URL}}trash" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i></a>
    </div>
  </div>
</section>