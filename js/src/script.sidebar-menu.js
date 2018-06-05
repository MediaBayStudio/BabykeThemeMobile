	var snapper = new Snap({
			element: document.getElementById('content'),
			disable: 'none',
			tapToClose: true,
			touchToDrag: true,
			maxPosition: 260,
			minPosition: -260
	});

	jQuery('.sidebar__control--close').click(function() {
			snapper.close();
	});

	jQuery('.sidebar-deploy--left').click(function() {
		if( snapper.state().state=="left" ) snapper.close();
		else  snapper.open('left');
		jQuery('.share-bottom').removeClass('active-share-bottom');
		return false;
	})

	jQuery('.sidebar-deploy--right').click(function() {
		if( snapper.state().state=="right" ) snapper.close();
		else  snapper.open('right');
    jQuery('.share-bottom').removeClass('active-share-bottom');
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
            f = /^(a|html)jQuery/i;
        a.addEventListener("click", function (a) {
            d = a.target;
            while(!f.test(d.nodeName)) d = d.parentNode;
            "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), e.href = d.href)
        }, !1)
    }
})(document, window.navigator, "standalone");


jQuery(document).ready(function(jQuery) {
    jQuery('.menu-item-has-children>a').click(function(){
        jQuery(this).toggleClass('active-submenu');
        jQuery(this).parent().find('.submenu').slideToggle(200);
        return false;
    });

	//Submenu Nav
	jQuery('.submenu-nav-deploy').click(function() {
		jQuery(this).toggleClass('submenu-nav-deploy-active');
		jQuery(this).parent().find('.submenu-nav-items').slideToggle(200);
		return false;
	});

});
