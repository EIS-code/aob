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
                    <?php $i = 1; ?>
                    @foreach($data['parentfolders1'] as $parentfolder)
                    <li><a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder/{{$parentfolder->id}}">{{$parentfolder->name}}</a></li>
                    <?php $i++; ?>
                    @endforeach
                </ul>
                <div class="fold-create">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#create-hr-folder">Create New</a> 
                </div>
            </div>
        </div>
    </section>
    <section class="right-side">
        <div class="right-tp-top d-flex">
            <div class="tp-left">
                <h2>AOB<span><img src="{{SYSTEM_SITE_URL}}assets/admin/images/edit.png" alt=""/></span></h2>
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
        @if ((!empty($data['parentfolders']) && count($data['parentfolders']) > 0) || (!empty($data['parentfiles']) && count($data['parentfiles']) > 0))
        <div class="right-content-sec">
            <div class="rt-top-sec">
                <div class="top-search">
                    <form action="" method="GET" >
                        <input type="text" name="s" placeholder="Search" value="<?= (isset($_GET['s'])) ? $_GET['s'] : '' ?>" />
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
                        <?php $i = 1; ?>
                        @foreach($data['parentfolders'] as $parentfolder)
                        <li class="fold-l">
                            <div class="l-dots">
                                <a class="slide" href="javascript:void(0)">...</a>
                                <div class="slide-div">
                                    <ul>
                                        <?php 
                                        if(!is_null($parentfolder->links->last())) {
                                        ?>
                                        <li><a href="javascript:void(0)" class="<?= $parentfolder->links->last()->is_expired == '1' ? 'getLink disabled' : 'getLink'?>" data-id="{{$parentfolder->id}}" data-type="folder" >Get link</a></li>
                                            <?php } else { ?>
                                        <li><a href="javascript:void(0)" class="getLink" data-id="{{$parentfolder->id}}" data-type="folder" >Get link</a></li>
                                            <?php } ?>
                                        <li><a href="javascript:void(0)" class="getNewLink" data-id="{{$parentfolder->id}}" data-type="folder">Create new link</li>
                                    </ul>
                                </div>
                            </div>
                            <a href="{{ADMIN_SYSTEM_SITE_URL}}hrfolder/{{$parentfolder->id}}">
                                <div class="fol-img"><img src="{{SYSTEM_SITE_URL}}assets/admin/images/fold-open.png" alt=""/></div>
                            </a>
                            <?php $file_model = app("App\\admin\\File");
                            $file_count = $file_model::getfilecountbyfolder($parentfolder->id); ?>
                            <div class="no-files">{{$parentfolder->files->count()}} folder</div>
                            <div class="list-name">{{$parentfolder->name}}</div>
                            <div class="members">Only you</div>
                            <div class="coaching">{{$parentfolder->name}}</div>
                            <div class="modified">
                                <?php if (is_null($parentfolder->updated_at)) { ?>
                                    -
                                <?php } else { ?>
                                    {{date('F d Y',strtotime($parentfolder->updated_at))}}
                                <?php } ?>
                            </div>
                        </li>
                        <?php $i++; ?>
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

@include('admin.layouts.modals')
@endsection
@section('js')
<script type="text/javascript">
    $(document).on("click", '.getLink', function (e) {
        e.stopPropagation();
        var id = $(this).attr('data-id');
        var datatYpe = $(this).attr('data-type');
        $.ajax({
            type: "POST",
            url: "{{SYSTEM_SITE_URL}}ajax/getLink",
            data: {
                id: id,
                datatYpe: datatYpe,
                '_token': "{{csrf_token()}}"
            },
            success: function (data) {
                $("#folder-link-modal .modal-content").html(data.html);
                $("#folder-link-modal").modal('show');
            }
        });
    });
    $(document).on("click", '.getNewLink', function (e) {
        e.stopPropagation();
        var id = $(this).attr('data-id');
        var datatYpe = $(this).attr('data-type');
        $.ajax({
            type: "POST",
            url: "{{SYSTEM_SITE_URL}}ajax/getNewLink",
            data: {
                id: id,
                datatYpe: datatYpe,
                '_token': "{{csrf_token()}}"
            },
            success: function (data) {
                $("#folder-link-modal .modal-content").html(data.html);
                $("#folder-link-modal").modal('show');
            }
        });
    });
</script>
@endsection

</body>
</html>
