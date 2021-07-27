@extends('admin.layouts.app')
@section('title','Folder Grid')

@section('css')
@endsection

@section('content')

<div class="dashboard-main folder-grd">
  @include('admin.layouts.navbar')
  <section class="right-side">
  	<div class="right-tp-top d-flex">
    	<div class="tp-left">
            <h2><a href="{{ADMIN_SYSTEM_SITE_URL}}questionnaire">Questionnaire</a><span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
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
    @if(count($folders)>0)
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
                <label>Last Modified</label>
            </div>
              	<ul class="fold-view">
                    <?php $i=1; ?>
                    @foreach($folders as $folder)
                	<li class="fold-l">
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}questionnaire/folder/download/{{$folder->id}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{ADMIN_SYSTEM_SITE_URL}}questionnaire/{{$folder->id}}">
                    	   <div class="fol-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt=""/></div>
                        </a>
                        <?php $file_model = app("App\\admin\\File"); $file_count = count($folder->Files);  ?>
                        <div class="no-files">{{$file_count}} files</div>
                        <div class="list-name">{{$folder->name}}</div>
                        <div class="coaching">{{$folder->name}}</div>
                        <div class="modified">{{date('F d Y',strtotime($folder->updated_at))}}</div>
                    </li>
                    <?php $i++;?>
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
                <!-- <h6>Create new</h6> -->
                <div class="fileupload-buttonbar" data-toggle="modal" data-target="#createfile-modal"> 
                    <!-- <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""/></span></span>  -->
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
</script>
@endsection

</body>
</html>
