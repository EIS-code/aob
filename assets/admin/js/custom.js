$(document).ready(function(){

  $(".slide").click(function(){

    $(this).next(".slide-div").slideToggle();

	$('.slide').not(this).next(".slide-div").hide();

  }); 


$('body').on('click', '.cp-list li', function() {

    //code	

	  $(this).appendTo( $(this).parentsUntil('.tab-content').find(".cp-tags ul") );

});

$('body').on('click', '.cp-tags li', function() {

    //code

	$(this).appendTo( $(this).parentsUntil('.tab-content').find(".cp-list ul"));

	  //$(this).next().find(".cp-list ul").append($(this));

});


// serach functionality with table

$('body').on('click', '.cp-list-table tr', function() {
    //code	
	if ($(this).parents('.share-cp').length) {

}else{
	  $(this).appendTo( $(this).parentsUntil('.tab-content').find(".cp-tags .cp-tags-table") );
}
});

$('body').on('click', '.cp-tags .cp-tags-table tr', function() {
    //code
	$(this).appendTo( $(this).parentsUntil('.tab-content').find(".cp-list .cp-list-table"));
	  //$(this).next().find(".cp-list ul").append($(this));
});
//---------------------

$('.myfile').on('change', function() {

  //this.files[0].size gets the size of your file.
$('.no-bg').html('');
var filename = $(this).val().split('\\').pop(); 
$(this).closest('.fileinput-button .no-bg').detach(); 

$(this).closest('.fileinput-button').after('<span class="no-bg">'+filename+'</span>');	  

sizeInMB = (this.files[0].size / (1024*1024)).toFixed(2);

$(this).closest('.fileinput-button').after('<span class="no-bg">'+sizeInMB+' MB</span>');	

});

//tootip

$('[data-toggle="tooltip"]').tooltip();

    var readURL = function(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {

                $('.profile-pic').attr('src', e.target.result);

            }

            reader.readAsDataURL(input.files[0]);
        }
}


$(".file-upload").on('change', function(){

        readURL(this);

});
    

$(".upload-button").on('click', function() {

       $(".file-upload").click();

});

});

function deleteak(link){
  $("#deletelink").attr('href',link);
  $("#delete-modal").modal('show');
}
function restoreak(link){
  $("#restorelink").attr('href',link);
  $("#restore-modal").modal('show');
}
function removeak(link){
  $("#removelink").attr('href',link);
  $("#remove-modal").modal('show');
}
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction2() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput2");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable2");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction3() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput3");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable3");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function myFunction4() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput4");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable4");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
function showList(e) {

  var $gridCont = $('.grid-container');

  e.preventDefault();

  $gridCont.hasClass('list-view') ? $gridCont.removeClass('list-view') : $gridCont.addClass('list-view');

}

function gridList(e) {

  var $gridCont = $('.grid-container')

  e.preventDefault();

  $gridCont.removeClass('list-view');

}



$(document).on('click', '.btn-grid', gridList);

$(document).on('click', '.btn-list', showList);

//accordian permission


$('.jquery_accordion_title').click(function() {

	$(this).closest('.jquery_accordion_item').siblings().removeClass('active').find('.jquery_accordion_content').slideUp(400);

	$(this).closest('.jquery_accordion_item').toggleClass('active').find('.jquery_accordion_content').slideToggle(400);

	return false;

});


$(function () {

$(document).on("click","#megaUber a",function(e) {  //$('#megaUber').find('a').click(function (e) {
    e.stopPropagation();
		$(this).next('input').prop("checked", true).trigger("click");
		// alert($(this).next('input').val());
    $(this).parent().toggleClass("active");
});

	$(document).on("click","input[type=radio][name=move]",function(e) {

	//$('input[type=radio][name=move]').click(function() {

    $(this).parent().toggleClass("active1");
	
	

	$('input[type=radio][name=move]').not(this).parent().removeClass("active1");

});

$(document).on("click","input[type=radio][name=copy]",function(e) {

	//$('input[type=radio][name=move]').click(function() {

    $(this).parent().toggleClass("active1");
	
	

	$('input[type=radio][name=copy]').not(this).parent().removeClass("active1");

});



$(document).on("click",'.movemodal',function(e){

  e.stopPropagation();

  $("#move_folder_id").val($(this).attr('data-id'));

  $("#move_file").val('0');

});

$(document).on("click",'.movefixfilemodal',function(e){

  e.stopPropagation();

  $("#move_fixfolder_id").val($(this).attr('data-id'));

  $("#move_fix_file").val('1');

});

$(document).on("click",'.movefilemodal',function(e){

  e.stopPropagation();

  $("#move_folder_id").val($(this).attr('data-id'));

  $("#move_file").val('1');

});

$(document).on("click",'.copymodal',function(e){

  e.stopPropagation();

  $("#copy_folder_id").val($(this).attr('data-id'));

  $("#copy_file").val('0');

});

$(document).on("click",'.sharefolder',function(e){

  e.stopPropagation();

  $("#team_shared_id").val($(this).attr('data-id'));

  $("#user_shared_id").val($(this).attr('data-id'));

  $("#team_share_type").val('folder');

  $("#user_share_type").val('folder');

});

$(document).on("click",'.sharefile',function(e){

  e.stopPropagation();

  $("#team_shared_id").val($(this).attr('data-id'));

  $("#user_shared_id").val($(this).attr('data-id'));

  $("#team_share_type").val('file');

  $("#user_share_type").val('file');

});

$(document).on("click",'.copyfilemodal',function(e){

  e.stopPropagation();

  $("#copy_folder_id").val($(this).attr('data-id'));

  $("#copy_file").val('1');

});

$(document).on("click",'.copyfixfilemodal',function(e){

  e.stopPropagation();

  $("#copy_fix_folder_id").val($(this).attr('data-id'));

  $("#copy_fix_file").val('1');

});



});


$(".btn-set").click(function(){
    $(this).addClass("active");
	$('.btn-set').not(this).removeClass("active");
});



$('input[type=radio][name=move]').click(function() {

    $(this).parent().addClass("active1");

  $('input[type=radio][name=move]').not(this).parent().removeClass("active1");

});

$('input[type=radio][name=copy]').click(function() {

    $(this).parent().addClass("active1");

  $('input[type=radio][name=copy]').not(this).parent().removeClass("active1");

});

$(document).on("click",'.open-click',function(e){
	
});

$('.activation_date').datepicker({
  autoclose: true,
  orientation: "top",
});
$('.expiration_date').datepicker({
  autoclose: true,
  orientation: "top",
});

$('#act-date, #exp-date').datepicker({
  autoclose: true,
  orientation: "top",
});

$(document).ready(function(){
  $("#crtfile").on("submit", function(){
   $("#pageloader").show();
	$('#sube').value = 'Processing . . .';
  });
});



function deRequireCb(elClass) {
            el=document.getElementsByClassName(elClass);

            var atLeastOneChecked=false;//at least one cb is checked
            for (i=0; i<el.length; i++) {
                if (el[i].checked === true) {
                    atLeastOneChecked=true;
                }
            }

            if (atLeastOneChecked === true) {
                for (i=0; i<el.length; i++) {
                    el[i].required = false;
                }
            } else {
                for (i=0; i<el.length; i++) {
                    el[i].required = true;
                }
            }
        }

