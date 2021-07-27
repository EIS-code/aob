@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection
@section('content')

@include('user.layouts.navbar')

<div class="container">
    <div class="folder-list whatsnew">
       @foreach($data['fixfolders'] as $folder)
    	<div class="folder" onclick="location.href='{{SYSTEM_SITE_URL}}user/fixfolder/{{$folder->id}}'"><div class="fold-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt=""/></div><h4>{{$folder->name}}</h4>
      <?php $file_model = app("App\\admin\\File"); $fixfile_count = $file_model::getfixfilecountbyfolder($folder->id); //echo "<pre>"; print_r($share_members); die(); ?>
      <span>{{$fixfile_count}} files</span></div>
      @endforeach
    </div>
</div>
<div class="chat-pop">
	<div class="ctah-in"><a href="chats.html"><img src="images/chats.png" alt=""/></a></div>
</div>

@include('user.layouts.modals')

@endsection

@section('js')

@endsection

</body>

</html>