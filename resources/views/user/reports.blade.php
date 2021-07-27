@extends('user.layouts.app')

@section('title','Dashboard')

@section('css')

@endsection

@section('content')

@include('user.layouts.navbar')
<div class="container">
    <div class="folder-dash">
    <h3 class="title">Reports</h3>
    	<div class="grid-container">
            <div class="list-top">
            </div>
              	<ul class="fold-view reports-list">
                <?php $i=1;
                ?>
                      @foreach($data['reports'] as $report)
                    <li>
                    <div class="l-dots"><a class="slide" href="javascript:void(0)">...</a><div class="slide-div">
                      <ul>
                        <li><a href="{{SYSTEM_SITE_URL}}user/download/{{$report->id}}">Download<small>›</small></a></li>
                      </ul>
                    </div></div>
                    
                    	<div class="fol-img">
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

                      </div>
                        <div class="list-name">{{$report->name}}</div>
                        <div class="coaching">{{$report->name}}</div>
                        <div class="modified">{{date('F d, Y',strtotime($report->updated_at))}}</div>
                    </li>
                    <?php $i++;?>
                      @endforeach
                </ul>
              </div>
    </div>
    
</div>
<div class="chat-pop">
	<div class="ctah-in"><a href="chats.html"><img src="images/chats.png" alt=""/></a></div>
</div>
</div>
@include('user.layouts.modals')

@endsection

@section('js')

@endsection

</body>
</html>