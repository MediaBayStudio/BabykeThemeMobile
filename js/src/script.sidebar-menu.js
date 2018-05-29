	var snapper = new Snap({
			element: document.getElementById('content'),
			disable: 'none',
			tapToClose: true,
			touchToDrag: true,
			maxPosition: 260,
			minPosition: -260
	});

	$('.sidebar__control--close').click(function() {
			snapper.close();
	});

	$('.sidebar-deploy--left').click(function() {
		if( snapper.state().state=="left" ) snapper.close();
		else  snapper.open('left');
		$('.share-bottom').removeClass('active-share-bottom');
		return false;
	})

	$('.sidebar-deploy--right').click(function() {
		if( snapper.state().state=="right" ) snapper.close();
		else  snapper.open('right');
    $('.share-bottom').removeClass('active-share-bottom');
		return false;
	});

var addEvent = function addEvent(element, eventName, func) {
	if (element.addEventListener) {
    	return element.addEventListener(eventName, func, false);
    } else if (element.attachEvent) {
        return element.attachEvent("on" + eventName, func);
    }
};


/* Prevent Safari opening links when viewing as a Mobile App */
(function (a, b, c) {
    if(c in b && b[c]) {
        var d, e = a.location,
            f = /^(a|html)$/i;
        a.addEventListener("click", function (a) {
            d = a.target;
            while(!f.test(d.nodeName)) d = d.parentNode;
            "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href)
        }, !1)
    }
})(document, window.navigator, "standalone");


jQuery(document).ready(function($) {
    $('.menu-item-has-children>a').click(function(){
        $(this).toggleClass('active-submenu');
        $(this).parent().find('.submenu').slideToggle(200);
        return false;
    });

	//Submenu Nav
	$('.submenu-nav-deploy').click(function() {
		$(this).toggleClass('submenu-nav-deploy-active');
		$(this).parent().find('.submenu-nav-items').slideToggle(200);
		return false;
	});

});
