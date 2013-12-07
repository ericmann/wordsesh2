/**
 * WordSesh Demo
 * http://wordpress.org/plugins
 *
 * Copyright (c) 2013 Eric Mann
 * Licensed under the GPLv2+ license.
 */

/*global jQuery */
( function( window, $, undefined ) {
	'use strict';

	var document = window.document,
		CORE = window.wordsesh,
		quoteEl = document.getElementById( 'wordsesh_quote' ), $quoteEl = $( quoteEl );

	$( document.getElementById( 'wordsesh_quote_refresh' ) ).on( 'click', function( e ) {
		e.preventDefault();

		$.ajax( {
			'url': CORE.ajaxurl,
			'type': 'POST',
			'data': {
				'action': 'wordsesh_quote_refresh'
			},
			'dataType': 'html',
			'success': function ( data ) {
				$quoteEl.html( data );
			}
		} );
	} );

} )( this, jQuery );














/*global jQuery */
( function( window, $, undefined ) {
	'use strict';

	var document = window.document,
		CORE = window.wordsesh,
		container = document.getElementById( 'wordsesh_form' ), $container = $( container ),
		formEl = document.getElementById( 'wordsesh_form_inner' ), $formEl = $( formEl );

	$formEl.on( 'submit', function( e ) {
		e.preventDefault();

		var data = {
			'action': 'wordsesh_form_submit',
			'wordsesh_submit': 'true',
			'wordsesh_title': document.getElementById( 'wordsesh_title' ).value,
			'wordsesh_topic': document.getElementById( 'wordsesh_topic' ).value
		};

		$.ajax( {
			'url': CORE.ajaxurl,
			'type': 'POST',
			'data': data,
			'dataType': 'html',
			'success': function ( data ) {
				$container.html( data );
			}
		} );
	} );
} )( this, jQuery );