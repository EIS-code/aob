@extends('admin.layouts.app')
@section('title','Folder Grid')

@section('css')
@endsection

@section('content')

<div class="dashboard-main folder-grd">
  @include('admin.layouts.navbar')
  <section class="left-side">
      <div class="folder">
      	<div class="fold-up"><h4>Folders</h4><span>+</span></div>
        <div class="fold-flex">
        <ul class="fold-icons">
            <?php $i=1; ?>
            @foreach($data['parentfolders1'] as $parentfolder)
            	<li><a href="{{ADMIN_SYSTEM_SITE_URL}}folder/{{$parentfolder->id}}">{{$parentfolder->name}}</a></li>
            <?php $i++;?>
            @endforeach
        </ul>
        <div class="fold-btm">
        	<h5><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g1.png">Folder</h5>
            <ul>
            	<li><a href="javascript:void(0)" data-toggle="modal" data-target="#createfile-modal" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g2.png" alt=""/>Video</a></li>
                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createfile-modal" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g3.png" alt=""/>File</a></li>
            </ul>
            <div class="fold-create">
        	<a href="javascript:void(0)" data-toggle="modal" data-target="#create-folder">Create New</a> 
        </div>
        </div>
        
        </div>
      </div>
  </section>
  <section class="right-side">
  	<div class="right-tp-top d-flex">
    	<div class="tp-left">
        	<h2>AOB<span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
        </div>
        <div class="tp-right">
        	<div class="dp-top">
            	<ul class="prof">
                	
                </ul>
            </div>
            <div class="dp-bottom">
            </div>
        </div>
    </div>
    @if(count($data['parentfolders'])>0 || count($data['parentfiles'])>0 )
    <div class="right-content-sec">
    	<div class="rt-top-sec">
        	<div class="top-search">
                <form action="" method="GET" >
                  <input type="text" name="s" placeholder="Search" value="<?=(isset($_GET['s']))?$_GET['s']:''?>" />
                  <button type="submit" value="search" name="search"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/search.png" alt=""/></button>
                  @csrf
                </form>
              </div>
              <div id="btngridcontain" class="grid-sec">
              	<label>View:</label>
  				<button class="btn-list btn-set"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/grid.png"/><img class="act" src="{{SYSTEM_SITE_URL}}assets/admin/images/grid-active.png"/></button>	
                <button class="btn-grid btn-set active"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/list.png"/><img class="act" src="{{SYSTEM_SITE_URL}}assets/admin/images/list-active.png"/></button>
              </div>  
        </div>
        <div class="right-mid-section">
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
        	<div class="grid-container">
            <div class="list-top">
            	<label>Name</label>
                <label>Members</label>
                <label>Last Modified</label>
            </div>
              	<ul class="fold-view">
                    <?php $i=1; ?>
                    @foreach($data['parentfolders'] as $parentfolder)
                	<li class="fold-l">
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="javascript:void(0)" class="sharefolder" data-toggle="modal" data-id="{{$parentfolder->id}}" data-target="#share-modal">Share to<small>›</small></a></li>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}folderdownload/{{$parentfolder->id}}">Download</a></li>
                                    <li><a href="javascript:void(0)" class="movemodal" data-id="{{$parentfolder->id}}" data-toggle="modal" data-target="#move-modal">Move to<small>›</small></a></li>
                                    <li><a href="javascript:void(0)" class="copymodal" data-id="{{$parentfolder->id}}" data-toggle="modal" data-target="#copy-modal">Copy</a></li>
                                    <li><a href="void:javascript(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefolder/{{$parentfolder->id}}');">Delete</a></li>
                                    <li><a href="javascript:void(0)" class="usermodal" data-id="{{$parentfolder->id}}" data-type="folder">View</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ADMIN_SYSTEM_SITE_URL}}folder/{{$parentfolder->id}}">
                    	   <div class="fol-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt=""/></div>
                        </a>
                        <?php $file_model = app("App\\admin\\File"); $file_count = $file_model::getfilecountbyfolder($parentfolder->id);  ?>
                        <div class="no-files">{{$file_count}} files</div>
                        <div class="list-name">{{$parentfolder->name}}</div>
                        <div class="members">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberes($parentfolder->id); $share_teams = $share_model::getsharedteamsbyfolder($parentfolder->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                                                     
                            
                        </div>
                        <div class="coaching">{{$parentfolder->name}}</div>
                        <div class="modified">{{date('F d Y',strtotime($parentfolder->updated_at))}}</div>
                    </li>
                    <?php $i++;?>
                    @endforeach
                    @foreach($data['parentfiles'] as $parentfile)
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="javascript:void(0)" class="sharefile" data-toggle="modal" data-target="#share-modal" data-id="{{$parentfile->id}}">Share to<small>›</small></a></li>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}download/{{$parentfile->id}}">Download</a></li>
                                    <li><a href="javascript:void(0)" class="movefilemodal" data-id="{{$parentfile->id}}"  data-toggle="modal" data-target="#move-modal">Move to<small>›</small></a></li>
                                    <li><a href="javascript:void(0)" class="copyfilemodal" data-id="{{$parentfile->id}}" data-toggle="modal" data-target="#copy-modal" >Copy</a></li>
                                    <li><a href="#"  onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefile/{{$parentfile->id}}');" >Delete</a></li>
                                    <li><a href="javascript:void(0)" class="usermodal" data-id="{{$parentfile->id}}" data-type="file">View</a></li>
                                </ul>
                            </div>
                        </div>

                        @if($parentfile->ext=='pdf')
                    	   {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        @elseif($parentfile->ext=='png' || $parentfile->ext=='jpg' || $parentfile->ext=='jpeg')
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                        @elseif($parentfile->ext=='txt')
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/></div>' !!}
                        @elseif($parentfile->ext=='doc')
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                        @else
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/></div>' !!}
                        @endif
                        <div class="list-name">{{$parentfile->name}}</div>
                        <div class="members">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($parentfile->id); $share_teams = $share_model::getsharedteamsbyfile($parentfile->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                                                     
                        </div>
                        <div class="coaching">{{$parentfile->name}}</div>
                        <div class="modified">{{date('F d Y',strtotime($parentfile->created_at))}}</div>
                    </li>
                    @endforeach
                </ul>
              </div>
        </div>
    </div>
    @else
    <div class="right-content-sec">
        <div class="whatsnew-sec">
            <div class="whatsnew-inner">
                <img src="{{SYSTEM_SITE_URL}}assets/admin/images/whatnew.png"/>
                <strong>No content created!</strong>
                <h6>Create new</h6>
                <div class="fileupload-buttonbar" data-toggle="modal" data-target="#createfile-modal"> 
                    <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""/></span></span> 
                </div>
            </div>
        </div>
    </div>
    @endif
  </section>
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
            url:"{{SYSTEM_SITE_URL}}ajax/getCopySubFolder",
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
