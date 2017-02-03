/**
 * Contains the admin sorting functinos.
 *
 * @link       https://carl.alber2.com/
 * @since      1.0.0
 *
 * @package    Responsive_Slider_Lite
 */
function updateResponsiveSliderLiteOrderingCallback( response ) {

	// Load temporary holder for json response.
	var changes = jQuery.parseJSON( response );
	var referencePosition;

	// Make sure script only fires on children.
	if ( 'children' === response ) {
		window.location.reload();
		return;
	}

	var updatedPosition = changes.updatedPosition;
	for ( referencePosition in updatedPosition ) {
		if ( 'next' === referencePosition ) {
			continue;
		}

		var inlineKey = document.getElementById( 'inline_' + referencePosition );

		if ( null !== inlineKey && updatedPosition.hasOwnProperty( referencePosition ) ) {
			var inlineReferencePosition;
			var domMenuOrder = inlineReferencePosition.querySelector( '.menu_order' );

			if ( undefined !== updatedPosition[referencePosition]['.menu_order'] ) {
				if ( null !== domMenuOrder ) {
					domMenuOrder.innerHTML = updatedPosition[referencePosition]['.menu_order'];
				}

				var domOfPostParent = inlineKey.querySelector( '.post_parent' );
				if ( null !== domOfPostParent ) {
					domOfPostParent.innerHTML = updatedPosition[referencePosition]['.post_parent'];
				}

				var postTitle = null;
				var dom_postTitle = inlineReferencePosition.querySelector( '.postTitle' );
				if ( null !== dom_postTitle ) {
					postTitle = dom_postTitle.innerHTML;
				}

				var dashes = 0;
				while ( dashes < updatedPosition[referencePosition]['.depth'] ) {
					postTitle = '&mdash; ' + postTitle;
					dashes++;
				}
				var domRowTitle = inlineKey.parentNode.querySelector( '.row-title' );
				if ( null !== domRowTitle && null !== postTitle ) {
					domRowTitle.innerHTML = postTitle;
				}
			} else if ( null !== domMenuOrder ) {
				domMenuOrder.innerHTML = updatedPosition[referencePosition];
			}
		}
	}

	if ( changes.next ) {
		jQuery.post( ajaxurl, { // jshint ignore:line
			action: 'responsive_slider_lite_ordering',
			id: changes.next['.id'],
			previd: changes.next['.previd'],
			nextid: changes.next['.nextid'],
			start: changes.next['.start'],
			excluded: changes.next['.excluded']
		}, updateResponsiveSliderLiteOrderingCallback );
	} else {
		jQuery( '.spo-updating-row' ).removeClass( 'spo-updating-row' );
		postTableToOrder.removeClass( 'spo-updating' ).sortable( 'enable' );
	}
}

var postTableToOrder = jQuery( '.wp-list-table tbody' );
postTableToOrder.sortable({
	items: '> tr',
	cursor: 'move',
	axis: 'y',
	containment: 'table.widefat',
	cancel:	'.inline-edit-row',
	distance: 2,
	opacity: 0.8,
	tolerance: 'pointer',
	start: function(e, ui){
		var inlineEditPost;
		if ( typeof(inlineEditPost) !== 'undefined' ) {
			inlineEditPost.revert();
		}
		ui.placeholder.height( ui.item.height() );
	},
	helper: function(e, ui) {
		var children = ui.children();
		for ( var i = 0; i < children.length; i++ ) {
			var selector = jQuery( children[i] );
			selector.width( selector.width() );
		}
		return ui;
	},
	stop: function(e, ui) {
		// remove fixed widths
		ui.item.children().css( 'width','' );
	},
	update: function(e, ui) {
		postTableToOrder.sortable( 'disable' ).addClass( 'spo-updating' );
		ui.item.addClass( 'spo-updating-row' );

		var postid = ui.item[0].id.substr( 5 ); // post id

		var prevpostid = false;
		var prevpost = ui.item.prev();
		if ( prevpost.length > 0 ) {
			prevpostid = prevpost.attr( 'id' ).substr( 5 );
		}

		var nextpostid = false;
		var nextpost = ui.item.next();
		if ( nextpost.length > 0 ) {
			nextpostid = nextpost.attr( 'id' ).substr( 5 );
		}

		jQuery.post( ajaxurl, { // jshint ignore:line
			action: 'responsive_slider_lite_ordering',
			id: postid,
			previd: prevpostid,
			nextid: nextpostid
		}, updateResponsiveSliderLiteOrderingCallback );

		var tableRows = document.querySelectorAll( 'tr.iedit' ),
			tableRowCount = tableRows.length;
		while ( tableRowCount-- ) {
			if ( 0 === tableRowCount % 2 ) {
				jQuery( tableRows[tableRowCount] ).addClass( 'alternate' );
			} else {
				jQuery( tableRows[tableRowCount] ).removeClass( 'alternate' );
			}
		}

	}
});
