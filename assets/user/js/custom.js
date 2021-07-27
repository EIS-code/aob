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

$('.myfile').on('change', function() {

  //this.files[0].size gets the size of your file.
$('.no-bg').html('');
var filename = $(this).val().split('\\').pop(); 
$(this).closest('.fileinput-button .no-bg').detach(); 

$(this).closest('.fileinput-button').after('<span class="no-bg">'+filename+'</span>');	  

sizeInMB = (this.files[0].size / (1024*1024)).toFixed(2);

$(this).closest('.fileinput-button').after('<span class="no-bg">'+sizeInMB+' MB</span>');	

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

$(".btn-set").click(function(){
    $(this).addClass("active");
	$('.btn-set').not(this).removeClass("active");
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
		alert($(this).next('input').val());
        $(this).parent().toggleClass("active");
    });
	$(document).on("click","input[type=radio][name=move]",function(e) {
	//$('input[type=radio][name=move]').click(function() {
    $(this).parent().addClass("active1");
	$('input[type=radio][name=move]').not(this).parent().removeClass("active1");
});
});

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});


// main-nav
jQuery(document).ready(function($){
$('#nav-toggle').on('click touch', function (event) {
			event.preventDefault();
			$('body').toggleClass('nav-open');

			if (!$('body').hasClass('nav-open')) {
				$('#menu-menu ul.sub-menu').removeClass('active');
			}
		});

		$('#menu-menu li.menu-item-has-children').each(function () {
			var siblingSubmenu = $(this).find('> ul.sub-menu');
			
			$(this).find('> a').clone().prependTo(siblingSubmenu).wrap('<li class="menu-item menu-item-parent-cloned"></li>');
			siblingSubmenu.prepend('<li class="back-one-level"><a href="#">Back</a></li>');
			
		});

		$('#menu-menu li.menu-item-has-children > a').on('click touch', function (event) {
			event.preventDefault();
			$(this).next('ul.sub-menu').addClass('active');
		});

		$('#menu-menu .back-one-level > a').on('click touch', function (event) {
			
			event.preventDefault();
			$(this).closest('.sub-menu.active').removeClass('active');
	});
	
		
});

