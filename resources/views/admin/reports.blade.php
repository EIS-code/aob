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
        <div class="top-upload">
        	<a href="javascript:void(0)" data-toggle="modal" data-target="#createreport-modal">Upload New</a>
        </div>
        <div class="info-middle-content">
          <div class="tab-content">
            <div id="uploads">
              <div class="ttl">Reports</div>
              <div class="upload-sc d-flex">
                <div class="upd-left">
                  <div class="up-header">
                    <label>File name</label>
                    <label>Members</label>
                    <label>Last Modified</label>
                    <label>&nbsp;</label>
                  </div>
                  <div class="up-content">
                    <ul>
                      <?php $i=1; ?>
                      @foreach($data['reports'] as $report)
                        <li>
                          <div class="up-col">
                            @if($report->ext=='pdf')
                             {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/>' !!}
                            @elseif($report->ext=='png')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/>' !!}
                            @elseif($report->ext=='txt')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt=""/>' !!}
                            @elseif($report->ext=='doc')
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/>' !!}
                            @else
                                {!! '<img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt=""/>' !!}
                            @endif

                            <span>{{$report->name}}</span></div>
                          <div class="up-col">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberesbyfile($report->id); $share_teams = $share_model::getsharedteamsbyfile($report->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>
                          </div>
                          <div class="up-col">{{date('F d, Y',strtotime($report->updated_at))}}</div>
                          <div class="up-col">
                            <div class="dots"> <a class="slide" href="javascript:void(0)">...</a>
                              <div class="slide-div">
                                <ul>
                                  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#share-modal" class="sharefile" data-id="{{$report->id}}" >Share to<small>›</small></a></li>
                                  <li><a href="{{ADMIN_SYSTEM_SITE_URL}}download/{{$report->id}}">Download</a></li>
                                  <li><a href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}folder/deletefile/{{$report->id}}');">Delete</a></li>
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

@endsection

</body>
</html>