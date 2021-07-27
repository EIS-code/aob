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
        <div class="info-middle-content">
          <div class="tab-content">
            <div id="uploads">
              <div class="ttl">Recent Shared Files</div>
              <div class="upload-sc d-flex">
                <div class="upd-left">
                  <div class="up-header">
                    <label>Name</label>
                    <label>Members</label>
                    <label>Last Modified</label>
                    <label>&nbsp;</label>
                  </div>
                  <div class="up-content">
                    <ul>
                      <?php $i=1; ?>
                      @foreach($data['sharefile'] as $file)
                        <li>
                          <div class="up-col">
                            @if($file->ext=='pdf')
                             {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/>' !!}
                            @elseif($file->ext=='png')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/>' !!}
                            @elseif($file->ext=='txt')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/>' !!}
                            @elseif($file->ext=='doc')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/>' !!}
                            @else
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/>' !!}
                            @endif

                            <span>{{$file->name}}</span></div>
                          <div class="up-col">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($file->id); $share_teams = $share_model::getsharedteamsbyfile($file->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                            
                          </div>
                          <div class="up-col">{{date('F d, Y',strtotime($file->updated_at))}}</div>
                          <div class="up-col">
                            <div class="dots"> <a class="slide" href="javascript:void(0)">...</a>
                              <div class="slide-div">
                                <ul>
                                  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#share-modal" class="sharefile" data-id="{{$file->id}}" >Share to<small>›</small></a></li>
                                  <li><a href="{{ADMIN_SYSTEM_SITE_URL}}download/{{$file->id}}">Download</a></li>
                                  <li><a  href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefile/{{$file->id}}');">Delete</a></li>
                                  <li><a href="javascript:void(0)" class="usermodal" data-id="{{$file->id}}" data-type="file">View</a></li>
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
              <div class="ttl">Recent Shared Folder</div>
              <div class="upload-sc d-flex upload-fold-sec">
                <div class="upd-left">
                  <div class="up-header">
                    <label>Name</label>
                    <label>Members</label>
                    <label>Last Modified</label>
                    <label>&nbsp;</label>
                  </div>
                  <div class="up-content">
                    <ul>
                      <?php $i=1; ?>
                      @foreach($data['sharefolder'] as $file)
                        <li>
                          <div class="up-col">
                          {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/fold-open.png" alt=""/>' !!}
                            <span>{{$file->name}}</span></div>
                          <div class="up-col">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($file->id); $share_teams = $share_model::getsharedteamsbyfile($file->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                            
                          </div>
                          <div class="up-col">{{date('F d, Y',strtotime($file->updated_at))}}</div>
                          <div class="up-col">
                            <div class="dots"> <a class="slide" href="javascript:void(0)">...</a>
                              <div class="slide-div">
                                <ul>
                                  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#share-modal" class="sharefile" data-id="{{$file->id}}" >Share to<small>›</small></a></li>
                                  <li><a href="{{ADMIN_SYSTEM_SITE_URL}}folderdownload/{{$file->id}}">Download</a></li>
                                  <li><a  href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefolder/{{$file->id}}');">Delete</a></li>
                                  <li><a href="javascript:void(0)" class="usermodal" data-id="{{$file->id}}" data-type="folder">View</a></li>
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

@endsection

@section('js')
<script>
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