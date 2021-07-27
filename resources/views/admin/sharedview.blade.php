<div class="modal-header no-line txt-center">
  <div id="folderNameDetails">
    {{$data['folderName']}}
  </div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
  <div class="sharedUsers">
    <table id="myTable2" class=" share-cp">
      <tbody>
        <tr>
        <td class="shared-title">
          Shared Users
        </td>
        <td class="shared-activation">
          Activation Date
        </td>
        <td class="shared-expiration">
          Expiration Date
        </td>
        <td class="shared-actions">
          Actions
        </td>
        </tr>
        @if(empty($data['sharedUsers']))
        <tr>
          <td>
            No User Found
          </td>
        </tr>
        @else
        @foreach($data['sharedUsers'] as $user)
        <tr>
          <td>
            <?php if (file_exists(public_path('/users/' . $user->image))) {
              $image_file = SYSTEM_SITE_URL . 'public/users/' . $user->image;
            } else {
              $image_file = SYSTEM_SITE_URL . 'public/users/user.png';
            }  ?>
            <img src="{{$image_file}}"><span>{{$user->name}}</span>
          </td>
          <td>
           {{$user->activation_date}}
          </td>
          <td>
           {{$user->expiration_date}}
          </td>
          <?php 
           $folderId = $data['folderId'];
           $type = $data['type'];
           ?>
          <td class="shared-btngrps">
        	<button class="btn edit-mod" data-activation={{$user->activation_date}} data-expiration={{$user->expiration_date}} data-link='{{ADMIN_SYSTEM_SITE_URL}}changeUserFromSharing/{{$user->id}}/{{$folderId}}/{{$type}}/user'>Edit</button>
           
           <button class="btn remove" onclick="removeak1('{{ADMIN_SYSTEM_SITE_URL}}removeUserFromSharing/{{$user->id}}/{{$folderId}}/{{$type}}/user');" href="javascript:void(0)">Remove</button>
        </td>
        </tr>
        @endforeach
        @endif
        <tr>
        <td class="shared-title">
          Shared Teams
        </td>
        <td class="shared-activation">
          Activation Date
        </td>
        <td class="shared-expiration">
          Expiration Date
        </td>
        <td class="shared-actions">
          Actions
        </td>
        </tr>
        @if(empty($data['sharedTeams']))
        <tr>
          <td>
            No Teams Found
          </td>
        </tr>
        @else
        @foreach($data['sharedTeams'] as $team)
        <tr>
          <td>
            <?php if (file_exists(public_path('/team/' . $team->profile_picture))) {
              $image_file = SYSTEM_SITE_URL . 'public/team/' . $team->profile_picture;
            } else {
              $image_file = SYSTEM_SITE_URL . 'public/team/user.png';
            }  ?>
            <img src="{{$image_file}}"><span>{{$team->team_name}}</span>
          </td>
          <td>
           {{$team->activation_date}}
          </td>
          <td>
           {{$team->expiration_date}}
          </td>
          <?php 
           $folderId = $data['folderId'];
           $type = $data['type'];
           ?>
          <td class="shared-btngrps">
        	<button class="btn edit-mod" data-activation={{$team->activation_date}} data-expiration={{$team->expiration_date}} data-link='{{ADMIN_SYSTEM_SITE_URL}}changeUserFromSharing/{{$team->id}}/{{$folderId}}/{{$type}}/team'>Edit</button>
           
           <button class="btn remove" onclick="removeak1('{{ADMIN_SYSTEM_SITE_URL}}removeUserFromSharing/{{$team->id}}/{{$folderId}}/{{$type}}/team');">Remove</button>
          </td>
        </tr>
        @endforeach
        @endif
      </tbody>
    </table>
  </div>
</div>

<script>
$(function () {
	$('body').on('click', '.edit-mod', function() {
      $("#folder-share-modal").modal("hide");
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
      $("#folder-share-modal").modal("hide");
    $("#removelink").attr('href',link);
    $("#remove-modal").modal('show');
  }


</script>