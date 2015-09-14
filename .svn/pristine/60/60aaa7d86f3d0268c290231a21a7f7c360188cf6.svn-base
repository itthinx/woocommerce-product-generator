/**
 * product-generator.js
 *
 * Copyright (c) 2014 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author itthinx
 * @package woocommerce-product-generator
 * @since 1.0.0
 */

var ixprogen = {
	running : false,
	generating : false,
	timeout : null,
	limit : null
};

/**
 * Post generator query.
 */
ixprogen.generate = function() {

	if ( typeof args === "undefined" ) {
		args = {};
	}

	var $status = jQuery( "#product-generator-status" ),
		$update = jQuery( "#product-generator-update" ),
		$blinker = jQuery( "#product-generator-blinker" );

	$blinker.addClass( 'blinker' );
	$status.html('<p>Generating</p>' );
	if ( !ixprogen.generating ) {
		ixprogen.generating = true;
		jQuery.ajax({
				type : 'POST',
				url  : ixprogen.url,
				data : { "action" : "product_generator", "nonce" : ixprogen.nonce },
				complete : function() {
					ixprogen.generating = false;
					$blinker.removeClass('blinker');
				},
				success : function ( data ) {
					if ( typeof data.total !== "undefined" ) {
						$update.html( '<p>Total Products: ' + data.total + '</p>' );
						if ( ixprogen.limit !== null ) {
							if ( data.total >= ixprogen.limit ) {
								ixprogen.stop();
							}
						}
					}
				},
				dataType : "json"
		});
	}
};

ixprogen.start = function( url, nonce ) {
	if ( !ixprogen.running ) {
		ixprogen.running = true;
		ixprogen.url = url;
		ixprogen.nonce = nonce;
		ixprogen.exec();
		var $status = jQuery( "#product-generator-status" );
		$status.html( '<p>Running</p>' );
	}
};

ixprogen.exec = function() {
	ixprogen.timeout = setTimeout(
		function() {
			if ( ixprogen.running ) {
				if ( !ixprogen.generating ) {
					ixprogen.generate();
				}
				ixprogen.exec();
			}
		},
		1000
	);
};

ixprogen.stop = function() {
	if ( ixprogen.running ) {
		ixprogen.running = false;
		clearTimeout( ixprogen.timeout );
		var $status = jQuery( "#product-generator-status" );
		$status.html( '<p>Stopped</p>' );
	}
};
