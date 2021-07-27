@csrf
<input type="hidden" name="image_file">
<div class="profile-top">
  <div class="profile-pict">
    <div class="circle">
      <?php if (file_exists(public_path('/users/' . $data['user']->image))) {
        $image_file = SYSTEM_SITE_URL . 'public/users/' . $data['user']->image;
      } else {
        $image_file = SYSTEM_SITE_URL . 'public/users/user.png';
      }  ?>
      <img id="user_profile_pic" src="{{$image_file}}">
    </div>
  </div>
</div>
<div class="profile-middle">
  <div class="pro-grp">
    <label>Name</label>
    <input type="text" name="fname" id="user_fname1" placeholder="First Name" readonly="readonly" value="{{$data['user']->name}}" />
  </div>
  <div class="pro-grp">
    <label>Email</label>
    <input type="text" id="user_email1" readonly="readonly" value="{{$data['user']->email}}" />
  </div>
  <div class=" pro-grp">
    <label>Mobile</label>
    <input type="text" name="dob" id="user_phone1" readonly="readonly" value="{{$data['user']->phone}}"/>
  </div>
  <div class=" pro-grp last">
  </div>
  <table id="myTable2" class="">
    <tbody>
      <tr>
        <td class="shared-title">
          Shared Files
        </td>
        <td class="shared-activation">
          Activation Date
        </td>
        <td class="shared-expiration">
          Expiration Date
        </td>
        <td class="shared-expiration">
          Actions
        </td>
      </tr>
      @if(empty($data['sharedFiles']))
      <tr>
        <td>
          No files Found
        </td>
      </tr>
      @else
      @foreach($data['sharedFiles'] as $share)
      <tr>
        <td>
          {{$share->name}}.{{$share->ext}}
        </td>
        <td>
           {{$share->activation_date}}
          </td>
          <td>
           {{$share->expiration_date}}
          </td>
          <td class="shared-btngrps">
          <button class="btn edit-mod" data-activation={{$share->activation_date}} data-expiration={{$share->expiration_date}} data-link='{{ADMIN_SYSTEM_SITE_URL}}changeUserFromSharingProfile/{{$share->share_table_id}}'>Edit</button>
           
           <button class="btn remove" onclick="removeak1('{{ADMIN_SYSTEM_SITE_URL}}removeUserFromSharingProfile/{{$share->share_table_id}}');" href="javascript:void(0)">Remove</button>
          </td>
      </tr>
      @endforeach
      @endif
      <tr>
      <td class="shared-title">
          Shared Folders
        </td>
        <td class="shared-activation">
          Activation Date
        </td>
        <td class="shared-expiration">
          Expiration Date
        </td>
        <td class="shared-expiration">
          Actions
        </td>
      </tr>
      @if(empty($data['sharedFolders']))
      <tr>
        <td>
          No folders Found
        </td>
      </tr>
      @else
      @foreach($data['sharedFolders'] as $share)
      <tr>
        <td>
          {{$share->name}}
        </td>
        <td>
           {{$share->activation_date}}
          </td>
          <td>
           {{$share->expiration_date}}
          </td>
          <td class="shared-btngrps">
        	<button class="btn edit-mod" data-activation={{$share->activation_date}} data-expiration={{$share->expiration_date}} data-link='{{ADMIN_SYSTEM_SITE_URL}}changeUserFromSharingProfile/{{$share->share_table_id}}'>Edit</button>
           
           <button class="btn remove" onclick="removeak1('{{ADMIN_SYSTEM_SITE_URL}}removeUserFromSharingProfile/{{$share->share_table_id}}');">Remove</button>
          </td>
      </tr>
      @endforeach
      @endif
      <div class="pro-buttons d-flex justify-content-center">

      </div>
</div>

<script>
$(function () {
	$('body').on('click', '.edit-mod', function() {
      $("#user-profile-modal").modal("hide");
      var activationDate = $(this).attr("data-activation");
      var dateAr = activationDate.split('-');
      var newActivateDate = dateAr[1] + '/' + dateAr[2] + '/' + dateAr[0];
      $("#act-date").val(newActivateDate);

      var expirationDate = $(this).attr("data-expiration");
      var dateAr = expirationDate.split('-');
      var newActivateDate = dateAr[1] + '/' + dateAr[2] + '/' + dateAr[0];
      $("#exp-date").val(newActivateDate);

      $("#updatelink").attr('action',$(this).attr("data-link"));
      $("#edit-modal-share").modal("show");
    });
  });
    function removeak1(link){
      $("#user-profile-modal").modal("hide");
    $("#removelink").attr('href',link);
    $("#remove-modal").modal('show');
  }


</script>