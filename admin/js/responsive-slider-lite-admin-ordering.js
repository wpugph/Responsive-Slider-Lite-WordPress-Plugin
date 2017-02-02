function update_responsive_slider_lite_ordering_callback(response) {
	//load temporary holder for json response
	var changes = jQuery.parseJSON( response );
	//make sure script only fires on children
	if ( 'children' === response ) {
		window.location.reload();
		return;
	}

	var updated_position = changes.updated_position;
	for ( var reference_position in updated_position ) {
		if ( 'next' === reference_position ) {
			continue;
		}

		var inline_key = document.getElementById('inline_' + reference_position);

		if ( null !== inline_key && updated_position.hasOwnProperty(reference_position) ) {
			var dom_menu_order = inline_reference_position.querySelector('.menu_order');

			if ( undefined !== updated_position[reference_position]['.menu_order'] ) {
				if ( null !== dom_menu_order ) {
					dom_menu_order.innerHTML = updated_position[reference_position]['.menu_order'];
				}

				var dom_of_post_parent = inline_key.querySelector('.post_parent');
				if ( null !== dom_of_post_parent ) {
					dom_of_post_parent.innerHTML = updated_position[reference_position]['.post_parent'];
				}

				var post_title = null;
				var dom_post_title = inline_reference_position.querySelector('.post_title');
				if ( null !== dom_post_title ) {
					post_title = dom_post_title.innerHTML;
				}

				var dashes = 0;
				while ( dashes < updated_position[reference_position]['.depth'] ) {
					post_title = '&mdash; ' + post_title;
					dashes++;
				}
				var dom_row_title = inline_key.parentNode.querySelector('.row-title');
				if ( null !== dom_row_title && null !== post_title ) {
					dom_row_title.innerHTML = post_title;
				}
			} else if ( null !== dom_menu_order ) {
				dom_menu_order.innerHTML = updated_position[reference_position];
			}
		}
	}

	if ( changes.next ) {
		jQuery.post( ajaxurl, {
			action: 'responsive_slider_lite_ordering',
			id: changes.next['.id'],
			previd: changes.next['.previd'],
			nextid: changes.next['.nextid'],
			start: changes.next['.start'],
			excluded: changes.next['.excluded']
		}, update_responsive_slider_lite_ordering_callback );
	} else {
		jQuery('.spo-updating-row').removeClass('spo-updating-row');
		post_table_to_order.removeClass('spo-updating').sortable('enable');
	}
}

var post_table_to_order = jQuery('.wp-list-table tbody');
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
		if ( typeof(inlineEditPost) !== 'undefined' ) {
			inlineEditPost.revert();
		}
		ui.placeholder.height(ui.item.height());
	},
	helper: function(e, ui) {
		var children = ui.children();
		for ( var i=0; i<children.length; i++ ) {
			var selector = jQuery(children[i]);
			selector.width( selector.width() );
		}
		return ui;
	},
	stop: function(e, ui) {
		// remove fixed widths
		ui.item.children().css('width','');
	},
	update: function(e, ui) {
		post_table_to_order.sortable('disable').addClass('spo-updating');
		ui.item.addClass('spo-updating-row');

		var postid = ui.item[0].id.substr(5); // post id

		var prevpostid = false;
		var prevpost = ui.item.prev();
		if ( prevpost.length > 0 ) {
			prevpostid = prevpost.attr('id').substr(5);
		}

		var nextpostid = false;
		var nextpost = ui.item.next();
		if ( nextpost.length > 0 ) {
			nextpostid = nextpost.attr('id').substr(5);
		}

		jQuery.post( ajaxurl, { action: 'responsive_slider_lite_ordering', id: postid, previd: prevpostid, nextid: nextpostid }, update_responsive_slider_lite_ordering_callback );

		var table_rows = document.querySelectorAll('tr.iedit'),
			table_row_count = table_rows.length;
		while( table_row_count-- ) {
			if ( 0 === table_row_count%2 ) {
				jQuery(table_rows[table_row_count]).addClass('alternate');
			} else {
				jQuery(table_rows[table_row_count]).removeClass('alternate');
			}
		}

	}
});
