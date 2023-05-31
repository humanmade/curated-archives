/**
 * Create Post using AJAX
 */

/**
 * Initialize
 */
const initialize = () => {
	let makeButtons = document.querySelectorAll( '.js-make-curated-archive' );

	if ( makeButtons.length === 0 ) {
		return;
	}

	if ( makeButtons[0].classList.contains( 'js-type-admin-bar' ) ) {
		makeButtons = makeButtons[0].querySelector( '.ab-item' );
		clickEvent( makeButtons, true );
	} else {
		makeButtons.forEach( makeButton => {
			clickEvent( makeButton );
		} );
	}
};

/**
 * Handle click of different Make Curated Archive Buttons - whether direct click or parent node.
 *
 * @param {object} makeButton - The Node in which to run the click on
 * @param {boolean} parent - Whehther or not to select the parent of the original node
 */
const clickEvent = ( makeButton, parent = false ) => {
	makeButton.addEventListener( 'click', ev => {
		ev.preventDefault();

		let elClassName = ev.target.classList[0];
		if ( parent ) {
			elClassName = ev.target.parentNode.classList[0];
		}

		createCuratedArchivePost( elClassName.replace( 'term-id-', '' ) );
	} );
};

/**
 * AJAX call to Create Curated Archive Post
 *
 * @param {boolean} termId - ID of TERM
 */
const createCuratedArchivePost = termId => {
	const data = new FormData();
	data.append( 'action', 'create_curated_archive_post' );
	data.append( 'nonce', window.curated_archive_vars.ajax_nonce_curated_post );
	data.append( 'term_id', termId );

	fetch( window.curated_archive_vars.ajax_url, {
		method: 'POST',
		credentials: 'same-origin',
		body: data,
	} )
		.then( response => response.json() )
		.then( data => {
			window.location.href = data;
		} )
		.catch( error => {
			alert( 'Sorry, there was a problem creating the curated archive. The error is: ' + error );
		} );
};


window.addEventListener( 'DOMContentLoaded', () => {
	initialize();
} );
