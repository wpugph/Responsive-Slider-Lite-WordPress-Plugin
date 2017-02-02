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
	for (  referencePosition in updatedPosition ) {
		if ( 'next' === referencePosition ) {
			continue;
		}

		var inlineKey = document.getElementById( 'inline_' + referencePosition );

		if ( null !== inlineKey && updatedPosition.hasOwnProperty( referencePosition ) ) {
			var inline_referencePosition;
			var dom_menu_order = inline_referencePosition.querySelector( '.menu_order' );

			if ( undefined !== updatedPosition[referencePosition]['.menu_order'] ) {
				if ( null !== dom_menu_order ) {
					dom_menu_order.innerHTML = updatedPosition[referencePosition]['.menu_order'];
				}

				var dom_of_post_parent = inlineKey.querySelector( '.post_parent' );
				if ( null !== dom_of_post_parent ) {
					dom_of_post_parent.innerHTML = updatedPosition[referencePosition]['.post_parent'];
				}

				var post_title = null;
				var dom_post_title = inline_referencePosition.querySelector( '.post_title' );
				if ( null !== dom_post_title ) {
					post_title = dom_post_title.innerHTML;
				}

				var dashes = 0;
				while ( dashes < updatedPosition[referencePosition]['.depth'] ) {
					post_title = '&mdash; ' + post_title;
					dashes++;
				}
				var dom_row_title = inlineKey.parentNode.querySelector( '.row-title' );
				if ( null !== dom_row_title && null !== post_title ) {
					dom_row_title.innerHTML = post_title;
				}
			} else if ( null !== dom_menu_order ) {
				dom_menu_order.innerHTML = updatedPosition[referencePosition];
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

var post_table_to_order = jQuery( '.wp-list-table tbody' );
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
