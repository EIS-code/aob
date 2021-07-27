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
            <h2>AOB
            <ul>
                <li>{{$data['folder']->name}} > {{$data['subfolder']}}</li>
            </ul>
            <span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
            <small>Created: <span>{{date('d F Y',strtotime($data['folder']->created_at))}}</span> </small>
        </div>
        <div class="tp-right">
            <div class="dp-top">
               
            </div>
            <div class="dp-bottom">
                
            </div>
        </div>
    </div>
    @if(isset($data['file']))
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
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'document'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">document.pdf</div>
                        <div class="members">Only You</div>
                        <div class="coaching">document.pdf</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'iban'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->iban_proof}}</div>
                        <div class="members">Only You</div>
                        <div class="coaching">{{$data['file']->iban_proof}}</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'card'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->card_proof}}</div>
                        <div class="members">Only You</div>
                        <div class="coaching">{{$data['file']->card_proof}}</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'residence'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        @if($data['file']->residence_proof_ext == 'png' || 'jpeg' || 'jpg')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->residence_proof}}</div>
                        @elseif($data['file']->residence_proof_ext == 'doc' || 'docx')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->residence_proof}}</div>
                        @elseif($data['file']->residence_proof_ext == 'pdf')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->residence_proof}}</div>
                        @endif
                        <div class="members">Only You</div>
                        <div class="coaching">{{$data['file']->residence_proof}}</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'educational'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        @if($data['file']->educational_proof_ext == 'png' || 'jpeg' || 'jpg')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->educational_proof}}</div>
                        @elseif($data['file']->educational_proof_ext == 'doc' || 'docx')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->educational_proof}}</div>
                        @elseif($data['file']->educational_proof_ext == 'pdf')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->educational_proof}}</div>
                        @endif
                        <div class="members">Only You</div>
                        <div class="coaching">{{$data['file']->educational_proof}}</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
                    <li>
                        <div class="l-dots">
                            <a class="slide" href="javascript:void(0)">...</a>
                            <div class="slide-div">
                                <ul>
                                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hr/file/download/{{$data['file']->id}}/{{'local'}}">Download</a></li>
                                </ul>
                            </div>
                        </div>
                        @if($data['file']->local_proof_ext == 'png' || 'jpeg' || 'jpg')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/img.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->local_proof}}</div>
                        @elseif($data['file']->local_proof_ext == 'doc' || 'docx')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/doc.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->local_proof}}</div>
                        @elseif($data['file']->local_proof_ext == 'pdf')
                        {!! '<div class="fol-img"><img src="'.SYSTEM_SITE_URL.'assets/admin/images/pdf.png" alt=""/></div>' !!}
                        <div class="list-name">{{$data['file']->local_proof}}</div>
                        @endif
                        <div class="members">Only You</div>
                        <div class="coaching">{{$data['file']->local_proof}}</div>
                        <div class="modified">{{date('F d Y',strtotime($data['file']->updated_at))}}</div>
                    </li>
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

@endsection

@section('js')

@endsection

</body>
</html>
