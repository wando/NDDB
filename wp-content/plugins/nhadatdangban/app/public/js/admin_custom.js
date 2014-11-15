var nhadatdangban = nhadatdangban || {};

// create a general purpose namespace method
nhadatdangban.createNS = function(namespace) {
    var nsparts = namespace.split(".");
    var parent = nhadatdangban;

    if (nsparts[0] === "nhadatdangban") {
        nsparts = nsparts.slice(1);
    }

    for (var i = 0; i < nsparts.length; i++) {
        var partname = nsparts[i];
        if (typeof parent[partname] === "undefined") {
            parent[partname] = {};
        }
        parent = parent[partname];
    }
    return parent;
};

//START: JAVASCRIPT FOR FUNCTION COMMON ========================================
nhadatdangban.createNS("nhadatdangban.COMMON");

nhadatdangban.COMMON.format = function(n, sep) {
    sep = sep || ".";
    return n.toLocaleString().split(sep)[0];
}

nhadatdangban.COMMON.roundAccuracy = function(num, acc) {
	var factor=Math.pow(10,acc);
    return Math.round(num*factor)/factor;
}

nhadatdangban.COMMON.confirmDelele = function() {
	return confirm('Are you sure you want to delete this item ?');
}

nhadatdangban.COMMON.newSendToEditor = function(html) {
    if (typeof jQuery(html).attr('src') != 'undefined') {
        src_url = jQuery(html).attr('src');
    } else if (typeof jQuery(html).attr('href') != 'undefined') {
        src_url = jQuery(html).attr('href');
    } else if (typeof jQuery('img',html).attr('src') != 'undefined') {
        src_url = jQuery('img',html).attr('src');
    }
    jQuery(nhadatdangban.COMMON.input_media_field).val(src_url);
    var re = /(?:\.([^.]+))?$/;
    var ext = re.exec(src_url)[1];
    var imagesExt = ['jpg','bmp', 'png', 'gif'];
    
    $container = jQuery(nhadatdangban.COMMON.input_media_field + '_src').attr('data-container');
    
    if (imagesExt.indexOf(ext)>=0) {
        jQuery(nhadatdangban.COMMON.input_media_field + '_src').attr('src', src_url.replace('.jpg', '-150x150.jpg'));
        if (typeof jQuery($container).attr('id') != 'undefined') {
            jQuery($container).css('display', 'block');
        }
    } else {
        jQuery(nhadatdangban.COMMON.input_media_field + '_src').attr('src', '');
        if (typeof jQuery($container).attr('id') != 'undefined') {
            jQuery($container).css('display', 'none');
        }
    }
}

nhadatdangban.COMMON.swapFunction = function(editor) {
    if (typeof nhadatdangban.COMMON.onHookMediaInsertToPost != 'undefined') {
        window.send_to_editor = nhadatdangban.COMMON.onHookMediaInsertToPost;
    } else {
        window.send_to_editor = nhadatdangban.COMMON.newSendToEditor;
    }
};

nhadatdangban.COMMON.addEventMediaButtonForInput = function(button_el, input_el) {
    if (typeof jQuery(button_el).attr('id') != 'undefined') {
        jQuery(button_el).click(function(){
            nhadatdangban.COMMON.input_media_field = input_el;
            nhadatdangban.COMMON.swapFunction();
        });
    }
}
//END: JAVASCRIPT FOR FUNCTION COMMON ==========================================



jQuery(document).ready(function() {
	if (typeof jQuery("#backtoblog").attr('id') != 'undefined') {
        jQuery("#backtoblog").remove();
        jQuery("#login h1").remove();
    }
    
    jQuery("#your-profile .form-table:first, #your-profile h3:first, #wpfooter").remove();
    jQuery('.attachment-display-settings').remove();
	
	
	if (typeof jQuery("#icon-users").attr('id') != 'undefined') {
        jQuery("#delete_option0").prop('checked', true);
        jQuery("#submit").attr("id", "submitbutton");
        jQuery("#submitbutton").prop("disabled", false);
    }
    
    jQuery('input[type=text]').focus(function () { 
        jQuery(this).select();
    });
	
	jQuery('.action-delete').click(function(){
            var answer = confirm('Are you sure you want to delete this item ?');
            return answer;
    });
    
});