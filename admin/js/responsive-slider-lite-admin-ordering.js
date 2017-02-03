/**
 * JS to render the drag and drop feature of the images.
 */
function updateResponsiveSliderLiteOrderingCallback( response ) {

	// Load temporary holder for json response.
	var changes = jQuery.parseJSON( response );
	var referencePosition;
	var updatedPosition;
	var inlineKey;
	var inline_referencePosition;
	var domMenuOrder;
	var postTitle = null;
	var domOfPostParent;
	var dom_postTitle;
	var dashes = 0;
	var domRowTitle;
	varv post_table_to_order;

	// Make sure script only fires on children.
	if ( 'children' === response ) {
		window.location.reload();
		return;
	}

	updatedPosition = changes.updatedPosition;
	for (  referencePosition in updatedPosition ) {
		if ( 'next' === referencePosition ) {
			continue;
		}

		inlineKey = document.getElementById( 'inline_' + referencePosition );

		if ( null !== inlineKey && updatedPosition.hasOwnProperty( referencePosition ) ) {

			domMenuOrder = inline_referencePosition.querySelector( '.menu_order' );

			if ( undefined !== updatedPosition[referencePosition]['.menu_order'] ) {
				if ( null !== domMenuOrder ) {
					domMenuOrder.innerHTML = updatedPosition[referencePosition]['.menu_order'];
				}

				domOfPostParent = inlineKey.querySelector( '.post_parent' );
				if ( null !== domOfPostParent ) {
					domOfPostParent.innerHTML = updatedPosition[referencePosition]['.post_parent'];
				}

				dom_postTitle = inline_referencePosition.querySelector( '.postTitle' );
				if ( null !== dom_postTitle ) {
					postTitle = dom_postTitle.innerHTML;
				}

				while ( dashes < updatedPosition[referencePosition]['.depth'] ) {
					postTitle = '&mdash; ' + postTitle;
					dashes++;
				}
				domRowTitle = inlineKey.parentNode.querySelector( '.row-title' );
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
		post_table_to_order.removeClass( 'spo-updating' ).sortable( 'enable' );
	}
}

post_table_to_order = jQuery( '.wp-list-table tbody' );
post_table_to_order.sortable({
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
		post_table_to_order.sortable( 'disable' ).addClass( 'spo-updating' );
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

		var table_rows = document.querySelectorAll( 'tr.iedit' ),
			table_row_count = table_rows.length;
		while ( table_row_count-- ) {
			if ( 0 === table_row_count % 2 ) {
				jQuery( table_rows[table_row_count] ).addClass( 'alternate' );
			} else {
				jQuery( table_rows[table_row_count] ).removeClass( 'alternate' );
			}
		}

	}
});
