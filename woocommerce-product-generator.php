<?php
/**
 * woocommerce-product-generator.php
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
 *
 * Plugin Name: WooCommerce Product Generator
 * Plugin URI: http://www.itthinx.com/
 * Description: A sample product generator for WooCommerce.
 * Version: 1.0.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * License: GPLv3
 */

define( 'WOOPROGEN_PLUGIN_DOMAIN', 'woocommerce-product-generator' );

/**
 * Product Generator.
 */
class WooCommerce_Product_Generator {

	const IMAGE_WIDTH = 512;
	const IMAGE_HEIGHT = 512;

	const DEFAULT_LIMIT = 10;

	const DEFAULT_TITLES =
'
ACME
Banana
Apple
Carrot
Tomato
Potato
Soy
Strawberry
Pumpkin
Juice
iPhone
Mac
Galaxy
Album
Jazz
Samsung
Motorola
Egg
Shampoo
Shower
Gel
Moustache
Bikini
Towel
Cool
CD
DVD
Movie
Shoe
Dress
Trouser
Knife
Doll
Download
Video
Book
Sword
Ring
Card
Princess
Prince
Car
Toy
Fire
HDMI
TV
Player
Film
Gift
Wet
Gun
Water
Beverage
Cola
Smoothie
Washer
Oven
Refrigerator
Internet
Heater
Cooler
Cleaner
Fish
Meat
Hair
Lotion
Mixer
Blender
Diamond
Perl
Thermal
Rooster
Chicken
Lamb
Hot
Cold
Microwave
Natural
Wood
Plastic
Chair
Table
Cover
Sheet
Bed
Cushion
Seat
Bike
Kit
Gold
Silver
Brass
';

	const DEFAULT_CONTENTS = '
Lorem Ipsum Dolor Sit Amet
Sed ut perspiciatis unde omnis iste natus error sit voluptatem.
Do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque.
Nisi ut aliquid ex ea commodi consequatur?
Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam.
Do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Nisi ut aliquid ex ea commodi consequatur?
Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam.
Corrupti quos dolores et quas molestias excepturi sint occaecati.
Itaque earum rerum hic tenetur a sapiente delectus.
Non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.

You mean it controls your actions?
Partially, but it also obeys your commands. What?!
I suggest you try it again, Luke.
This time, let go your conscious self and act on instinct.
Escape is not his plan.
I must face him, alone.
I\'m surprised you had the courage to take the responsibility yourself.
Don\'t act so surprised, Your Highness.
You weren\'t on any mercy mission this time.
Several transmissions were beamed to this ship by Rebel spies.
I want to know what happened to the plans they sent you.
But with the blast shield down, I can\'t even see!
How am I supposed to fight?
I want to come with you to Alderaan.
There\'s nothing for me here now.
I want to learn the ways of the Force and be a Jedi, like my father before me.
Obi-Wan is here.
The Force is with him.
I need your help, Luke.
She needs your help.
I\'m getting too old for this sort of thing.
I\'m surprised you had the courage to take the responsibility yourself.
Don\'t act so surprised, Your Highness.
You weren\'t on any mercy mission this time.
Several transmissions were beamed to this ship by Rebel spies.
I want to know what happened to the plans they sent you.
Hokey religions and ancient weapons are no match for a good blaster at your side, kid.
You\'re all clear, kid.
Let\'s blow this thing and go home!
As you wish.
I want to come with you to Alderaan.
There\'s nothing for me here now.
I want to learn the ways of the Force and be a Jedi, like my father before me.
What?!
What good is a reward if you ain\'t around to use it?
Besides, attacking that battle station ain\'t my idea of courage.
It\'s more like ... suicide.
Ye-ha!

The swallow may fly south with the sun, and the house martin or the plover may seek warmer climes in winter, yet these are not strangers to our land.
On second thoughts, let\'s not go there.
It is a silly place.
Why do you think that she is a witch?
The Knights Who Say Ni demand a sacrifice!
Strange women lying in ponds distributing swords is no basis for a system of government.
Supreme executive power derives from a mandate from the masses, not from some farcical aquatic ceremony.
It\'s only a model.
What do you mean?
The nose?

All I want is to be a monkey of moderate intelligence who wears a suit ... that\'s why I\'m transferring to business school!
Shut up and get to the point!
No!
Don\'t jump!
The kind with looting and maybe starting a few fires!
In your time, yes, but nowadays shut up!
Besides, these are adult stemcells, harvested from perfectly healthy adults whom I killed for their stemcells.
It\'s just like the story of the grasshopper and the octopus.
All year long, the grasshopper kept burying acorns for winter, while the octopus mooched off his girlfriend and watched TV.

While their products leave much to be desired, Acme delivery service is second to none;
Wile E. can merely drop an order into a mailbox (or enter an order on a website, as in the Looney Tunes: Back in Action movie), and have the product in his hands within seconds.
The name Acme became popular for businesses by the 1920s, when alphabetized business telephone directories such as the Yellow Pages began to be widespread.

A battery, providing the power source for the phone functions.
An input mechanism to allow the user to interact with the phone.
The most common input mechanism is a keypad, but touch screens are also found in some high-end smartphones.
A screen which echoes the user\'s typing, displays text messages, contacts and more.
Basic mobile phone services to allow users to make calls and send text messages.
All GSM phones use a SIM card to allow an account to be swapped among devices.
Some CDMA devices also have a similar card called a R-UIM.
Individual GSM, WCDMA, iDEN and some satellite phone devices are uniquely identified by an International Mobile Equipment Identity (IMEI) number.
FooPhone is an attempt to develop a mobile phone which contains only Foo.

Caution! May contain Peanuts!

In common language usage, "fruit" normally means the fleshy seed-associated structures of a plant that are sweet or sour and edible in the raw state, such as apples, oranges, grapes, strawberries, bananas, and lemons.
On the other hand, the botanical sense of "fruit" includes many structures that are not commonly called "fruits", such as bean pods, corn kernels, wheat grains, and tomatoes.

Some vegetables also contain fiber, important for gastrointestinal function.
Vegetables contain important nutrients necessary for healthy hair and skin as well.
A person who refrains from dairy and meat products, and eats only plants (including vegetables) is known as a vegan.
Some vegetables can be consumed raw, while some, such as cassava, must be cooked to destroy certain natural toxins or microbes in order to be edible.
A number of processed food items available on the market contain vegetable ingredients and can be referred to as "vegetable derived" products.
These products may or may not maintain the nutritional integrity of the vegetable used to produce them.
Of all the world\'s nations, China is the leading cultivator of vegetables, with top productions in potato, onions, cabbage, lettuce, tomatoes and broccoli.
The tomato is consumed in diverse ways, including raw, as an ingredient in many dishes, sauces, salads, and drinks.
While it is botanically a fruit, it is considered a vegetable for culinary purposes (as well as under U.S. customs regulations, see Nix v. Hedden), which has caused some confusion.
The fruit is rich in lycopene, which may have beneficial health effects.

iPhone is a line of smartphones designed and marketed by Apple Inc.
It runs Apple\'s iOS mobile operating system.
The first generation iPhone was released on June 29, 2007; the most recent iPhones, the seventh-generation iPhone 5C and iPhone 5S, were introduced on September 10, 2013.
The MacBook Pro is a line of Macintosh portable computers introduced in January 2006 by Apple Inc., and now in its third generation.
Replacing the PowerBook G4, the MacBook Pro was the second model, after the iMac, to be announced in the Apple-Intel transition.
It is also the high-end model of the MacBook family and is currently produced with 13- and 15-inch screens, although a 17-inch version has been offered previously.

';
	
	const DEFAULT_CATEGORIES = 'Action Figures
All Action Figures
Accessories
Animals
Collectibles
Military Figures
Playsets
Police, Fire & Rescue Figures
Political Figures
Robots
Science Fiction & Fantasy Figures
Sports Figures
Statues, Maquettes & Busts
Activities & Amusements
All Activities & Amusements
Bath Toys
Bubbles
Drawing Tablet Toys
Finger Puppets
Finger Toys
Flying Toys
Fortunetelling Toys
Gags & Practical Jokes
Glow in the Dark Toys
Inflatable Toys
Juggling Sets
Light-Up Toys
Magnets
Miniatures & Keychains
Nesting Dolls
Noisemakers
Novelty Games
Popping & Jumping Toys
Prisms & Kaleidoscopes
Slime & Putty Toys
Spinning Tops
Spring & Wind-up Toys
Temporary Tattoos
Toy Balls
Viewfinders
Water Toys
Yo-yos
Arts & Crafts
All Arts & Crafts
Aprons & Smocks
Art Supply Sets & Kits
Beads & Jewelry
Chalk & Chalkboards
Clay, Dough & Pottery
Craft Kits
Crayons
Drawing & Sketch Pads
Drawing & Sketching Tablets
Dry Erase Markers & Boards
Easels
Glue, Paste & Tape
Paintbrushes
Paints
Paper
Pencils & Erasers
Pens & Markers
Scissors
Sharpeners
Stamps & Stickers
Bikes, Skates & Ride-Ons
All Bikes, Skates & Ride-Ons
Bikes
Skates
Skateboards
Scooters
Ride-On Toys
Safety Equipment
Construction, Blocks & Models
All Construction, Blocks & Models
Blocks
Building Sets
Construction & Models
Dolls
All Dolls
Accessories
Baby Dolls
Dollhouses
Ethnic Dolls
Fashion Dolls
Interactive Dolls
Playsets
Porcelain Dolls
Rag Dolls
Toddler Dolls
Electronics for Kids
All Electronics for Kids
Alarm Clocks
Arcade Games
Audio & Video Players
Cameras
Electronic Pets
Handheld Games
Learning & Education
Lighting & Light Makers
Organizers & PDA\'s
Personal Video Players & Accessories
Play Laptops & Notebooks
Plug & Play Video Games
RC Figures & Robots
Safes & Security Devices
Spy Gadgets
TVs
Telephones
Virtual Reality
Walkie Talkies
Watches
Games
All Games
Accessories
Action & Reflex Games
Backyard Games
Battling Tops
Board Games
Card Games
Casino Games
Checkers, Chess & Backgammon
Classic Games
DVD Games
Dice & Marble Games
Dominoes & Tile Games
Educational Games
Electronic
Floor Games
Foreign Language Games
Game Room Games
Hasbro Games
Mystery Games
Religious Games
Sports Games
Stacking Games
Travel Games
TV Games
Variety Game Sets
Hobbies
All Hobbies
Coin Collecting
Die-Cast
Hobby Tools
Models
Radio Control
Rockets
Science
Sports Trading Cards
Trains
Kids\' Furniture & Room Décor
All Kids\' Furniture & Room Décor
Activity & Sensory Tables
Bedroom Furniture
Chairs & Sofas
Desks
Outdoor Furniture
Room Décor
Step Stools
Tables
Tents & Tunnels
Toy Chests & Storage
Learning & Exploration
All Learning & Exploration
Early Development Toys
Electronic Learning
Foreign Languages
Geography & Globes
History
Math & Counting
Reading & Writing
Science
Music
All Music
Dance Mats
Karaoke
Musical Instruments
Radio & CD Players
Party Supplies
All Party Supplies
Cake Supplies
Decorations
Favors
Hats
Invitations & Cards
Party Games & Crafts
Party Packs
Piñatas
Tableware
Play Vehicles
All Play Vehicles
Boats
Buses
Cars & Playsets
Construction & Farm Vehicles
Emergency Vehicles
Military Vehicles
Motorcycles
Planes & Helicopters
Radio & Remote Control
Spacecraft
Trains & Railway Sets
Trucks & SUV\'s
Vehicle Playsets
Wood Vehicles
Preschool
All Preschool
Baby Toys
Toddler Toys
Pre-Kindergarten Toys
Pretend Play & Dress-up
All Pretend Play & Dress-up
Beauty & Fashion
Costumes
Pretend Electronics
Puppets & Puppet Theaters
Sets
Spy Gear
Puzzles
All Puzzles
Brain Teasers
Floor Puzzles
Foam Puzzles
Jigsaw Puzzles
Storage & Accessories
Travel Puzzles
Wood Puzzles
Sports & Outdoor Play
All Sports & Outdoor Play
Ball Pits & Accessories
Baseball & Softball
Basketball
Boxing
Fishing Combo\'s & Accessories
Fitness Equipment
Football
Golf
Gymnastics
Hockey
Kites & Wind Spinners
Lawn Games
Outdoor Furniture
Play Tents & Tunnels
Playhouses
Pogo Sticks & Hoppers
Pools & Water Fun
Sandbox & Beach
Skateboarding
Slumber Bags
Snow Sports
Soccer
Swings, Gym Sets & Slides
Tennis
Toy Sports
Trampolines & Inflatable Bouncers
Volleyball
Stuffed Animals & Toys
All Stuffed Animals & Toys
Animals
Backpacks & Accessories
Interactive
More Stuffed Toys
Movie & TV
Plush Puppets
Teddy Bears
Toy Figures & Playsets
All Toy Figures & Playsets
Animals
Bendable Figures
Bobble Head Figures
Construction
Fantasy & Adventure
Figure Accessories
Military & Rescue
Miniature Figures
Movie & TV
Playsets
Vehicles';

	/**
	 * Initialize hooks.
	 */
	public static function init() {
		// register_activation_hook(__FILE__, array( __CLASS__,'activate' ) );
		// register_deactivation_hook(__FILE__,  array( __CLASS__,'deactivate' ) );
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		if ( is_admin() ) {
			add_filter( 'plugin_action_links_'. plugin_basename( __FILE__ ), array( __CLASS__, 'admin_settings_link' ) );
		}
	}

	/**
	 * Does nothing for now.
	 */
	public static function activate() {
	}

	/**
	 * Does nothing for now.
	 */
	public static function deactivate() {
	}

	/**
	 * Add the Generator menu item.
	 */
	public static function admin_menu() {
		if ( self::woocommerce_is_active() ) {
			add_submenu_page(
				'woocommerce',
				'Product Generator',
				'Product Generator',
				'manage_woocommerce',
				'product-generator',
				array( __CLASS__, 'generator' )
			);
		}
	}

	/**
	 * Adds plugin links.
	 *
	 * @param array $links
	 * @param array $links with additional links
	 */
	public static function admin_settings_link( $links ) {
		if ( self::woocommerce_is_active() ) {
			$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=product-generator' ) . '">' . __( 'Product Generator', WOOPROGEN_PLUGIN_DOMAIN ) . '</a>';
		}
		return $links;
	}

	public static function generator() {
		if ( !current_user_can( 'manage_woocommerce' ) ) {
			wp_die( __( 'Access denied.', WOOPROGEN_PLUGIN_DOMAIN ) );
		}
		if ( self::woocommerce_is_active() ) {

			if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'save' ) && wp_verify_nonce( $_POST['product-generator'], 'admin' ) ) {
				$limit  = !empty( $_POST['titles'] ) ? intval( trim( $_POST['titles'] ) ) : self::DEFAULT_LIMIT;
				$titles = !empty( $_POST['titles'] ) ? $_POST['titles'] : '';
				$contents = !empty( $_POST['contents'] ) ? $_POST['contents'] : '';

				if ( $limit < 0 ) {
					$limit = self::DEFAULT_LIMIT;
				}
				delete_opption( 'woocommerce-product-generator-limit' );
				add_option( 'woocommerce-product-generator-limit', $limit, null, 'no' );

				delete_opption( 'woocommerce-product-generator-titles' );
				add_option( 'woocommerce-product-generator-title', $titles, null, 'no' );

				delete_opption( 'woocommerce-product-generator-contents' );
				add_option( 'woocommerce-product-generator-contents', $contents, null, 'no' );
			} else if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'generate' ) && wp_verify_nonce( $_POST['product-generate'], 'admin' ) ) {
				$max = isset( $_POST['max'] ) ? intval( $_POST['max'] ) : 0;
				if ( $max > 0 ) {
					for ( $i = 1; $i <= $max ; $i++ ) {
						self::create_product();
					}
				}
			}
			

			$limit = get_option( 'woocommerce-product-generator-limit', self::DEFAULT_LIMIT );
			$titles = stripslashes( get_option( 'woocommerce-product-generator-titles', self::DEFAULT_TITLES ) );
			$contents = stripslashes( get_option( 'woocommerce-product-generator-contents', self::DEFAULT_CONTENTS ) );

			$titles = explode( "\n", $titles );
			sort( $titles );
			$titles = trim( implode( "\n", $titles ) );

			echo '<h1>';
			echo __( 'Product Generator', WOOPROGEN_PLUGIN_DOMAIN );
			echo '</h1>';

			echo '<div class="settings">';
			echo '<form name="settings" method="post" action="">';
			echo '<div>';

			echo '<p>';
			echo '<label>';
			echo __( 'Limit', WOOPROGEN_PLUGIN_DOMAIN );
			echo ' ';
			echo sprintf( '<input type="text" name="limit" value="%d" />', $limit );
			echo '</label>';
			echo '</p>';

			echo '<p>';
			echo '<label>';
			echo __( 'Titles', WOOPROGEN_PLUGIN_DOMAIN );
			echo '<br/>';
			echo '<textarea name="titles" style="height:10em;width:90%;">';
			echo htmlentities( $titles );
			echo '</textarea>';
			echo '</label>';
			echo '</p>';

			echo '<p>';
			echo '<label>';
			echo __( 'Contents', WOOPROGEN_PLUGIN_DOMAIN );
			echo '<br/>';
			echo '<textarea name="contents" style="height:20em;width:90%;">';
			echo htmlentities( $contents );
			echo '</textarea>';
			echo '</label>';
			echo '</p>';

			wp_nonce_field( 'admin', 'product-generator', true, true );

			echo '<div class="buttons">';
			echo sprintf( '<input class="button button-primary" type="submit" name="submit" value="%s" />', __( 'Save', WOOPROGEN_PLUGIN_DOMAIN ) );
			echo '<input type="hidden" name="action" value="save" />';
			echo '</div>';

			echo '</div>';
			echo '</form>';
			echo '</div>';
			
			echo '<div class="generate">';
			echo '<form name="generate" method="post" action="">';
			echo '<div>';
			
			echo '<p>';
			echo '<label>';
			echo __( 'Generate up to &hellip;', WOOPROGEN_PLUGIN_DOMAIN );
			echo ' ';
			echo '<input type="text" name="max" value="1" />';
			echo '</label>';
			echo '</p>';

			wp_nonce_field( 'admin', 'product-generate', true, true );

			echo '<div class="buttons">';
			echo sprintf( '<input class="button button-primary" type="submit" name="submit" value="%s" />', __( 'Run', WOOPROGEN_PLUGIN_DOMAIN ) );
			echo '<input type="hidden" name="action" value="generate" />';
			echo '</div>';

			echo '</div>';
			echo '</form>';
			echo '</div>';

// 			echo '<p>';
// 			echo __( 'Examples based on the above settings &hellip;', WOOPROGEN_PLUGIN_DOMAIN );
// 			echo '</p>';

// 			for ( $i = 0; $i < 3 ; $i++ ) {
// 				echo '<h3>' . self::get_title() . '</h3>';
// 				echo '<div>' . self::get_content() . '</div>';
// 			}
			
// 			$r = wp_upload_bits( 'pupnase.png', null, self::get_image() );
// 			echo '<pre>' . var_export( $r, true ) . '</pre>';
// 			if ( !empty( $r ) && is_array( $r ) && !empty( $r['file'] ) ) {
				
// 			}
// self::create_product();

		}
	}

	public static function create_product() {
		$user_id = self::get_user_id(); 
		$title = self::get_title();
		$i = 0;
		while( ( $i < 99 ) ) {
			if ( get_page_by_title( $title, OBJECT, 'product' ) ) {
				$title .= " " . self::get_title();
			} else {
				break;
			}
			$i++;
		}

		$content = self::get_content();

		$post_id = wp_insert_post( array(
			'post_type' => 'product',
			'post_title' => $title,
			'post_content' => $content,
			'post_status' => 'publish',
			'post_author' => $user_id
		) );
		if ( !( $post_id instanceof WP_Error ) ) {

			// price
			$price = wc_format_decimal( floatval( rand( 1, 10000 ) ) / 100.0 );
			update_post_meta( $post_id, '_price', $price );

			// add categories
			$terms = array();
			$cats = explode( "\n", self::DEFAULT_CATEGORIES );
			$c_n = count( $cats );
			$c_max = rand( 1, 3 );
			for ( $i = 0; $i < $c_max ; $i++ ) {
				$terms[] = $cats[rand( 0, $c_n - 1 )];
			}
			wp_set_object_terms( $post_id, $terms, 'product_cat', true );

			// add tags
			$tags = explode( " ", $title );
			$tags[] = 'progen';
			$potential = explode( " ", $content );
			$n = count( $potential );
			$t_max = rand( 1, 7 );
			for ( $i = 0; $i < $t_max ; $i++ ) {
				$tags[] = preg_replace( "/[^a-zA-Z0-9 ]/", '', $potential[rand( 0, $n-1 )] );
			}
			wp_set_object_terms( $post_id, $tags, 'product_tag', true );

			// product image
			$image = self::get_image();
			$image_name = self::get_image_name();
			$r = wp_upload_bits( $image_name, null, $image );
			if ( !empty( $r ) && is_array( $r ) && !empty( $r['file'] ) ) {
				$filetype = wp_check_filetype( $r['file'] );
				$attachment_id = wp_insert_attachment(
					array(
						'post_title' => $title,
						'post_mime_type' => $filetype['type'],
						'post_status' => 'publish',
						'post_author' => $user_id
					),
					$r['file'],
					$post_id
				);
				if ( !empty( $attachment_id ) ) {
					include_once ABSPATH . 'wp-admin/includes/image.php';
					if ( function_exists( 'wp_generate_attachment_metadata' ) ) {
						$meta = wp_generate_attachment_metadata( $attachment_id, $r['file'] );
						wp_update_attachment_metadata( $attachment_id, $meta );
					}
					update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
				}
			}
		}
	}
	
	public static function get_user_id() {
		$user_id = get_current_user_id();
		$user = get_user_by( 'login', 'product-generator' );
		if ( $user instanceof WP_User ) {
			$user_id = $user->ID;
		} else {
			$maybe_user_id = wp_insert_user( array(
				'user_login' => 'product-generator'
			) );
			if ( !( $maybe_user_id instanceof WP_Error ) ) {
				$user_id = $maybe_user_id;
			}
		}
		return $user_id;
	} 

	public static function get_title( $n_words = 3 ) {
		$titles = trim( stripslashes( get_option( 'woocommerce-product-generator-titles', self::DEFAULT_TITLES ) ) );
		$titles = explode( "\n", $titles );
		$title = array();
		$n = count( $titles );
		$n_words = rand( 1, $n_words );
		for ( $i = 1; $i <= $n_words ; $i++ ) {
			$title[] = $titles[rand( 0, $n - 1 )];
		}
		$title = implode( ' ', $title );
		return $title;
	}
	
	public static function get_content( $n_lines = 10 ) {
		$contents = trim( stripslashes( get_option( 'woocommerce-product-generator-contents', self::DEFAULT_CONTENTS ) ) );
		$contents = explode( "\n", $contents );
		$content = array();
		$n = count( $contents );
		$n_lines = rand( 1, $n_lines );
		for ( $i = 1; $i <= $n_lines ; $i++ ) {
			$content[] = $contents[rand( 0, $n - 1 )];
		}
		$content = "<p>" . implode( "</p><p>", $content ) . "</p>";
		return $content;
	}
	
	public static function get_image() {
		$width = self::IMAGE_WIDTH;
		$height = self::IMAGE_HEIGHT;

		$image = imagecreatetruecolor( $width, $height );
		for( $i = 0; $i <= 11; $i++ ) {
			$x = rand( 0, $width );
			$y = rand( 0, $height );
			$w = rand( 1, $width );
			$h = rand( 1, $height );
			$red = rand( 0, 255 );
			$green = rand( 0, 255 );
			$blue  = rand( 0, 255 );
			$color = imagecolorallocate( $image, $red, $green, $blue );
			imagefilledrectangle(
				$image,
				$x - $w / 2,
				$y - $h / 2,
				$x + $w / 2,
				$y + $h / 2,
				$color
			);
		/*
			imagettftext(
				$image,
				$h,
				0,
				$x,
				$y,
				$white,
				'arial.ttf',
				'Foo'
			);
		*/
		}
		//header('Content-type: image/png');
		ob_start();
		imagepng( $image );
		$output = ob_get_clean();

// 		$t = time();
// 		$r = rand();

// 		imagepng( $image, "./product-$t-$r.png" );

		imagedestroy( $image );

		return $output;

	}

	public static function get_image_name() {
		$t = time();
		$r = rand();
		return "product-$t-$r.png";
	}

	/**
	 * Returns true if WooCommerce is active.
	 * @return boolean true if WooCommerce is active
	 */
	private static function woocommerce_is_active() {
		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}
		return in_array( 'woocommerce/woocommerce.php', $active_plugins ); 
	}
}
WooCommerce_Product_Generator::init();
