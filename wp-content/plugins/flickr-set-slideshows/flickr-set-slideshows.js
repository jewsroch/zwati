jQuery(document).ready(function($) {
    /////////////listing pages functions///////////////    
    
    ///hide/reveal preview of slidehows///
    $( 'tr.fsg-preview' ).hide();
    
    //preview link event
    $( 'a.fsg-preview-link' ).click( function( event ) {
	event.preventDefault();
	var id = $( this ).closest( 'a' ).attr( 'id' );
	var target = $( 'tr#fsg-' + id );
	if ( $( target ).is( ':visible' ) ) {
	    $( target ).slideUp( 'slow' );
	} else {
	    $( 'tr.fsg-preview' ).each( function() {
		    if ( $( this ).is( ':visible' ) ) {
			$( this ).hide();
		    }
		});
	    $( target ).slideDown( 'slow' );
	}
    });
    
    //close link event
    $( 'span.fsg-close a' ).click( function( event ) {
	event.preventDefault();
	var target = $( this ).closest( 'tr' );
	if ( $( target ).is( ':visible' ) ) {
	    $( target ).slideUp( 'slow' );
	}
    });
    /// end hide/reveal preview of slidehows///
    
    /// delete slideshow events///
    $( 'a.fsgDelete' ).each( function() {
	$( this ).attr( 'href' , absolutePaths.ajaxUrl );
    });
    
    $( 'a.fsgDelete' ).click( function( event ) {
	event.preventDefault();
	$( this ).hide();
	var galId = $( this ).attr( 'id' ).replace( 'fsgDel' , '' );
	if ( ! confirm( 'Are you sure you want to delete this slideshow?' ) ) {
	    $( this ).show();
	    return;
	}
	$.getJSON( absolutePaths.ajaxUrl , { action : "admin_del_fsg" , gal_id : galId } ,
	       function( data ) {
		    if ( data.success ) {
			var line2 = $( 'tr#fsg-' + data.gallery );
			var line1 = $( 'tr#fsg-' + data.gallery ).prev();
			$( line2 ).remove();
			$( line1 ).remove();
			checkTableNotEmpty( absolutePaths.homeUrl , $ );
		    } else {
			alert( "Sorry, couldn't delete gallery." );
			$( this ).show();
		    }
		});
    });
    /// end delete slideshow events///
    
    ///change size of slideshow ///
    $( 'a.editFsgLink' ).each( function() {
	$( this ).attr( 'href' , absolutePaths.ajaxUrl );
    });
    
    $( 'a.editFsgLink' ).click( function( event ) {
	bindEditSizeEvent( event , this , $ );
    });
    ///end change size of slideshow

    ///////////////new gallery page preview function///////
    var previewArea = $( 'div#fsg-new-preview' );
    if ( $( previewArea.length !== 0 ) ) {
	var submitButton = $( 'input#new-gallery-submit' );
	submitButton.attr( 'disabled' , 'disabled' );
	//set title for preview
	$( 'div#fsg-preview-title' ).html( '<h2>Gallery preview</h2>' );
	//set preview
	$( 'select' ).change( function() {
		if ( $( 'select[name=photoset] option:selected' ).attr( 'value' ).length !== 0 && $( 'select[name=size] option:selected' ).attr( 'value' ).length !== 0 ) {
		    setGalleryPreview( $ );
		    submitButton.removeAttr( 'disabled' );
		} else {
		    previewArea.html( '' );
		    submitButton.attr( 'disabled' , 'disabled' );
		}
	    });
    }
});

function setGalleryPreview( $ ){
	var previewArea = $( 'div#fsg-new-preview' );
	var set = $( 'select[name=photoset] option:selected' ).attr( 'value' );
	var size = $( 'select[name=size] option:selected' ).attr( 'value' );
	var w;
	var h;
	var user_id = $( 'input[name=flickr_id]' ).attr( 'value' );
	switch( size ) {
	    case 'sm':
		w = 400;
		h = 300;
	    break;
	    case 'me':
		w = 500;
		h = 375;
	    break;
	    case 'la':
		w =700;
		h = 525;
	    break;
	    case 'su':
		w = 800;
		h = 600;
	    break;
	}
	var previewHtml = '';
	previewHtml = '<object width="' + w + '" height="' + h + '">';
	previewHtml += '<param name="flashvars" value="offsite=true&lang=en-us&page_show_url=%2Fphotos%2F' + user_id + '%2Fsets%2F' + set + '%2Fshow%2F&page_show_back_url=%2Fphotos%2F' + user_id + '%2Fsets%2F' + set + '%2F&set_id=' + set + '&jump_to="></param><param name="movie" value="http://www.flickr.com/apps/slideshow/show.swf?v=109615"></param><param name="allowFullScreen" value="true"></param><embed type="application/x-shockwave-flash" src="http://www.flickr.com/apps/slideshow/show.swf?v=109615" allowFullScreen="true" flashvars="offsite=true&lang=en-us&page_show_url=%2Fphotos%2F' + user_id + '%2Fsets%2F' + set + '%2Fshow%2F&page_show_back_url=%2Fphotos%2F' + user_id + '%2Fsets%2F' + set + '%2F&set_id=' + set + '&jump_to=" width="' + w + '" height="' + h + '"></embed></object>';
	$( previewArea ).html( previewHtml );
}

function checkTableNotEmpty( homeUrl , $ ) {
    var filled = $( 'table#fsgListing tbody tr' ).length;
    if ( ! filled ) {
	$( 'table#fsgListing' ).remove();
	$( 'div#fsg_body' ).html( '<p style="text-align:center;">There are no slideshows right now. Create galleries from <a href="' + homeUrl + '/wp-admin/admin.php?page=flickr_set_galleries_new">Flick Set Slideshows &#62; Add new page</a>.</p>');
    }
}

function sizeSelected( opt , $ ) {
    newSize = $( opt ).val();
    if ( ! newSize ) {
	return;
    }
    cell = $( opt ).closest( 'td' );
    galId = $( cell ).attr( 'id' ).replace( 'fsgEdit' , '' );
    $( cell ).empty().html( '<img src="' + absolutePaths.homeUrl + '/wp-admin/images/wpspin_light.gif" />');
    $.getJSON( absolutePaths.ajaxUrl , { action : 'admin_edit_fsg' , gal_id : galId,gal_size : newSize } ,
	      function( data ) {
		    if ( ! data.success ) {
			prevMess = $( 'div#message' );
			if ( prevMess ) { $( prevMess ).remove(); }
		        $( 'div#fsg_header' ).append( '<div id="message" class="error fade"><p>Sorry, something went wrong!</p></div>' );
		    } else {
			prevMess = $( 'div#message' );
			if ( prevMess ) { $( prevMess ).remove(); }
		    }
		    reset( $ , data.gallery , data.gal_size );
		});
}

function reset( $ , galId , galSize ) {
    //update table cell
    var sizeName = '';
    var wi = '';
    var he = '';
    switch ( galSize ) {
	case 'sm':
	    sizeName = 'Small (400x300)';
	    wi = 400;
	    he = 300;
	break;
	case 'me':
	    sizeName = 'Medium (500x375)';
	    wi = 500;
	    he = 375;
	break;
	case 'la':
	    sizeName = 'Large (700x525)';
	    wi = 700;
	    he = 525;
	break;
	case 'su':
	    sizeName = 'Super-sized (800x600)';
	    wi = 800;
	    he = 600;
	break;
    }
    changeLink = $( '<a class="editFsgLink" href="' + absolutePaths.ajaxUrl + '">change size</a>');
    changeLink.click( function( event ) {
	    bindEditSizeEvent( event , this , $ );
	});
    $( 'td#fsgEdit' + galId ).html( sizeName + '<br />' ).append( changeLink );
    changeLink.wrap( '<span class="fsg_edit"></span>' );
    //update preview
    var obj = $( 'tr#fsg-' + galId + ' p object' );
    var emb = $(obj).find('embed');
    $( obj ).attr( { width : wi , height : he } );
    $( emb ).attr( { width : wi , height : he } );
}

function bindEditSizeEvent( e , tar , $ ) {
	e.preventDefault();
	tableCell = $( tar ).closest( 'td' );
	tableCell.html( '<img src="' + absolutePaths.homeUrl + '/wp-admin/images/wpspin_light.gif" />');
	selectSize = document.createElement( 'select' );
	options = $( '<option value="">--Select size--</option><option value="sm">Small (400x300)</option><option value="me">Medium (500x375)</option><option value="la">Large (700x525)</option><option value="su">Super-sized (800x600)</option>' );
	$( selectSize ).append( options );
	$( selectSize ).change( function() {
		sizeSelected( this , $ );
	});
	tableCell.empty().append( selectSize );
}