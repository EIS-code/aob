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
              <div class="upload-sc d-flex">
                <div class="trash-left">
                  <div class="up-header">
                    <label>Name</label>
                    <label>Members</label>
                    <label>Last Modified</label>
                    <label>&nbsp;</label>
                  </div>
                  <div class="up-content">
                    <ul>
                      <?php $i=1; ?>
                      @foreach($data['deletedfile'] as $file)
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
                                  <li><a href="javascript:void(0);" onclick="restoreak('{{ADMIN_SYSTEM_SITE_URL}}trash/restorefile/{{$file->id}}');">Restore</a></li>
                                  <li><a href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}trash/deletefile/{{$file->id}}');">Delete</a></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </li>
                      <?php $i++;?>
                      @endforeach
                      <?php $i=1; ?>
                      @foreach($data['deletedfixfile'] as $file)
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
                                  <li><a href="javascript:void(0);" onclick="restoreak('{{ADMIN_SYSTEM_SITE_URL}}trash/restorefixfile/{{$file->id}}">Restore</a></li>
                                  <li><a  href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}trash/deletefixfile/{{$file->id}}');" >Delete</a></li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </li>
                      <?php $i++;?>
                      @endforeach
                      <?php $i=1; ?>
                      @foreach($data['deletedfolder'] as $folder)
                        <li>
                          <div class="up-col">
                            <img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold.png" alt=""/>
                            <span>{{$folder->name}}</span></div>
                          <div class="up-col">
                            <?php $share_model = app("App\\admin\\Share"); $share_members = $share_model::getsharedmemberes($folder->id); $share_teams = $share_model::getsharedteamsbyfolder($folder->id); if(count($share_members)>0 && count($share_teams)>0){ echo count($share_members).' Members and '.count($share_teams).' teams'; }elseif(count($share_members)>0){ echo count($share_members).' Members'; }elseif(count($share_teams)>0){ echo count($share_teams).' Teams'; } else{echo "Only You";}?>                                                     
                          </div>
                          <div class="up-col">{{date('F d, Y',strtotime($folder->updated_at))}}</div>
                          <div class="up-col">
                            <div class="dots"> <a class="slide" href="javascript:void(0)">...</a>
                              <div class="slide-div">
                                <ul>
                                  <li><a href="javascript:void(0);" onclick="restoreak('{{ADMIN_SYSTEM_SITE_URL}}trash/restorefolder/{{$folder->id}}');">Restore</a></li>
                                  <li><a href="javascript:void(0);" onclick="deleteak('{{ADMIN_SYSTEM_SITE_URL}}trash/deletefolder/{{$folder->id}}');">Delete</a></li>
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
  </section>
  @include('admin.layouts.rightsection')
</div>
@include('admin.layouts.notificationmodal')

@endsection

@section('js')

@endsection

</body>
</html>