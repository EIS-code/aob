$(document).ready(function(){
  $(".slide").click(function(){
    $(this).next(".slide-div").slideToggle();
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


}); 
$(document).ready(function() {

    
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
//         alert($(this).next('input').val());
        $(this).parent().toggleClass("active");
    });
    $(document).on("click","input[type=radio][name=move]",function(e) {
    //$('input[type=radio][name=move]').click(function() {
    $(this).parent().addClass("active1");
    $('input[type=radio][name=move]').not(this).parent().removeClass("active1");
});

$(document).on("click",'.movemodal',function(e){
  e.stopPropagation();
  $("#move_folder_id").val($(this).attr('data-id'));
  $("#move_file").val('0');
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
$(document).on("click",'.copyfilemodal',function(e){
  e.stopPropagation();
  $("#copy_folder_id").val($(this).attr('data-id'));
  $("#copy_file").val('1');
});

});

$('input[type=radio][name=move]').click(function() {
    $(this).parent().addClass("active1");
	$('input[type=radio][name=move]').not(this).parent().removeClass("active1");
});
$('input[type=radio][name=copy]').click(function() {
    $(this).parent().addClass("active1");
  $('input[type=radio][name=copy]').not(this).parent().removeClass("active1");
});