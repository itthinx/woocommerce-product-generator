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
	limit : null,
	gendata : {
		total : 0,
		simple : 0,
		variable : 0,
		variation : 0,
		time : 0.0
	}
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
	$status.html('<p>' + WC_Product_Generator.generating + '</p>' );
	if ( !ixprogen.generating ) {
		ixprogen.generating = true;
		jQuery.ajax({
				type : 'POST',
				url  : WC_Product_Generator.ajax_url,
				data : { "action" : "product_generator", "nonce" : ixprogen.nonce },
				complete : function() {
					ixprogen.generating = false;
					$blinker.removeClass('blinker');
				},
				success : function ( data ) {
					if ( typeof data.total !== "undefined" ) {

						ixprogen.gendata.total = data.total; // not cumulative
						ixprogen.gendata.simple += data.simple;
						ixprogen.gendata.variable += data.variable;
						ixprogen.gendata.variation += data.variation;
						ixprogen.gendata.time += data.time;

						text = '<div style="margin: 16px 0;">';
						text += WC_Product_Generator.total.replace( "%d", ixprogen.gendata.total );
						text += '</div>';
						text += '<div style="margin: 16px 0;">';
						text += '<strong>' + WC_Product_Generator.generation_stats + '</strong>';
						text += '</div>';
						text += '<div id="ixprogen-stats-container" style="display: grid; grid-template-columns: 10% 10% 10% 10% 15% auto; grid-column-gap: 24px;">';
						text += '<div>';
						text += WC_Product_Generator.stats_simple.replace( "%d", ixprogen.gendata.simple );
						text += '</div>';
						text += '<div>';
						text += WC_Product_Generator.stats_variable.replace( "%d", ixprogen.gendata.variable );
						text += '</div>';
						text += '<div>';
						text += WC_Product_Generator.stats_variations.replace( "%d", ixprogen.gendata.variation );
						text += '</div>';
						text += '<div>';
						text += WC_Product_Generator.stats_sum.replace( "%d", ixprogen.gendata.simple + ixprogen.gendata.variable + ixprogen.gendata.variation );
						text += '</div>';
						text += '<div>';
						text += WC_Product_Generator.stats_time.replace( "%s", ixprogen.gendata.time.toFixed(2) );
						text += '</div>';
						text += '<div>';
						var pps = ixprogen.gendata.time > 0.0 ? ( ixprogen.gendata.simple + ixprogen.gendata.variable + ixprogen.gendata.variation ) / ixprogen.gendata.time : 0.0;
						text += WC_Product_Generator.stats_pps.replace( "%s", pps.toFixed(3) );
						text += '</div>';
						text += '</div>';

						if ( ixprogen.limit !== null ) {
							if ( data.total >= ixprogen.limit ) {
								ixprogen.stop();
								text += '<div style="margin: 16px 0;">';
								text += '<strong>' + WC_Product_Generator.limit_reached + '</strong>';
								text += '</div>';
							}
						}

						$update.html( '<div>' + text + '</div>' );
					}
				},
				dataType : "json"
		});
	}
};

ixprogen.start = function() {
	if ( !ixprogen.running ) {
		ixprogen.running = true;
		ixprogen.nonce = WC_Product_Generator.js_nonce;
		ixprogen.exec();
		var $status = jQuery( "#product-generator-status" );
		$status.html( '<p>' + WC_Product_Generator.running + '</p>' );
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
		$status.html( '<p>' + WC_Product_Generator.stopped + '</p>' );
	}
};

jQuery(document).ready(function($){
	ixprogen.limit = WC_Product_Generator.limit;
	if ( typeof ixprogen_updated_limit !== 'undefined' ) {
		ixprogen.limit = ixprogen_updated_limit;
	}

	$("#product-generator-run").on( 'click', function(e){
		e.stopPropagation();
		ixprogen.start();
	});

	$("#product-generator-stop").on( 'click', function(e){
		e.stopPropagation();
		ixprogen.stop();
	});

}); // ready
