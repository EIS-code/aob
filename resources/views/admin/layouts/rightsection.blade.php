<section class="right-section">
    <div class="right-top">
      <div class="notify"> <a href="javascript:void(0)" data-toggle="modal" data-target="#notify-modal"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/bell.png" alt=""/></a> </div>
      <div class="profile-main">
        <figure><a href="javascript:void(0)" data-toggle="modal" data-target="#profile-modal"><img src="{{SYSTEM_SITE_URL}}public/users/{{$data['admin']->image}}" alt=""/></a></figure>
      </div>
      <div class="settings"> <a href="javascript:void(0)" data-toggle="modal" data-target="#setting-modal"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/settings.png" alt=""/></a> </div>
    </div>
    <div class="right-middle">
      <ul class="list-flex">
        <li>
          <figure><img src="{{SYSTEM_SITE_URL}}assets/admin/images/pict.png" alt=""/>Images</figure>
          <span>{{$data['imagefile']}} files</span></li>
        <li>
          <figure><img src="{{SYSTEM_SITE_URL}}assets/admin/images/notes.png" alt=""/>Documents</figure>
          <span>{{$data['documentfile']}} files</span></li>
        <li>
          <figure><img src="{{SYSTEM_SITE_URL}}assets/admin/images/play.png" alt=""/>Media Files</figure>
          <span>{{$data['mediafile']}} files</span></li>
        <li>
          <figure><img src="{{SYSTEM_SITE_URL}}assets/admin/images/note-minus.png" alt=""/>Other Files</figure>
          <span>{{$data['otherfile']}} files</span></li>
      </ul>
    </div>
    <div class="right-bottom"> <img src="{{SYSTEM_SITE_URL}}assets/admin/images/download-icons8.png" alt=""/> </div>
