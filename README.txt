
This is a very simple PHP library for interacting with the v3 bit.ly api (only deals with JSON format, but supports new OAuth endpoints). This version removes a number of interesting features and concentrates on URL shortening and basic WordPress integration. Specifically, the shortened URL is cached as a WordPress transient.

Note: that this fork includes WordPress specific functionality.  Bitly URLs are cached as WP  transients.

==============
REQUIREMENTS:
==============

php and curl, and WordPress

======
USAGE:
======

This is a modified version adapted to WordPress, where there is a simple need to
shorten a URL. The URL is then cached in the WordPress database using
WordPress transients API.

Copy and paste into functions.php in the theme directory, or require the script like: require 'bitly_wp.php'. Then just echo the results like:

 <?php echo get_bitly_short_url( WP_SITEURL . $_SERVER['REQUEST_URI'] ) ?>


=============
SPECIAL NOTE:
=============

To use the new OAuth endpoints, you must first obtain an access token for a user. You do this by passing the user off to bit.ly to approve your apps access to their account...and then you use the return code along with the bitly_oauth_access_token method to obtain the actual bitly access token:

1. Present the user with a link as such <a href=" https://bit.ly/oauth/authorize?client_id=<?= bitly_clientid ?>&redirect_uri=THE_URL_YOU_WANT_BITLY_TO_REDIRECT_TO_WHEN_APP_IS_APPROVED_BY_USER">Authorize giftabit</a>

2. a code ($_REQUEST['code']) will be supplied as a param to the url Bit.ly redirects to...so you can then execute $results = bitly_oauth_access_token($_REQUEST['code'], 'THE_URL_YOU_WANT_BITLY_TO_REDIRECT_TO_WHEN_APP_IS_APPROVED_BY_USER');

3. If everything goes correctly, you should now have a $results['access_token'] value that you can use with the oauth requests for that user.
>>>>>>> 499fc07d933bee1e47af36490b812852c7857bab

==============
SPECIAL THANKS:
==============

Robin Monks (https://github.com/mozillamonks) - for great additional documentation and general suggestions/improvements.

=======
License:
=======

Copyright 2010 Kevin Marshall.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

