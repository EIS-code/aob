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
                <input type="text" name="search" placeholder="Find Document" value="<?= (isset($_GET['search'])) ? $_GET['search'] : '' ?>">
                <button type="button" name="search-btn"><img src="images/search.png" alt=""></button>
                @csrf
            </form>
        </div>
        <div class="top-right">
            <div id="btngridcontain" class="grid-sec">
                <label>View:</label>
                <button class="btn-list btn-set"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/grid.png"><img class="act" src="{{SYSTEM_SITE_URL}}assets/admin/images/grid-active.png"></button>
                <button class="btn-grid btn-set active"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/list.png"><img class="act" src="{{SYSTEM_SITE_URL}}assets/admin/images/list-active.png"></button>
            </div>
        </div>
    </div>
    <div class="folder-dash">
        <div class="grid-container">
            <div class="list-top">
                <label>Name</label>
                <label>Last Modified</label>
            </div>
            <ul class="fold-view">
                <?php $i = 1; ?>
                @foreach($data['parentfolders'] as $parentfolder)
                <li class="fold-l">
                    <div class="l-dots"><a class="slide" href="javascript:void(0)">...</a>
                        <div class="slide-div">
                            <ul>
                                <li><a href="{{SYSTEM_SITE_URL}}user/folderdownload/{{$parentfolder->id}}">Download<small>›</small></a></li>
                            </ul>
                        </div>
                    </div>
                    <a href="{{SYSTEM_SITE_URL}}user/folder/{{$parentfolder->id}}">
                        <div class="fol-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt="" /></div>
                    </a>
                    <?php $file_model = app("App\\admin\\File");
                    $file_count = $file_model::getfilecountbyfolder($parentfolder->id); ?>
                    <div class="no-files">{{$file_count}} files</div>
                    <div class="list-name">{{$parentfolder->name}}</div>
                    <div class="coaching">{{$parentfolder->name}}</div>
                    <div class="modified">{{date('F d Y',strtotime($parentfolder->updated_at))}}</div>
                </li>
                <?php $i++; ?>
                @endforeach
                @foreach($data['parentfiles'] as $parentfile)
                <li>
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
                    <div class="list-name">{{$parentfile->name}}</div>
                    <div class="coaching">{{$parentfile->name}}</div>
                    <div class="modified">{{date('F d Y',strtotime($parentfile->created_at))}}</div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
<div class="chat-pop">
    <div class="ctah-in"><a href="chats.html"><img src="images/chats.png" alt="" /></a></div>
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