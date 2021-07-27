@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection

@section('content')

@include('user.layouts.navbar')
  <section class="right-side">
    @if(!empty($folder) && count($folder->Files) > 0)
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
            <div class="fileupload-buttonbar" data-toggle="modal" data-target="#questionnairefile-modal"> 
                <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""/></span></span> 
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
                <!-- <label>Members</label> -->
                <label>Last Modified</label>
            </div>
            <div class="que-box d-flex">
                <div class="que-inner">
                    <h3>Users Questions</h3>
                    <ul class="fold-view">
                        @if(!empty($folder) && !empty($folder->Files))
                        @foreach($folder->Files as $file)
                        @if($file->uploadedUser->role_id == 2)
                        <li>
                            <div class="l-dots">
                                <a class="slide" href="javascript:void(0)">...</a>
                                <div class="slide-div">
                                    <ul>
                                        <li><a href="{{SYSTEM_SITE_URL}}user/questionnaire/file/download/{{$file->id}}">Download</a></li>
                                        <li><a href="#"  onclick="deleteak('{{SYSTEM_SITE_URL}}user/questionnaire/file/delete/{{$file->id}}');" >Delete</a></li>
                                    </ul>
                                </div>
                            </div>

                            @if($file->ext=='pdf')
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                            @elseif($file->ext=='png' || $file->ext=='jpg' || $file->ext=='jpeg')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                            @elseif($file->ext=='txt')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/></div>' !!}
                            @elseif($file->ext=='doc')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                            @else
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/></div>' !!}
                            @endif
                            <div class="list-name">{{$file->name}}</div>
                            <!-- <div class="members">
                                <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($file->id); $share_teams = $share_model::getsharedteamsbyfile($file->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                                                     
                            </div> -->
                            <div class="coaching">{{$file->name}}</div>
                            <div class="modified">{{date('F d Y',strtotime($file->created_at))}}</div>
                        </li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="que-inner">
                    <h3>Admin Questions</h3>
                    <ul class="fold-view">
                        @if(!empty($folder) && !empty($folder->Files))
                        @foreach($folder->Files as $file)
                        @if($file->uploadedUser->role_id == 1)
                        <li>
                            <div class="l-dots">
                                <a class="slide" href="javascript:void(0)">...</a>
                                <div class="slide-div">
                                    <ul>
                                        <li><a href="{{SYSTEM_SITE_URL}}user/questionnaire/file/download/{{$file->id}}">Download</a></li>
                                        <li><a href="#"  onclick="deleteak('{{SYSTEM_SITE_URL}}user/questionnaire/file/delete/{{$file->id}}');" >Delete</a></li>
                                    </ul>
                                </div>
                            </div>

                            @if($file->ext=='pdf')
                            {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                            @elseif($file->ext=='png' || $file->ext=='jpg' || $file->ext=='jpeg')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                            @elseif($file->ext=='txt')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/></div>' !!}
                            @elseif($file->ext=='doc')
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                            @else
                                {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/></div>' !!}
                            @endif
                            <div class="list-name">{{$file->name}}</div>
                            <!-- <div class="members">
                                <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($file->id); $share_teams = $share_model::getsharedteamsbyfile($file->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                                                     
                            </div> -->
                            <div class="coaching">{{$file->name}}</div>
                            <div class="modified">{{date('F d Y',strtotime($file->created_at))}}</div>
                        </li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
              </div>
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
                <div class="fileupload-buttonbar" data-toggle="modal" data-target="#questionnairefile-modal"> 
                    <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""/></span></span> 
                </div>
            </div>
        </div>
        <div class="container">
        <div class="que-fold">
            <div class="foldview-top">
            	<h3>Users Questions</h3>
                <h3>Admin Questions</h3>
            </div>
              	<ul class="fold-view">
                                                                                                                    </ul>
                <ul class="fold-view">
                                                                                <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="http://phpstack-529148-1805466.cloudwaysapps.com/admin/questionnaire/file/download/2">Download</a></li>
                                    <li><a href="#" onclick="deleteak('http://phpstack-529148-1805466.cloudwaysapps.com/admin/questionnaire/file/delete/2');">Delete</a></li>
                                </ul>
                            </div>
                        </div>

                                                    <div class="fol-img"><img src="http://phpstack-529148-1805466.cloudwaysapps.com/assets/admin/images/img.png" alt=""></div>
                                                <div class="list-name">akararnamu</div>
                        <!-- <div class="members">
                            Only You                                                     
                        </div> -->
                        <div class="coaching">akararnamu</div>
                        <div class="modified">April 17 2021</div>
                    </li>
                                                                            </ul>
                </div>
                </div>
    </div>
    @endif
  </section>
</div>

@include('user.layouts.modals')

@endsection

@section('js')
<script>
    function deleteak(link){
        $("#deletelink").attr('href',link);
        $("#delete-modal").modal('show');
    }
</script>


@endsection

</body>
</html>
