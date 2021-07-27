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
                <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder/details/{{$parentfolder['id']}}">{{$parentfolder['name']}}</a></li>
            <?php $i++;?>
            @endforeach
        </ul>
        
        </div>
      </div>
  </section>
  <section class="right-side">
    <div class="right-tp-top d-flex">
        <div class="tp-left">
            <h2><a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder">AOB</a>
            <ul>
                <li>
                @foreach($data['breadcrumps'] as $key => $breadcrump)
                    <a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder/{{$breadcrump->id}}"> {{$breadcrump->name}} </a>
                    <?php if($key <= count($data['breadcrumps'])-2){ echo " > "; } ?>
                @endforeach
                </li>
            </ul>
            <span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
            <small>Created: <span>{{date('d F Y',strtotime($data['folder']->created_at))}}</span> </small>
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
    @if(count($data['parentfolders'])>0)
    <div class="right-content-sec">
        <div class="rt-top-sec">
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
                        <a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder/details/{{$parentfolder['id']}}">
                           <div class="fol-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt=""/></div>
                        </a>
                        <div class="list-name">{{$parentfolder['name']}}</div>
                        <div class="members">Only you</div>
                        <div class="coaching">{{$parentfolder['name']}}</div>
                        <div class="modified">{{date('F d Y',strtotime($parentfolder['updated_at']))}}</div>
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
            </div>
        </div>
    </div>
    @endif
  </section>
</div>
@endsection
</body>
</html>
