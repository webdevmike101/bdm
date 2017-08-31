var currentPage = location.pathname.split('/').slice(-1)[0];
var currentPageLink = "";
var currentLinkWidth = "";

var homeLinkLeftPosition = "";
var aboutLinkLeftPosition = "";
var galleryLinkLeftPosition = "";
var buyLinkLeftPosition = "";

var homeLinkWidth = "";
var aboutLinkWidth = "";
var galleryLinkWidth = "";
var buyLinkWidth = "";	

$(document).ready(function(){

	// add class="current" to link of current page //////////////////////////////////////////////
	if(currentPage == ""){
		$("a[href$='home']").addClass("current").attr("id", "current");
	}
	else{
		$("a[href$='"+currentPage+"']").addClass("current").attr("id", "current");
	}

	// get the position of the link for the curent page
	function getPositionOfCurrent(){
		currentPageLink = $('#current').offset();
		currentLinkWidth = $('#current').outerWidth();
	};

	// position the current page indicator under the link for the current page
	function underline(){
			$('#location-indicator').css({
      			left:  currentPageLink.left,
      			width: currentLinkWidth
      		});
	};

	// reset the current page indicator when page is resized 
	$(window).resize(function(){
		getPositionOfCurrent();
		underline();
	});

	function getPositionAndWidth(){

		homeLinkLeftPosition = $("a[href$='home']").offset().left;
		aboutLinkLeftPosition = $("a[href$='about']").offset().left;
		galleryLinkLeftPosition = $("a[href$='gallery']").offset().left;
		buyLinkLeftPosition = $("a[href$='buy']").offset().left;

		homeLinkWidth = $("a[href$='home']").outerWidth();
		aboutLinkWidth = $("a[href$='about']").outerWidth();
		galleryLinkWidth = $("a[href$='gallery']").outerWidth();
		buyLinkWidth = $("a[href$='buy']").outerWidth();	
	}
	///////////////////////////////////////////////////////////////////////////////////////////////

	$('.main-nav-list > li').mouseover(function(){
		if($('> a', this).attr('id') != "current"){
			var position = $(this).offset().left;
			var width = $(this).outerWidth();
			move(position, width);
		}	

		// switch($(this).attr('id')){

		// 	case "home-li":
		// 		move(homeLinkLeftPosition, homeLinkWidth)
		// 		break;
		// 	case "about-li":
		// 		move(aboutLinkLeftPosition, aboutLinkWidth)
		// 		break;
		// 	case "gallery-li":
		// 		move(galleryLinkLeftPosition, galleryLinkWidth)
		// 		break;
		// 	case "buy-li":
		// 		move(buyLinkLeftPosition, buyLinkWidth)
		// 		break;
		// }	
	});	

	$('.main-nav-list').mouseleave(function(){
		$('#location-indicator').animate({left: currentPageLink.left, width: currentLinkWidth});
	});

	function move(position, width){
	    	$('#location-indicator').animate({left: position, width: width}, 'fast');		
	}

	getPositionOfCurrent();
	getPositionAndWidth();
	underline();
});










// var currentPage = location.pathname.split('/').slice(-1)[0];
// var currentPageLink = "";

// var homeLinkLeftPosition = "";
// var aboutLinkLeftPosition = "";
// var galleryLinkLeftPosition = "";
// var buyLinkLeftPosition = "";

// var homeLinkWidth = "";
// var aboutLinkWidth = "";
// var galleryLinkWidth = "";
// var buyLinkWidth = "";

// var homeLinkRightPosition = "";
// var aboutLinkRightPosition = "";
// var galleryLinkRightPosition = "";
// var buyLinkRightPosition = "";

// var homeLink = "";
// var aboutLink = "";
// var galleryLink = "";
// var buyLink = "";

// var indicatorCurrentPosition = "";

// $(document).ready(function(){

// 	// var posHome = $('li:first').offset();
// 	// var posAbout = $('li:nth-child(2)').offset();
// 	// var posGallery = $('li:nth-child(3)').offset();
// 	// var posBuy = $('li:nth-child(4)').offset();

// 	// add class="current" to link of current page //////////////////////////////////////////////
// 	if(currentPage == ""){
// 		$("a[href$='home']").addClass("current").attr("id", "current");
// 	}
// 	else{
// 		$("a[href$='"+currentPage+"']").addClass("current").attr("id", "current");
// 	}
// 	///////////////////////////////////////////////////////////////////////////////////////////////

// 	// get the position of the link for the curent page as well as all of the links ///////////////
// 	function getPositionOfCurrent(){
// 		currentPageLink = $('#current').offset();
// 	};
// 	///////////////////////////////////////////////////////////////////////////////////////////////

// 	// function getPositionOfLinks(){
// 	// 	homeLinkLeftPosition = $("a[href$='home']").offset().left;
// 	// 	aboutLinkLeftPosition = $("a[href$='about']").offset().left;
// 	// 	galleryLinkLeftPosition = $("a[href$='gallery']").offset().left;
// 	// 	buyLinkLeftPosition = $("a[href$='buy']").offset().left;

// 	// 	// also get the widths of the links		
// 	// 	homeLinkWidth = $("a[href$='home']").outerWidth();
// 	// 	aboutLinkWidth = $("a[href$='about']").outerWidth();
// 	// 	galleryLinkWidth = $("a[href$='gallery']").outerWidth();
// 	// 	buyLinkWidth = $("a[href$='buy']").outerWidth();	

// 	// 	homeLinkRightPosition = homeLinkLeftPosition + homeLinkWidth;
// 	// 	aboutLinkRightPosition = aboutLinkLeftPosition + aboutLinkWidth;
// 	// 	galleryLinkRightPosition = galleryLinkLeftPosition + galleryLinkWidth;
// 	// 	buyLinkRightPosition = buyLinkLeftPosition + buyLinkWidth;

// 	// 	// alert("home " + homeLinkLeftPosition);
// 	// 	// alert("home " + homeLinkRightPosition);
// 	// 	// alert("about " + aboutLinkLeftPosition);
// 	// 	// alert("about " + aboutLinkRightPosition);
// 	// 	// alert("gallery " + galleryLinkLeftPosition);
// 	// 	// alert("gallery " + galleryLinkRightPosition);
// 	// 	// alert("buy " + buyLinkLeftPosition);
// 	// 	// alert("buy " + buyLinkRightPosition);
// 	//};

// 	// position the current page indicator under the link for the current page ///////////////////
// 	function underline(){
// 		//if(currentPage == ""){
// 			alert(currentPageLink.left);
// 			// $('#location-indicator').css({
//    //    			left:  currentPageLink.left
//    //   		});
// 		//}
// 		//else{

// 		//	$('#location-indicator').css({
//        	//		left:  currentPageLink.left
//      	//	});

//      	//	indicatorCurrentPosition = currentPageLink.left;
// 		//}
// 	};
// 	///////////////////////////////////////////////////////////////////////////////////////////////

// 	// reset the current page indicator when page is resized ///////////////////////////////////////
// 	$(window).resize(function(){
// 		getPositionOfCurrent();
// 		underline();
// 		getPositionOfLinks();
// 	});
// 	///////////////////////////////////////////////////////////////////////////////////////////////

// 	//var working = false;
// 	// var currentMousePos = { x: -1, y: -1 };
	
//  //    $(document).mousemove(function(event) {
//  //        currentMousePos.x = event.pageX;
//  //        currentMousePos.y = event.pageY;
//  //    });

// 	// function slideOver(){

// 	// 	working = true;

// 	// 	var distance = currentMousePos.x - 15 + "px";

// 	// 	$('#location-indicator').animate({left: distance});
// 	// 	//stick();
// 	// }

// 	// var handler = function(e){

// 	// 	var pos = e.pageX - 15;
// 	// 	$('#location-indicator').css({
//  // 			left:  pos
// 	// 	});
// 	// };

// 	//$('#main-nav').mousemove(function(){ // last night I changed this from mouseover to mousemove *************************************************

// 		//if(!working){
// 		//	slideOver();
// 		//}
// 		//else{
// 		//	stick();
// 		//}
		
// 	//});

// 	// function stick(){

// 	// 	$(document).bind('mousemove', handler);
// 	// 	//$(document).unbind('mousemove', handler2());
// 	// }

// 	// $('#main-nav').mouseout(function(){
// 	// 	$(document).unbind('mousemove', underline());
// 	// });

// 	// $('ul.main-nav-list > li').mousemove(function(){

// 	// 	//alert(currentMousePos.x);

// 	// 	if(currentMousePos.x > homeLinkLeftPosition && currentMousePos.x < homeLinkRightPosition){
// 	// 		var p = homeLinkLeftPosition;
// 	// 		move(p);
// 	// 	}
// 	// 	else if(currentMousePos.x > aboutLinkLeftPosition && currentMousePos.x < aboutLinkRightPosition){
// 	// 		var p = aboutLinkLeftPosition;
// 	// 		move(p);
// 	// 	}
// 	// 	else if(currentMousePos.x > galleryLinkLeftPosition && currentMousePos.x < galleryLinkRightPosition){
// 	// 		var p = galleryLinkLeftPosition;
// 	// 		move(p);
// 	// 	}
// 	// 	else if(currentMousePos.x > buyLinkLeftPosition && currentMousePos.x < buyLinkRightPosition){
// 	// 		var p = buyLinkLeftPosition;
// 	// 		move(p);
// 	// 	}
// 	// });

// 	$('#main-nav-div').mouseenter(function(){

// 		$('#home-li').mouseover(function(){
// 			var p = homeLinkLeftPosition;
// 			move(p);
// 		});
// 		$('#about-li').mouseover(function(){
// 			var p = aboutLinkLeftPosition;
// 			move(p);
// 		});
// 		$('#gallery-li').mouseover(function(){
// 			var p = galleryLinkLeftPosition;
// 			move(p);
// 		});
// 		$('#buy-li').mouseover(function(){
// 			var p = buyLinkLeftPosition;
// 			move(p);
// 		});
// 	})
	

// 	function move(p){
// 		$('#location-indicator').animate({left: p});
// 		//$('#location-indicator').css({
//    		//	left:  p
//    		//});
// 		//$(this).unbind('mousemove')
// 		//indicatorCurrentPosition = p;
// 	}

// 	$('#main-nav-div').mouseleave(function(){
// 		$('#location-indicator').animate({left: currentPageLink.left});
// 	});

// 	//getPositionOfLinks();
// 	getPositionOfCurrent();
// 	underline();
// });