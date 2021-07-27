@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection
@section('content')

@include('user.layouts.navbar')

<div class="container">
    <h3 class="title">Questionnaires</h3>
    <div class="whatsnew-inner">
            	<img src="{{SYSTEM_SITE_URL}}assets/admin/images/whatnew.png">
                <strong>No content created!</strong>
                <h6>Create new</h6>
                <div class="fileupload-buttonbar" data-toggle="modal" data-target="#fileup-modal"> 
                        <!-- The fileinput-button span is used to style the file input field as button --> 
                        <span class="btn btn-success fileinput-button"><span>Upload</span><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/icon-upload.png" alt=""></span>
                        </span> </div>
            </div>
    
</div>
<div class="chat-pop">
	<div class="ctah-in"><a href="chats.html"><img src="images/chats.png" alt=""/></a></div>
</div>
<div class="modal fade" id="fileup-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header no-line"><strong>Upload</strong>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      	<div class="up-data-inner">
        	<div class="fileupload-buttonbar"> 
                        <!-- The fileinput-button span is used to style the file input field as button --> 
                        <span class="btn btn-success fileinput-button"><span class="img-up"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/file-upload.png" alt=""/><span>Select files to upload or drag drop anywhere on this page</span></span>
                        <input type="file" class="myfile" name="files[]" multiple />
                        </span> </div>
            <div class="cp-btns"> <a href="javascript:void(0)" class="cancel pink butn" data-dismiss="modal">Cancel</a> <a href="javascript:void(0)" class="share green grey butn">Done</a> </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('user.layouts.modals')

@endsection

@section('js')

@endsection

</body>

</html>