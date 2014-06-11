<?php
/**
 * @file bitly_wp.com
 *
 * A simple PHP script for interacting with the v3 bit.ly api (only deals with
 * JSON format, but supports new OAuth endpoints), and returning a shortened
 * URL. This is a very simplified version of the original, but does add the
 * caching of the shortened URL into the WordPress database as a transient.
 *
 * @required: curl
 * 
 * Original code by:
 *
 * @link https://github.com/Falicon/BitlyPHP
 * @author Kevin Marshall <info@falicon.com>
 * @author Robin Monks <devlinks@gmail.com>
 *
 * @license: GPL v3 (see above).
 *
 * @example: <?php echo get_bitly_short_url( WP_SITEURL . $_SERVER['REQUEST_URI'] ) ?>
 */

/**
 * The bitlyKey assigned to your bit.ly account. (http://bit.ly/a/account)
 */
define('BITLYKEY', 'your API key here');

/**
 * The bitlyLogin assigned to your bit.ly account. (http://bit.ly/a/account)
 */
define('BITLYLOGIN' , 'your bitly login here');

/** 
* @return string $bitly_url, the shortened url from the bitly API 
*
* @params string $url, the URL to be shortened.
*/
function get_bitly_short_url( $url, $login = BITLYLOGIN, $key = BITLYKEY, $format = 'txt') {
	// get a handle to store the URL in the transients WP database
	$bitlymd5 = md5( $url );
	
	// try to get the cached url from WP
	$bitly_url = get_transient( $bitlymd5 );
 
	// check to see if data was successfully retrieved from the transient cache
	if( false === $bitly_url ) {
		
		// do this if no WP transient is set
		$bitly_api_url = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$key.'&uri='.urlencode($url).'&format='.$format;
		
		// return the minified URL & stip new lines, etc
		$bitly_url = str_replace( array("\n", "\r"), '', esc_url( curl_get_result( $bitly_api_url ) ) );
		
		if ( !empty( $bitly_url ) ) {
			// store the data to WP, and set it to expire in 30 days ... really this URL should never change.
			set_transient( $bitlymd5, $bitly_url, 86400*30);
		}
	}
 
	return $bitly_url;
}


/* returns a result from curl */
function curl_get_result( $url ) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	//OH NO MR BILLLLLL!!!!
	if ( $data === false ) return '';
	return $data;
}
    
