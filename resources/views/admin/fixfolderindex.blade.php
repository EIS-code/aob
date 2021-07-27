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
            @foreach($data['parentfolders'] as $parentfolder)
                <li><a href="{{ADMIN_SYSTEM_SITE_URL}}fixfolder/{{$parentfolder->id}}">{{$parentfolder->name}}</a></li>
            <?php $i++;?>
            @endforeach
        </ul>
        <div class="fold-btm">
            <h5><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g1.png">Folder</h5>
            <ul>
                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createfixfile-modal" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g2.png" alt=""/>Video</a></li>
                <li><a href="javascript:void(0)" data-toggle="modal" data-target="#createfixfile-modal" ><img src="{{SYSTEM_SITE_URL}}assets/admin/images/g3.png" alt=""/>File</a></li>
            </ul>
            <div class="fold-create">
        </div>
        </div>
        
        </div>
      </div>
  </section>
  <section class="right-side">
    <div class="right-tp-top d-flex">
        <div class="tp-left">
            <h2>What's New
            <ul>
                <li>{{$data['fixfolder']->name}}</li>
            </ul>
            <span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
            <small>Created: <span>{{date('d F Y',strtotime($data['fixfolder']->created_at))}}</span> </small>
        </div>
        <div class="tp-right">
            <div class="dp-top">
               
            </div>
            <div class="dp-bottom">
                
            </div>
        </div>
    </div>
    @if(count($data['parentfiles'])>0)
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
                    @foreach($data['parentfiles'] as $parentfile)
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}downloadfixfile/{{$parentfile->id}}">Download</a></li>
                                    <li><a href="javascript:void(0)" class="movefixfilemodal" data-id="{{$parentfile->id}}"  data-toggle="modal" data-target="#fixmove-modal">Move to<small>›</small></a></li>
                                    <li><a href="javascript:void(0)" class="copyfixfilemodal" data-id="{{$parentfile->id}}" data-toggle="modal" data-target="#fixcopy-modal" >Copy</a></li>
                                    <li><a href="void:javascript(0)" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefixfile/{{$parentfile->id}}');">Delete</a></li>
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
                        <div class="modified">{{date('F d Y',strtotime($parentfile->updated_at))}}</div>
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
                <div class="fileupload-buttonbar" data-toggle="modal" data-target="#createfixfile-modal"> 
                    <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""/></span></span> 
                </div>
            </div>
        </div>
    </div>
    @endif
  </section>
</div>

@include('admin.layouts.modals')

<!-- Modal move -->
<div class="modal fade" id="fixmove-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <div class="tab-pane active" id="fixteam">
              <form action="{{ADMIN_SYSTEM_SITE_URL}}movefixfile" method="POST" >
              @csrf
              <input type="hidden" name="move_folder_id" id="move_fixfolder_id">
              <input type="hidden" name="move_file" id="move_fix_file" value="0">
              <div class="cp-files mobile-menu">
                  <div id="megaMenu">
                      <ul id="megaUber">
                        <?php $i=1; ?>
                        @foreach($data['parentfolders'] as $movefolder)
                          <li>
                            <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="{{$movefolder->id}}" name="move" /><strong>{{$movefolder->name}}</strong>
                          </li>
                        <?php $i++;?>
                        @endforeach
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
<div class="modal fade" id="fixcopy-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
              <form action="{{ADMIN_SYSTEM_SITE_URL}}copyfixfile" method="POST" >
              @csrf
              <input type="hidden" name="copy_folder_id" id="copy_fix_folder_id">
              <input type="hidden" name="copy_file" id="copy_fix_file" value="0">
              <div class="cp-files mobile-menu">
                  <div id="megaMenu">
                      <ul id="megaUber">
                        <?php $i=1; ?>
                        @foreach($data['parentfolders'] as $movefolder)
                          <li>
                            <a href="#"><span class="open-click"><i class="fas fa-chevron-right"></i><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/></span></a><input type="radio" value="{{$movefolder->id}}" name="copy" /><strong>{{$movefolder->name}}</strong>
                          </li>
                        <?php $i++;?>
                        @endforeach
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
@endsection

@section('js')

@endsection

</body>
</html>
