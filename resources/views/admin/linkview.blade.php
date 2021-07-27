<div class="modal-header no-line txt-center">
  <div id="folderNameDetails">
    {{$data['folderName']}}
  </div>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
  <div class="sharedUsers">
    <table id="myTable2">
      <tbody>
        <tr>
        <td>
          Link
        </td>        
        <td>
            <input type="text" class="form-control disabled" id="copy_link" value="{{ $data['link'] }}">
        </td>
        <td>
            <button value="copy" onclick="copyToClipboard()">Copy</button>
        </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<script>
    function copyToClipboard() {
        $('#copy_link').select();
        document.execCommand('copy');
    }
</script>