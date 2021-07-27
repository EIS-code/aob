@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection

@section('content')

@include('user.layouts.navbar')

<div class="container">

  <div class="top-sec">
    <div class="top-search">
      <form action="" method="GET">
        <input type="text" name="search" placeholder="Search" value="<?= (isset($_GET['search'])) ? $_GET['search'] : '' ?>">
        <button type="button" name="search-btn"><img src="{{SYSTEM_SITE_URL}}assets/user/images/search.png" alt=""></button>
        @csrf
      </form>
    </div>

  </div>
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
  <h3 class="title">Recent Folders</h3>
  <div class="folder-list">
    <?php $i = 1; ?>
    @foreach($data['parentfolders'] as $parentfolder)
    <div class="folder">
      <div class="l-dots"><a class="slide" href="javascript:void(0)">...</a>
        <div class="slide-div">
          <ul>
          <li><a href="{{SYSTEM_SITE_URL}}user/folderdownload/{{$parentfolder->id}}">Download<small>›</small></a></li>
          </ul>
        </div>
      </div>
      <a href="{{SYSTEM_SITE_URL}}user/folder/{{$parentfolder->id}}">
      <div class="fold-img"><img src="{{SYSTEM_SITE_URL}}assets/user/images/fold-open.png" alt="" /></div>
      </a>
      <h4>{{$parentfolder->name}}</h4>
      <?php $file_model = app("App\\admin\\File");
      $file_count = $file_model::getfilecountbyfolder($parentfolder->id); ?>
      <span>{{$file_count}} files</span>
    </div>
    <?php $i++; ?>
    @endforeach
  </div>
  <h3 class="title sec-ttl">Recent Files</h3>
  <div class="file-list-sec">
  <?php $i = 1; ?>
  @foreach($data['parentfiles'] as $parentfile)
  	<div class="folder">
    <div class="l-dots"><a class="slide" href="javascript:void(0)">...</a>
    <div class="slide-div">
                      <ul>
                      <li><a href="{{SYSTEM_SITE_URL}}user/download/{{$parentfile->id}}">Download<small>›</small></a></li>
                      </ul>
                    </div>
                    </div>
                    @if($parentfile->ext=='pdf')
      {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt="" /></div>' !!}
      @elseif($parentfile->ext=='png' || $parentfile->ext=='jpg' || $parentfile->ext=='jpeg')
      {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt="" /></div>' !!}
      @elseif($parentfile->ext=='txt')
      {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/txt.png" alt="" /></div>' !!}
      @elseif($parentfile->ext=='doc')
      {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt="" /></div>' !!}
      @else
      {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/relplay.png" alt="" /></div>' !!}
      @endif
      <h4>{{$parentfile->name}}</h4>
  </div>
  <?php $i++; ?>
    @endforeach
  </div>
</div>
<div class="chat-pop">
<div class="ctah-in"><a href="{{SYSTEM_SITE_URL}}user/chats"><img src="{{SYSTEM_SITE_URL}}assets/user/images/chats.png" alt="" /></a></div>
</div>
</div>
@include('user.layouts.modals')
@endsection

@section('js')
<script type="text/javascript">
  function openSubFolder(folderid) {
    $.ajax({
      type: "POST",
      url: "{{SYSTEM_SITE_URL}}ajax/getSubFolder",
      data: {
        folderid: folderid,
        '_token': "{{csrf_token()}}"
      },
      // dataType:"JSON",
      success: function(data) {
        data = JSON.parse(data);
        // console.log(data);
        if (parseInt(data.code) == 0) {} else {
          $("#subfolder_" + folderid).html(data.html);
        }
      }
    });
  }

  function openCopySubFolder(folderid) {
    $.ajax({
      type: "POST",
      url: "{{SYSTEM_SITE_URL}}ajax/getSubFolder",
      data: {
        folderid: folderid,
        '_token': "{{csrf_token()}}"
      },
      // dataType:"JSON",
      success: function(data) {
        data = JSON.parse(data);
        // console.log(data);
        if (parseInt(data.code) == 0) {} else {
          $("#copysubfolder_" + folderid).html(data.html);
        }
      }
    });
  }
</script>
@endsection

</body>

</html>