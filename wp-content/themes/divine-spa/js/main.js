(function ($) {
 "use strict";

 
  // post grid
  if ( $('#masonry-loop').length ) {
      //set the container that Masonry will be inside of in a var
      var container = document.querySelector('#masonry-loop');
      //create empty var msnry
      var msnry;
      // initialize Masonry after all images have loaded
      imagesLoaded( container, function() {
          msnry = new Masonry( container, {
              itemSelector: '.masonry-entry'
          });
      });
  } 
  
  // pagination  
  $(".pagination-area ul.page-numbers span.current").replaceWith('<a href="#" class="active">' + $(".pagination-area ul.page-numbers span.current").html() + "</a>"); 
  $('.pagination-area ul.page-numbers').addClass('pagination pagination-lg');
  
  //  comment style
  $(".blog-single-area ol.comment-list li .comment-reply-link").prepend('<i class="fa fa-reply"></i> ');
  $(".comment-respond").addClass('blog-comment-bx');
  $(".comment-form-author").replaceWith('<div class="col-lg-6 col-md-6">' + $(".comment-form-author").html() + "</div>"); 
  $(".comment-form-email").replaceWith('<div class="col-lg-6 col-md-6">' + $(".comment-form-email").html() + "</div>"); 
  $('.comment-respond.blog-comment-bx #author,.comment-respond.blog-comment-bx #email,.comment-respond.blog-comment-bx #comment').addClass('form-control');
  $(".comment-respond.blog-comment-bx .col-lg-6.col-md-6").wrapAll("<div class=\"row\"></div>");
  $(".comment-respond.blog-comment-bx .row").wrapAll("<div class=\"form-group\"></div>");
  $(".comment-form-comment").replaceWith('<div class="form-group">' + $(".comment-form-comment").html() + "</div>");  
  $(".comment-respond.blog-comment-bx #submit").unwrap();

  // widget recent post , category, archive , recent comments
  $(".widget_pages ul li a,.widget_recent_entries ul li a,.widget_categories ul li a,.widget_archive ul li a,.widget_recent_comments ul li .comment-author-link,.widget_meta ul li a,#menu-testing-menu li a").prepend('<i class="fa fa-angle-right"></i>'); 
  $(".services-list-area section figure.hover").hide();
  $(".services-list-area section").hover(function(){
      $("figure.hvr", this).hide();
      $("figure.hover", this).show();
      }, function(){
      $("figure.hvr", this).show();
      $("figure.hover", this).hide();
  });
    
  // product tab
  $('.single-product-tab-nav .nav-tabs li:first-child').addClass('active');

   // scrollUp
  $(document).ready(function(){
  	
  	//Check to see if the window is top if not then display button
  	$(window).scroll(function(){
  		if ($(this).scrollTop() > 100) {
  			$('.scrollToTop').fadeIn();
  		} else {
  			$('.scrollToTop').fadeOut();
  		}
  	});
  	
  	//Click event to scroll to top
  	$('.scrollToTop').click(function(){
  		$('html, body').animate({scrollTop : 0},800);
  		return false;
  	});
  	
  });

  // jQuery MeanMenu
  jQuery('nav#dropdown').meanmenu();	
  	  
 
})(jQuery); 