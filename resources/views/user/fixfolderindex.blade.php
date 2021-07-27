@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection
@section('content')

@include('user.layouts.navbar')
<div class="container">
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
                                    <!-- <li><a href="javascript:void(0)" class="sharefile" data-toggle="modal" data-target="#share-modal" data-id="{{$parentfile->id}}">Share to<small>›</small></a></li> -->
                                    <li><a href="{{SYSTEM_SITE_URL}}user/downloadfixfile/{{$parentfile->id}}">Download</a></li>
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
                        <!-- <div class="no-files">3 files</div> -->
                        <div class="list-name">{{$parentfile->name}}</div>
                        <div class="members">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($parentfile->id); if(count($share_members)>0){ echo count($share_members).' Members'; }else{echo "Only You";}//echo "<pre>"; print_r($share_members); die(); ?>
                          <!-- <ul class="prof">
                                
                                <?php if(count($share_members)>0){ //echo "string"; die(); ?>
                                    <?php $j=1; ?>
                                    @foreach($share_members as $share_member)
                                    <li><img src="{{SYSTEM_SITE_URL}}public/users/{{$share_member->image}}" alt=""></li>
                                    <?php if($j==3){break;} $j++;?>
                                    @endforeach
                                    @if(count($share_members)>$j)
                                    <li>+{{count($share_members)-$j}}</li>
                                    @endif
                                <?php }else{ ?>
                                    <li>Only You</li>
                                <?php } ?>
                            </ul> -->
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
    
    @endif
  </section>
</div>
</div>

@include('user.layouts.modals')

@endsection

@section('js')

@endsection

</body>

</html>
