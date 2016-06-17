<?php
/**
 * BuddyPress Messages Template Tags.
 *
 * @package BuddyPress
 * @subpackage MessagesTemplate
 * @since 1.5.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

require dirname( __FILE__ ) . '/classes/class-bp-messages-box-template.php';
require dirname( __FILE__ ) . '/classes/class-bp-messages-thread-template.php';

/**
 * Retrieve private message threads for display in inbox/sentbox/notices.
 *
 * Similar to WordPress's have_posts() function, this function is responsible
 * for querying the database and retrieving private messages for display inside
 * the theme via individual template parts for a member's inbox/sentbox/notices.
 *
 * @since 1.0.0
 *
 * @global BP_Messages_Box_Template $messages_template
 *
 * @param array|string $args {
 *     Array of arguments. All are optional.
 *     @type int    $user_id      ID of the user whose threads are being loaded.
 *                                Default: ID of the logged-in user.
 *     @type string $box          Current "box" view. If not provided here, the current
 *                                view will be inferred from the URL.
 *     @type int    $per_page     Number of results to return per page. Default: 10.
 *     @type int    $max          Max results to return. Default: false.
 *     @type string $type         Type of messages to return. Values: 'all', 'read', 'unread'
 *                                Default: 'all'
 *     @type string $search_terms Terms to which to limit results. Default:
 *                                the value of $_REQUEST['s'].
 *     @type string $page_arg     URL argument used for the pagination param.
 *                                Default: 'mpage'.
 *     @type array  $meta_query   Meta query arguments. Only applicable if $box is
 *                                not 'notices'. See WP_Meta_Query more details.
 * }
 * @return bool True if there are threads to display, otherwise false.
 */
function bp_has_message_threads( $args = array() ) {
	global $messages_template;

	// The default box the user is looking at.
	$current_action = bp_current_action();
	switch ( $current_action ) {
		case 'sentbox' :
		case 'notices' :
		case 'inbox'   :
			$default_box = $current_action;
			break;
		default :
			$default_box = 'inbox';
			break;
	}

	// User ID
	// @todo displayed user for moderators that get this far?
	$user_id = bp_loggedin_user_id();

	// Search Terms.
	$search_terms = isset( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : '';

	// Parse the arguments.
	$r = bp_parse_args( $args, array(
		'user_id'      => $user_id,
		'box'          => $default_box,
		'per_page'     => 10,
		'max'          => false,
		'type'         => 'all',
		'search_terms' => $search_terms,
		'page_arg'     => 'mpage', // See https://buddypress.trac.wordpress.org/ticket/3679.
		'meta_query'   => array()
	), 'has_message_threads' );
	// print_r($r);

	// if($r['box']=="inbox") {
		// $r['meta_query'][] = array( 'key' => 'starred_by_user', 'value' => 0 );
		
	// }	
	// print_r($r);

	// Load the messages loop global up with messages.
	$messages_template = new BP_Messages_Box_Template( $r );

	/**
	 * Filters if there are any message threads to display in inbox/sentbox/notices.
	 *
	 * @since 1.1.0
	 *
	 * @param bool                     $value             Whether or not the message has threads.
	 * @param BP_Messages_Box_Template $messages_template Current message box template object.
	 * @param array                    $r                 Array of parsed arguments passed into function.
	 */
	return apply_filters( 'bp_has_message_threads', $messages_template->has_threads(), $messages_template, $r );
}

/**
 * Check whether there are more threads to iterate over.
 *
 * @return bool
 */
function bp_message_threads() {
	global $messages_template;
	return $messages_template->message_threads();
}

/**
 * Set up the current thread inside the loop.
 *
 * @return object
 */
function bp_message_thread() {
	global $messages_template;
	return $messages_template->the_message_thread();
}

/**
 * Output the ID of the current thread in the loop.
 */
function bp_message_thread_id() {
	echo bp_get_message_thread_id();
}
	/**
	 * Get the ID of the current thread in the loop.
	 *
	 * @return int
	 */
	function bp_get_message_thread_id() {
		global $messages_template;

		/**
		 * Filters the ID of the current thread in the loop.
		 *
		 * @since 1.0.0
		 *
		 * @param int $thread_id ID of the current thread in the loop.
		 */
		return apply_filters( 'bp_get_message_thread_id', $messages_template->thread->thread_id );
	}

/**
 * Output the subject of the current thread in the loop.
 */
function bp_message_thread_subject() {
	echo bp_get_message_thread_subject();
}
	/**
	 * Get the subject of the current thread in the loop.
	 *
	 * @return string
	 */
	function bp_get_message_thread_subject() {
		global $messages_template;

		/**
		 * Filters the subject of the current thread in the loop.
		 *
		 * @since 1.1.0
		 *
		 * @param string $value Subject of the current thread in the loop.
		 */
		return apply_filters( 'bp_get_message_thread_subject', $messages_template->thread->last_message_subject );
	}

/**
 * Output an excerpt from the current message in the loop.
 */
function bp_message_thread_excerpt() {
	echo bp_get_message_thread_excerpt();
}
	/**
	 * Generate an excerpt from the current message in the loop.
	 *
	 * @return string
	 */
	function bp_get_message_thread_excerpt() {
		global $messages_template;

		/**
		 * Filters the excerpt of the current thread in the loop.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value Excerpt of the current thread in the loop.
		 */
		return apply_filters( 'bp_get_message_thread_excerpt', strip_tags( bp_create_excerpt( $messages_template->thread->last_message_content, 75 ) ) );
	}

/**
 * Output the thread's last message content.
 *
 * When viewing your Inbox, the last message is the most recent message in
 * the thread of which you are *not* the author.
 *
 * When viewing your Sentbox, last message is the most recent message in
 * the thread of which you *are* the member.
 *
 * @since 2.0.0
 */
function bp_message_thread_content() {
	echo bp_get_message_thread_content();
}
	/**
	 * Return the thread's last message content.
	 *
	 * When viewing your Inbox, the last message is the most recent message in
	 * the thread of which you are *not* the author.
	 *
	 * When viewing your Sentbox, last message is the most recent message in
	 * the thread of which you *are* the member.
	 *
	 * @since 2.0.0
	 *
	 * @return string The raw content of the last message in the thread.
	 */
	function bp_get_message_thread_content() {
		global $messages_template;

		/**
		 * Filters the content of the last message in the thread.
		 *
		 * @since 2.0.0
		 *
		 * @param string $last_message_content Content of the last message in the thread.
		 */
		return apply_filters( 'bp_get_message_thread_content', $messages_template->thread->last_message_content );
	}

/**
 * Output a link to the page of the current thread's last author.
 */
function bp_message_thread_from() {
	echo bp_get_message_thread_from();
}
	/**
	 * Get a link to the page of the current thread's last author.
	 *
	 * @return string
	 */
	function bp_get_message_thread_from() {
		global $messages_template;

		/**
		 * Filters the link to the page of the current thread's last author.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value Link to the page of the current thread's last author.
		 */
		return apply_filters( 'bp_get_message_thread_from', bp_core_get_userlink( $messages_template->thread->last_sender_id ) );
	}

/**
 * Output links to the pages of the current thread's recipients.
 */
function bp_message_thread_to() {
	echo bp_get_message_thread_to();
}
	/**
	 * Generate HTML links to the pages of the current thread's recipients.
	 *
	 * @return string
	 */
	function bp_get_message_thread_to() {
		global $messages_template;

		/**
		 * Filters the HTML links to the pages of the current thread's recipients.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value HTML links to the pages of the current thread's recipients.
		 */
		return apply_filters( 'bp_message_thread_to', BP_Messages_Thread::get_recipient_links($messages_template->thread->recipients ) );
	}

/**
 * Output the permalink for a particular thread.
 *
 * @param int $thread_id Optional. ID of the thread. Default: current thread
 *                       being iterated on in the loop.
 */
function bp_message_thread_view_link( $thread_id = 0 ) {
	echo bp_get_message_thread_view_link( $thread_id );
}
	/**
	 * Get the permalink of a particular thread.
	 *
	 * @param int $thread_id Optional. ID of the thread. Default: current
	 *                       thread being iterated on in the loop.
	 * @return string
	 */
	function bp_get_message_thread_view_link( $thread_id = 0 ) {
		global $messages_template;

		if ( empty( $messages_template ) && (int) $thread_id > 0 ) {
			$thread_id = (int) $thread_id;
		} elseif ( ! empty( $messages_template->thread->thread_id ) ) {
			$thread_id = $messages_template->thread->thread_id;
		}

		/**
		 * Filters the permalink of a particular thread.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value permalink of a particular thread.
		 */
		return apply_filters( 'bp_get_message_thread_view_link', trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/view/' . $thread_id ) );
	}

/**
 * Output the URL for deleting the current thread.
 */
function bp_message_thread_delete_link() {
	echo esc_url( bp_get_message_thread_delete_link() );
}
	/**
	 * Generate the URL for deleting the current thread.
	 *
	 * @return string
	 */
	function bp_get_message_thread_delete_link() {
		global $messages_template;

		/**
		 * Filters the URL for deleting the current thread.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value URL for deleting the current thread.
		 * @param string $value Text indicating action being executed.
		 */
		return apply_filters( 'bp_get_message_thread_delete_link', wp_nonce_url( trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() . '/delete/' . $messages_template->thread->thread_id ), 'messages_delete_thread' ) );
	}

/**
 * Output the URL used for marking a single message thread as unread.
 *
 * Since this function directly outputs a URL, it is escaped.
 *
 * @since 2.2.0
 */
function bp_the_message_thread_mark_unread_url() {
	echo esc_url( bp_get_the_message_thread_mark_unread_url() );
}
	/**
	 * Return the URL used for marking a single message thread as unread.
	 *
	 * @since 2.2.0
	 *
	 * @return string
	 */
	function bp_get_the_message_thread_mark_unread_url() {

		// Get the message ID.
		$id = bp_get_message_thread_id();

		// Get the args to add to the URL.
		$args = array(
			'action'     => 'unread',
			'message_id' => $id
		);

		// Base unread URL.
		$url = trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() . '/unread' );

		// Add the args to the URL.
		$url = add_query_arg( $args, $url );

		// Add the nonce.
		$url = wp_nonce_url( $url, 'bp_message_thread_mark_unread_' . $id );

		/**
		 * Filters the URL used for marking a single message thread as unread.
		 *
		 * @since 2.2.0
		 *
		 * @param string $url URL used for marking a single message thread as unread.
		 */
		return apply_filters( 'bp_get_the_message_thread_mark_unread_url', $url );
	}

/**
 * Output the URL used for marking a single message thread as read.
 *
 * Since this function directly outputs a URL, it is escaped.
 *
 * @since 2.2.0
 */
function bp_the_message_thread_mark_read_url() {
	echo esc_url( bp_get_the_message_thread_mark_read_url() );
}
	/**
	 * Return the URL used for marking a single message thread as read.
	 *
	 * @since 2.2.0
	 *
	 * @return string
	 */
	function bp_get_the_message_thread_mark_read_url() {

		// Get the message ID.
		$id = bp_get_message_thread_id();

		// Get the args to add to the URL.
		$args = array(
			'action'     => 'read',
			'message_id' => $id
		);

		// Base read URL.
		$url = trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() . '/read' );

		// Add the args to the URL.
		$url = add_query_arg( $args, $url );

		// Add the nonce.
		$url = wp_nonce_url( $url, 'bp_message_thread_mark_read_' . $id );

		/**
		 * Filters the URL used for marking a single message thread as read.
		 *
		 * @since 2.2.0
		 *
		 * @param string $url URL used for marking a single message thread as read.
		 */
		return apply_filters( 'bp_get_the_message_thread_mark_read_url', $url );
	}

/**
 * Output the CSS class for the current thread.
 */
function bp_message_css_class() {
	echo esc_attr( bp_get_message_css_class() );
}
	/**
	 * Generate the CSS class for the current thread.
	 *
	 * @return string
	 */
	function bp_get_message_css_class() {
		global $messages_template;

		$class = false;

		if ( $messages_template->current_thread % 2 == 1 ) {
			$class .= 'alt';
		}

		/**
		 * Filters the CSS class for the current thread.
		 *
		 * @since 1.2.10
		 *
		 * @param string $class Class string to be added to the list of classes.
		 */
		return apply_filters( 'bp_get_message_css_class', trim( $class ) );
	}

/**
 * Check whether the current thread has unread items.
 *
 * @return bool True if there are unread items, otherwise false.
 */
function bp_message_thread_has_unread() {
	global $messages_template;

	$retval = ! empty( $messages_template->thread->unread_count )
		? true
		: false;

	/**
	 * Filters whether or not a message thread has unread items.
	 *
	 * @since 2.1.0
	 *
	 * @param bool $retval Whether or not a message thread has unread items.
	 */
	return apply_filters( 'bp_message_thread_has_unread', $retval );
}

/**
 * Output the current thread's unread count.
 */
function bp_message_thread_unread_count() {
	echo esc_html( bp_get_message_thread_unread_count() );
}
	/**
	 * Get the current thread's unread count.
	 *
	 * @return int
	 */
	function bp_get_message_thread_unread_count() {
		global $messages_template;

		$count = ! empty( $messages_template->thread->unread_count )
			? (int) $messages_template->thread->unread_count
			: false;

		/**
		 * Filters the current thread's unread count.
		 *
		 * @since 1.0.0
		 *
		 * @param int $count Current thread unread count.
		 */
		return apply_filters( 'bp_get_message_thread_unread_count', $count );
	}

/**
 * Output a thread's total message count.
 *
 * @since 2.2.0
 *
 * @param int|bool $thread_id Optional. ID of the thread. Defaults to current thread ID.
 */
function bp_message_thread_total_count( $thread_id = false ) {
	echo bp_get_message_thread_total_count( $thread_id );
}
	/**
	 * Get the current thread's total message count.
	 *
	 * @since 2.2.0
	 *
	 * @param int|bool $thread_id Optional. ID of the thread.
	 *                            Defaults to current thread ID.
	 * @return int
	 */
	function bp_get_message_thread_total_count( $thread_id = false ) {
		if ( false === $thread_id ) {
			$thread_id = bp_get_message_thread_id();
		}

		$thread_template = new BP_Messages_Thread_Template( $thread_id, 'ASC', array(
			'update_meta_cache' => false
		) );

		$count = 0;
		if ( ! empty( $thread_template->message_count ) ) {
			$count = intval( $thread_template->message_count );
		}

		/**
		 * Filters the current thread's total message count.
		 *
		 * @since 2.2.0
		 *
		 * @param int $count Current thread total message count.
		 */
		return apply_filters( 'bp_get_message_thread_total_count', $count );
	}

/**
 * Output markup for the current thread's total and unread count.
 *
 * @since 2.2.0
 *
 * @param int|bool $thread_id Optional. ID of the thread. Default: current thread ID.
 */
function bp_message_thread_total_and_unread_count( $thread_id = false ) {
	echo bp_get_message_thread_total_and_unread_count( $thread_id );
}
	/**
	 * Get markup for the current thread's total and unread count.
	 *
	 * @param int|bool $thread_id Optional. ID of the thread. Default: current thread ID.
	 * @return string Markup displaying the total and unread count for the thread.
	 */
	function bp_get_message_thread_total_and_unread_count( $thread_id = false ) {
		if ( false === $thread_id ) {
			$thread_id = bp_get_message_thread_id();
		}

		$total  = bp_get_message_thread_total_count( $thread_id );
		$unread = bp_get_message_thread_unread_count( $thread_id );

		return sprintf(
			'<span class="thread-count">(%1$s)</span> <span class="bp-screen-reader-text">%2$s</span>',
			number_format_i18n( $total ),
			sprintf( _n( '%d unread', '%d unread', $unread, 'buddypress' ), number_format_i18n( $unread ) )
		);
	}

/**
 * Output the unformatted date of the last post in the current thread.
 */
function bp_message_thread_last_post_date_raw() {
	echo bp_get_message_thread_last_post_date_raw();
}
	/**
	 * Get the unformatted date of the last post in the current thread.
	 *
	 * @return string
	 */
	function bp_get_message_thread_last_post_date_raw() {
		global $messages_template;

		/**
		 * Filters the unformatted date of the last post in the current thread.
		 *
		 * @since 2.1.0
		 *
		 * @param string $last_message_date Unformatted date of the last post in the current thread.
		 */
		return apply_filters( 'bp_get_message_thread_last_message_date', $messages_template->thread->last_message_date );
	}

/**
 * Output the nicely formatted date of the last post in the current thread.
 */
function bp_message_thread_last_post_date() {
	echo bp_get_message_thread_last_post_date();
}
	/**
	 * Get the nicely formatted date of the last post in the current thread.
	 *
	 * @return string
	 */
	function bp_get_message_thread_last_post_date() {

		/**
		 * Filters the nicely formatted date of the last post in the current thread.
		 *
		 * @since 2.1.0
		 *
		 * @param string $value Formatted date of the last post in the current thread.
		 */
		return apply_filters( 'bp_get_message_thread_last_post_date', bp_format_time( strtotime( bp_get_message_thread_last_post_date_raw() ) ) );
	}

/**
 * Output the avatar for the last sender in the current message thread.
 *
 * @see bp_get_message_thread_avatar() for a description of arguments.
 *
 * @param array|string $args See {@link bp_get_message_thread_avatar()}.
 */
function bp_message_thread_avatar( $args = '' ) {
	echo bp_get_message_thread_avatar( $args );
}
	/**
	 * Return the avatar for the last sender in the current message thread.
	 *
	 * @see bp_core_fetch_avatar() For a description of arguments and
	 *      return values.
	 *
	 * @param array|string $args {
	 *     Arguments are listed here with an explanation of their defaults.
	 *     For more information about the arguments, see
	 *     {@link bp_core_fetch_avatar()}.
	 *     @type string      $type   Default: 'thumb'.
	 *     @type int|bool    $width  Default: false.
	 *     @type int|bool    $height Default: false.
	 *     @type string      $class  Default: 'avatar'.
	 *     @type string|bool $id     Default: false.
	 *     @type string      $alt    Default: 'Profile picture of [display name]'.
	 * }
	 * @return string User avatar string.
	 */
	function bp_get_message_thread_avatar( $args = '' ) {
		global $messages_template;

		$fullname = bp_core_get_user_displayname( $messages_template->thread->last_sender_id );
		$alt      = sprintf( __( 'Profile picture of %s', 'buddypress' ), $fullname );

		$r = bp_parse_args( $args, array(
			'type'   => 'thumb',
			'width'  => false,
			'height' => false,
			'class'  => 'avatar',
			'id'     => false,
			'alt'    => $alt
		) );

		/**
		 * Filters the avatar for the last sender in the current message thread.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value User avatar string.
		 */
		return apply_filters( 'bp_get_message_thread_avatar', bp_core_fetch_avatar( array(
			'item_id' => $messages_template->thread->last_sender_id,
			'type'    => $r['type'],
			'alt'     => $r['alt'],
			'css_id'  => $r['id'],
			'class'   => $r['class'],
			'width'   => $r['width'],
			'height'  => $r['height'],
		) ) );
	}

/**
 * Output the unread messages count for the current inbox.
 */
function bp_total_unread_messages_count() {
	echo bp_get_total_unread_messages_count();
}
	/**
	 * Get the unread messages count for the current inbox.
	 *
	 * @return int
	 */
	function bp_get_total_unread_messages_count() {

		/**
		 * Filters the unread messages count for the current inbox.
		 *
		 * @since 1.0.0
		 *
		 * @param int $value Unread messages count for the current inbox.
		 */
		return apply_filters( 'bp_get_total_unread_messages_count', BP_Messages_Thread::get_inbox_count() );
	}

/**
 * Output the pagination HTML for the current thread loop.
 */
function bp_messages_pagination() {
	echo bp_get_messages_pagination();
}
	/**
	 * Get the pagination HTML for the current thread loop.
	 *
	 * @return string
	 */
	function bp_get_messages_pagination() {
		global $messages_template;

		/**
		 * Filters the pagination HTML for the current thread loop.
		 *
		 * @since 1.0.0
		 *
		 * @param int $pag_links Pagination HTML for the current thread loop.
		 */
		return apply_filters( 'bp_get_messages_pagination', $messages_template->pag_links );
	}

/**
 * Generate the "Viewing message x to y (of z messages)" string for a loop.
 */
function bp_messages_pagination_count() {
	global $messages_template;

	$start_num = intval( ( $messages_template->pag_page - 1 ) * $messages_template->pag_num ) + 1;
	$from_num  = bp_core_number_format( $start_num );
	$to_num    = bp_core_number_format( ( $start_num + ( $messages_template->pag_num - 1 ) > $messages_template->total_thread_count ) ? $messages_template->total_thread_count : $start_num + ( $messages_template->pag_num - 1 ) );
	$total     = bp_core_number_format( $messages_template->total_thread_count );

	if ( 1 == $messages_template->total_thread_count ) {
		$message = __( 'Viewing 1 message', 'buddypress' );
	} else {
		$message = sprintf( _n( 'Viewing %1$s - %2$s of %3$s message', 'Viewing %1$s - %2$s of %3$s messages', $messages_template->total_thread_count, 'buddypress' ), $from_num, $to_num, $total );
	}

	echo esc_html( $message );
}

/**
 * Output the Private Message search form.
 *
 * @todo  Move markup to template part in: /members/single/messages/search.php
 * @since 1.6.0
 */
function bp_message_search_form() {

	// Get the default search text.
	$default_search_value = bp_get_search_default_text( 'messages' );

	// Setup a few values based on what's being searched for.
	$search_submitted     = ! empty( $_REQUEST['s'] ) ? stripslashes( $_REQUEST['s'] ) : $default_search_value;
	$search_placeholder   = ( $search_submitted === $default_search_value ) ? ' placeholder="' .  esc_attr( $search_submitted ) . '"' : '';
	$search_value         = ( $search_submitted !== $default_search_value ) ? ' value="'       .  esc_attr( $search_submitted ) . '"' : '';

	// Start the output buffer, so form can be filtered.
	ob_start(); ?>

	<form action="" method="get" id="search-message-form">
		<label for="messages_search" class="bp-screen-reader-text"><?php esc_html_e( 'Search messages', 'buddypress' ); ?></label>
		<input type="text" name="s" id="messages_search"<?php echo $search_placeholder . $search_value; ?> />
		<input type="submit" class="button" id="messages_search_submit" name="messages_search_submit" value="<?php esc_html_e( 'Search', 'buddypress' ); ?>" />
	</form>

	<?php

	// Get the search form from the above output buffer.
	$search_form_html = ob_get_clean();

	/**
	 * Filters the private message component search form.
	 *
	 * @since 2.2.0
	 *
	 * @param string $search_form_html HTML markup for the message search form.
	 */
	echo apply_filters( 'bp_message_search_form', $search_form_html );
}

/**
 * Echo the form action for Messages HTML forms.
 */
function bp_messages_form_action() {
	echo esc_url( bp_get_messages_form_action() );
}
	/**
	 * Return the form action for Messages HTML forms.
	 *
	 * @return string The form action.
	 */
	function bp_get_messages_form_action() {

		/**
		 * Filters the form action for Messages HTML forms.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value The form action.
		 */
		return apply_filters( 'bp_get_messages_form_action', trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/' . bp_current_action() . '/' . bp_action_variable( 0 ) ) );
	}

/**
 * Output the default username for the recipient box.
 */
function bp_messages_username_value() {
	echo esc_attr( bp_get_messages_username_value() );
}
	/**
	 * Get the default username for the recipient box.
	 *
	 * @return string
	 */
	function bp_get_messages_username_value() {
		if ( isset( $_COOKIE['bp_messages_send_to'] ) ) {

			/**
			 * Filters the default username for the recipient box.
			 *
			 * Value passed into filter is dependent on if the 'bp_messages_send_to'
			 * cookie or 'r' $_GET parameter is set.
			 *
			 * @since 1.0.0
			 *
			 * @param string $value Default user name.
			 */
			return apply_filters( 'bp_get_messages_username_value', $_COOKIE['bp_messages_send_to'] );
		} elseif ( isset( $_GET['r'] ) && !isset( $_COOKIE['bp_messages_send_to'] ) ) {
			/** This filter is documented in bp-messages-template.php */
			return apply_filters( 'bp_get_messages_username_value', $_GET['r'] );
		}
	}

/**
 * Output the default value for the Subject field.
 */
function bp_messages_subject_value() {
	echo esc_attr( bp_get_messages_subject_value() );
}
	/**
	 * Get the default value for the Subject field.
	 *
	 * Will get a value out of $_POST['subject'] if available (ie after a
	 * failed submission).
	 *
	 * @return string
	 */
	function bp_get_messages_subject_value() {

		// Sanitized in bp-messages-filters.php.
		$subject = ! empty( $_POST['subject'] )
			? $_POST['subject']
			: '';

		/**
		 * Filters the default value for the subject field.
		 *
		 * @since 1.0.0
		 *
		 * @param string $subject The default value for the subject field.
		 */
		return apply_filters( 'bp_get_messages_subject_value', $subject );
	}

/**
 * Output the default value for the Compose content field.
 */
function bp_messages_content_value() {
	echo esc_textarea( bp_get_messages_content_value() );
}
	/**
	 * Get the default value fo the Compose content field.
	 *
	 * Will get a value out of $_POST['content'] if available (ie after a
	 * failed submission).
	 *
	 * @return string
	 */
	function bp_get_messages_content_value() {

		// Sanitized in bp-messages-filters.php.
		$content = ! empty( $_POST['content'] )
			? $_POST['content']
			: '';

		/**
		 * Filters the default value for the content field.
		 *
		 * @since 1.0.0
		 *
		 * @param string $content The default value for the content field.
		 */
		return apply_filters( 'bp_get_messages_content_value', $content );
	}

/**
 * Output the markup for the message type dropdown.
 */
function bp_messages_options() {
?>

	<label for="message-type-select" class="bp-screen-reader-text">
		<?php _e( 'Select:', 'buddypress' ) ?>
	 </label>

	<select name="message-type-select" id="message-type-select">
		<option value=""><?php _e( 'Select', 'buddypress' ); ?></option>
		<option value="read"><?php _ex('Read', 'Message dropdown filter', 'buddypress') ?></option>
		<option value="unread"><?php _ex('Unread', 'Message dropdown filter', 'buddypress') ?></option>
		<option value="all"><?php _ex('All', 'Message dropdown filter', 'buddypress') ?></option>
	</select> &nbsp;

	<?php if ( ! bp_is_current_action( 'sentbox' ) && ! bp_is_current_action( 'notices' ) ) : ?>

		<a href="#" id="mark_as_read"><?php _ex('Mark as Read', 'Message management markup', 'buddypress') ?></a> &nbsp;
		<a href="#" id="mark_as_unread"><?php _ex('Mark as Unread', 'Message management markup', 'buddypress') ?></a> &nbsp;

	<?php endif; ?>

	<a href="#" id="delete_<?php echo bp_current_action(); ?>_messages"><?php _e( 'Delete Selected', 'buddypress' ); ?></a> &nbsp;

<?php
}

/**
 * Output the dropdown for bulk management of messages.
 *
 * @since 2.2.0
 */
function bp_messages_bulk_management_dropdown() {
	?>
	<label class="bp-screen-reader-text" for="messages-select"><?php _e( 'Select Bulk Action', 'buddypress' ); ?></label>
	<select name="messages_bulk_action" id="messages-select">
		<option value="" selected="selected"><?php _e( 'Bulk Actions', 'buddypress' ); ?></option>
		<option value="read"><?php _e( 'Mark read', 'buddypress' ); ?></option>
		<option value="unread"><?php _e( 'Mark unread', 'buddypress' ); ?></option>
		<option value="delete"><?php _e( 'Delete', 'buddypress' ); ?></option>
		<?php
			/**
			 * Action to add additional options to the messages bulk management dropdown.
			 *
			 * @since 2.3.0
			 */
			do_action( 'bp_messages_bulk_management_dropdown' );
		?>
	</select>
	<input type="submit" id="messages-bulk-manage" class="button action" value="<?php esc_attr_e( 'Apply', 'buddypress' ); ?>">
	<?php
}

/**
 * Return whether or not the notice is currently active.
 *
 * @since 1.6.0
 *
 * @return bool
 */
function bp_messages_is_active_notice() {
	global $messages_template;

	$retval = ! empty( $messages_template->thread->is_active )
		? true
		: false;

	/**
	 * Filters whether or not the notice is currently active.
	 *
	 * @since 2.1.0
	 *
	 * @param bool $retval Whether or not the notice is currently active.
	 */
	return apply_filters( 'bp_messages_is_active_notice', $retval );
}

/**
 * Output a string for the active notice.
 *
 * Since 1.6 this function has been deprecated in favor of text in the theme.
 *
 * @since 1.0.0
 * @deprecated 1.6.0
 * @uses bp_get_message_is_active_notice()
 * @return bool
 */
function bp_message_is_active_notice() {
	echo bp_get_message_is_active_notice();
}
	/**
	 * Returns a string for the active notice.
	 *
	 * Since 1.6 this function has been deprecated in favor of text in the
	 * theme.
	 *
	 * @since 1.0.0
	 * @deprecated 1.6.0
	 * @uses bp_messages_is_active_notice()
	 */
	function bp_get_message_is_active_notice() {

		$string = bp_messages_is_active_notice()
			? __( 'Currently Active', 'buddypress' )
			: '';

		return apply_filters( 'bp_get_message_is_active_notice', $string );
	}

/**
 * Output the ID of the current notice in the loop.
 */
function bp_message_notice_id() {
	echo (int) bp_get_message_notice_id();
}
	/**
	 * Get the ID of the current notice in the loop.
	 *
	 * @return int
	 */
	function bp_get_message_notice_id() {
		global $messages_template;

		/**
		 * Filters the ID of the current notice in the loop.
		 *
		 * @since 1.5.0
		 *
		 * @param int $id ID of the current notice in the loop.
		 */
		return apply_filters( 'bp_get_message_notice_id', $messages_template->thread->id );
	}

/**
 * Output the post date of the current notice in the loop.
 */
function bp_message_notice_post_date() {
	echo bp_get_message_notice_post_date();
}
	/**
	 * Get the post date of the current notice in the loop.
	 *
	 * @return string
	 */
	function bp_get_message_notice_post_date() {
		global $messages_template;

		/**
		 * Filters the post date of the current notice in the loop.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value Formatted post date of the current notice in the loop.
		 */
		return apply_filters( 'bp_get_message_notice_post_date', bp_format_time( strtotime( $messages_template->thread->date_sent ) ) );
	}

/**
 * Output the subject of the current notice in the loop.
 */
function bp_message_notice_subject() {
	echo bp_get_message_notice_subject();
}
	/**
	 * Get the subject of the current notice in the loop.
	 *
	 * @return string
	 */
	function bp_get_message_notice_subject() {
		global $messages_template;

		/**
		 * Filters the subject of the current notice in the loop.
		 *
		 * @since 1.0.0
		 *
		 * @param string $subject Subject of the current notice in the loop.
		 */
		return apply_filters( 'bp_get_message_notice_subject', $messages_template->thread->subject );
	}

/**
 * Output the text of the current notice in the loop.
 */
function bp_message_notice_text() {
	echo bp_get_message_notice_text();
}
	/**
	 * Get the text of the current notice in the loop.
	 *
	 * @return string
	 */
	function bp_get_message_notice_text() {
		global $messages_template;

		/**
		 * Filters the text of the current notice in the loop.
		 *
		 * @since 1.0.0
		 *
		 * @param string $message Text for the current notice in the loop.
		 */
		return apply_filters( 'bp_get_message_notice_text', $messages_template->thread->message );
	}

/**
 * Output the URL for deleting the current notice.
 */
function bp_message_notice_delete_link() {
	echo esc_url( bp_get_message_notice_delete_link() );
}
	/**
	 * Get the URL for deleting the current notice.
	 *
	 * @return string Delete URL.
	 */
	function bp_get_message_notice_delete_link() {
		global $messages_template;

		/**
		 * Filters the URL for deleting the current notice.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value URL for deleting the current notice.
		 * @param string $value Text indicating action being executed.
		 */
		return apply_filters( 'bp_get_message_notice_delete_link', wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/notices/delete/' . $messages_template->thread->id, 'messages_delete_thread' ) );
	}

/**
 * Output the URL for deactivating the current notice.
 */
function bp_message_activate_deactivate_link() {
	echo esc_url( bp_get_message_activate_deactivate_link() );
}
	/**
	 * Get the URL for deactivating the current notice.
	 *
	 * @return string
	 */
	function bp_get_message_activate_deactivate_link() {
		global $messages_template;

		if ( 1 === (int) $messages_template->thread->is_active ) {
			$link = wp_nonce_url( trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/notices/deactivate/' . $messages_template->thread->id ), 'messages_deactivate_notice' );
		} else {
			$link = wp_nonce_url( trailingslashit( bp_loggedin_user_domain() . bp_get_messages_slug() . '/notices/activate/' . $messages_template->thread->id ), 'messages_activate_notice' );
		}

		/**
		 * Filters the URL for deactivating the current notice.
		 *
		 * @since 1.0.0
		 *
		 * @param string $link URL for deactivating the current notice.
		 */
		return apply_filters( 'bp_get_message_activate_deactivate_link', $link );
	}

/**
 * Output the Deactivate/Activate text for the notice action link.
 */
function bp_message_activate_deactivate_text() {
	echo esc_html( bp_get_message_activate_deactivate_text() );
}
	/**
	 * Generate the text ('Deactivate' or 'Activate') for the notice action link.
	 *
	 * @return string
	 */
	function bp_get_message_activate_deactivate_text() {
		global $messages_template;

		if ( 1 === (int) $messages_template->thread->is_active  ) {
			$text = __('Deactivate', 'buddypress');
		} else {
			$text = __('Activate', 'buddypress');
		}

		/**
		 * Filters the "Deactivate" or "Activate" text for notice action links.
		 *
		 * @since 1.0.0
		 *
		 * @param string $text Text used for notice action links.
		 */
		return apply_filters( 'bp_message_activate_deactivate_text', $text );
	}

/**
 * Output the messages component slug.
 *
 * @since 1.5.0
 *
 * @uses bp_get_messages_slug()
 */
function bp_messages_slug() {
	echo bp_get_messages_slug();
}
	/**
	 * Return the messages component slug.
	 *
	 * @since 1.5.0
	 *
	 * @return string
	 */
	function bp_get_messages_slug() {

		/**
		 * Filters the messages component slug.
		 *
		 * @since 1.5.0
		 *
		 * @param string $slug Messages component slug.
		 */
		return apply_filters( 'bp_get_messages_slug', buddypress()->messages->slug );
	}

/**
 * Generate markup for currently active notices.
 */
function bp_message_get_notices() {
	$notice = BP_Messages_Notice::get_active();	

	if ( empty( $notice ) ) {
		return false;
	}

	$closed_notices = bp_get_user_meta( bp_loggedin_user_id(), 'closed_notices', true );

	if ( empty( $closed_notices ) ) {
		$closed_notices = array();
	}

	if ( is_array( $closed_notices ) ) {
		if ( !in_array( $notice->id, $closed_notices ) && $notice->id ) {
			?>
			<div id="message" class="info notice" rel="n-<?php echo esc_attr( $notice->id ); ?>">
				<p>
					<strong><?php echo stripslashes( wp_filter_kses( $notice->subject ) ) ?></strong><br />
					<?php echo stripslashes( wp_filter_kses( $notice->message) ) ?>
					<a href="#" id="close-notice"><?php _e( 'X', 'buddypress' ) ?></a>
				</p>
			</div>
			<?php
		}
	}
}

/**
 * Output the URL for the Private Message link in member profile headers.
 */
function bp_send_private_message_link() {
	echo esc_url( bp_get_send_private_message_link() );
}
	/**
	 * Generate the URL for the Private Message link in member profile headers.
	 *
	 * @return bool|string False on failure, otherwise the URL.
	 */
	function bp_get_send_private_message_link() {

		if ( bp_is_my_profile() || ! is_user_logged_in() ) {
			return false;
		}

		/**
		 * Filters the URL for the Private Message link in member profile headers.
		 *
		 * @since 1.2.10
		 *
		 * @param string $value URL for the Private Message link in member profile headers.
		 */
		return apply_filters( 'bp_get_send_private_message_link', wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( bp_displayed_user_id() ) ) );
	}

/**
 * Output the 'Private Message' button for member profile headers.
 *
 * Explicitly named function to avoid confusion with public messages.
 *
 * @since 1.2.6
 *
 * @uses bp_get_send_message_button()
 */
function bp_send_private_message_button() {
	echo bp_get_send_message_button();
}

/**
 * Output the 'Private Message' button for member profile headers.
 */
function bp_send_message_button() {
	echo bp_get_send_message_button();
}
	/**
	 * Generate the 'Private Message' button for member profile headers.
	 *
	 * @return string
	 */
	function bp_get_send_message_button() {
		// Note: 'bp_get_send_message_button' is a legacy filter. Use
		// 'bp_get_send_message_button_args' instead. See #4536.
		return apply_filters( 'bp_get_send_message_button',

			/**
			 * Filters the "Private Message" button for member profile headers.
			 *
			 * @since 1.8.0
			 *
			 * @param array $value See {@link BP_Button}.
			 */
			bp_get_button( apply_filters( 'bp_get_send_message_button_args', array(
				'id'                => 'private_message',
				'component'         => 'messages',
				'must_be_logged_in' => true,
				'block_self'        => true,
				'wrapper_id'        => 'send-private-message',
				'link_href'         => bp_get_send_private_message_link(),
				'link_title'        => __( 'Send a private message to this user.', 'buddypress' ),
				'link_text'         => __( 'Private Message', 'buddypress' ),
				'link_class'        => 'send-message',
			) ) )
		);
	}

/**
 * Output the URL of the Messages AJAX loader gif.
 */
function bp_message_loading_image_src() {
	echo esc_url( bp_get_message_loading_image_src() );
}
	/**
	 * Get the URL of the Messages AJAX loader gif.
	 *
	 * @return string
	 */
	function bp_get_message_loading_image_src() {

		/**
		 * Filters the URL of the Messages AJAX loader gif.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value URL of the Messages AJAX loader gif.
		 */
		return apply_filters( 'bp_get_message_loading_image_src', buddypress()->messages->image_base . '/ajax-loader.gif' );
	}

/**
 * Output the markup for the message recipient tabs.
 */
function bp_message_get_recipient_tabs() {
	$recipients = explode( ' ', bp_get_message_get_recipient_usernames() );

	foreach ( $recipients as $recipient ) {

		$user_id = bp_is_username_compatibility_mode()
			? bp_core_get_userid( $recipient )
			: bp_core_get_userid_from_nicename( $recipient );

		if ( ! empty( $user_id ) ) : ?>

			<li id="un-<?php echo esc_attr( $recipient ); ?>" class="friend-tab">
				<span><?php
					echo bp_core_fetch_avatar( array( 'item_id' => $user_id, 'type' => 'thumb', 'width' => 15, 'height' => 15 ) );
					echo bp_core_get_userlink( $user_id );
				?></span>
			</li>

		<?php endif;
	}
}

/**
 * Output recipient usernames for prefilling the 'To' field on the Compose screen.
 */
function bp_message_get_recipient_usernames() {
	echo esc_attr( bp_get_message_get_recipient_usernames() );
}
	/**
	 * Get the recipient usernames for prefilling the 'To' field on the Compose screen.
	 *
	 * @return string
	 */
	function bp_get_message_get_recipient_usernames() {

		// Sanitized in bp-messages-filters.php.
		$recipients = isset( $_GET['r'] )
			? $_GET['r']
			: '';

		/**
		 * Filters the recipients usernames for prefilling the 'To' field on the Compose screen.
		 *
		 * @since 1.0.0
		 *
		 * @param string $recipients Recipients usernames for 'To' field prefilling.
		 */
		return apply_filters( 'bp_get_message_get_recipient_usernames', $recipients );
	}

/**
 * Initialize the messages template loop for a specific thread.
 *
 * @param array|string $args {
 *     Array of arguments. All are optional.
 *     @type int    $thread_id         ID of the thread whose messages you are displaying.
 *                                     Default: if viewing a thread, the thread ID will be parsed from
 *                                     the URL (bp_action_variable( 0 )).
 *     @type string $order             'ASC' or 'DESC'. Default: 'ASC'.
 *     @type bool   $update_meta_cache Whether to pre-fetch metadata for
 *                                     queried message items. Default: true.
 * }
 * @return bool True if there are messages to display, otherwise false.
 */
function bp_thread_has_messages( $args = '' ) {
	global $thread_template;

	$r = bp_parse_args( $args, array(
		'thread_id'         => false,
		'order'             => 'ASC',
		'update_meta_cache' => true,
	), 'thread_has_messages' );

	if ( empty( $r['thread_id'] ) && bp_is_messages_component() && bp_is_current_action( 'view' ) ) {
		$r['thread_id'] = (int) bp_action_variable( 0 );
	}

	// Set up extra args.
	$extra_args = $r;
	unset( $extra_args['thread_id'], $extra_args['order'] );

	$thread_template = new BP_Messages_Thread_Template( $r['thread_id'], $r['order'], $extra_args );

	return $thread_template->has_messages();
}

/**
 * Output the 'ASC' or 'DESC' messages order string for this loop.
 */
function bp_thread_messages_order() {
	echo esc_attr( bp_get_thread_messages_order() );
}
	/**
	 * Get the 'ASC' or 'DESC' messages order string for this loop.
	 *
	 * @return string
	 */
	function bp_get_thread_messages_order() {
		global $thread_template;
		return $thread_template->thread->messages_order;
	}

/**
 * Check whether there are more messages to iterate over.
 *
 * @return bool
 */
function bp_thread_messages() {
	global $thread_template;

	return $thread_template->messages();
}

/**
 * Set up the current thread inside the loop.
 *
 * @return object
 */
function bp_thread_the_message() {
	global $thread_template;

	return $thread_template->the_message();
}

/**
 * Output the ID of the thread that the current loop belongs to.
 */
function bp_the_thread_id() {
	echo (int) bp_get_the_thread_id();
}
	/**
	 * Get the ID of the thread that the current loop belongs to.
	 *
	 * @return int
	 */
	function bp_get_the_thread_id() {
		global $thread_template;

		/**
		 * Filters the ID of the thread that the current loop belongs to.
		 *
		 * @since 1.1.0
		 *
		 * @param int $thread_id ID of the thread.
		 */
		return apply_filters( 'bp_get_the_thread_id', $thread_template->thread->thread_id );
	}

/**
 * Output the subject of the thread currently being iterated over.
 */
function bp_the_thread_subject() {
	echo bp_get_the_thread_subject();
}
	/**
	 * Get the subject of the thread currently being iterated over.
	 *
	 * @return string
	 */
	function bp_get_the_thread_subject() {
		global $thread_template;

		/**
		 * Filters the subject of the thread currently being iterated over.
		 *
		 * @since 1.1.0
		 *
		 * @return string $last_message_subject Subject of the thread currently being iterated over.
		 */
		return apply_filters( 'bp_get_the_thread_subject', $thread_template->thread->last_message_subject );
	}

/**
 * Get a list of thread recipients or a "x recipients" string.
 *
 * In BuddyPress 2.2.0, this parts of this functionality were moved into the
 * members/single/messages/single.php template. This function is no longer used
 * by BuddyPress.
 *
 * @return string
 */
function bp_get_the_thread_recipients() {
	if ( 5 <= bp_get_thread_recipients_count() ) {
		$recipients = sprintf( __( '%s recipients', 'buddypress' ), number_format_i18n( bp_get_thread_recipients_count() ) );
	} else {
		$recipients = bp_get_thread_recipients_list();
	}

	return apply_filters( 'bp_get_the_thread_recipients', $recipients );
}

/**
 * Get the number of recipients in the current thread.
 *
 * @since 2.2.0
 *
 * @return int
 */
function bp_get_thread_recipients_count() {
	global $thread_template;
	return count( $thread_template->thread->recipients );
}

/**
 * Get the max number of recipients to list in the 'Conversation between...' gloss.
 *
 * @since 2.3.0
 *
 * @return int
 */
function bp_get_max_thread_recipients_to_list() {
	/**
	 * Filters the max number of recipients to list in the 'Conversation between...' gloss.
	 *
	 * @since 2.3.0
	 *
	 * @param int $count Recipient count. Default: 5.
	 */
	return (int) apply_filters( 'bp_get_max_thread_recipients_to_list', 5 );
}

/**
 * Output HTML links to recipients in the current thread.
 *
 * @since 2.2.0
 */
function bp_the_thread_recipients_list() {
	echo bp_get_thread_recipients_list();
}
	/**
	 * Generate HTML links to the profiles of recipients in the current thread.
	 *
	 * @since 2.2.0
	 *
	 * @return string
	 */
	function bp_get_thread_recipients_list() {
		global $thread_template;

		$recipient_links = array();

		foreach( (array) $thread_template->thread->recipients as $recipient ) {
			if ( (int) $recipient->user_id !== bp_loggedin_user_id() ) {
				$recipient_link = bp_core_get_userlink( $recipient->user_id );

				if ( empty( $recipient_link ) ) {
					$recipient_link = __( 'Deleted User', 'buddypress' );
				}

				$recipient_links[] = $recipient_link;
			}
		}

		/**
		 * Filters the HTML links to the profiles of recipients in the current thread.
		 *
		 * @since 2.2.0
		 *
		 * @param string $value Comma-separated list of recipient HTML links for current thread.
		 */
		return apply_filters( 'bp_get_the_thread_recipients_list', implode( ', ', $recipient_links ) );
	}

/**
 * Echo the ID of the current message in the thread.
 *
 * @since 1.9.0
 */
function bp_the_thread_message_id() {
	echo (int) bp_get_the_thread_message_id();
}
	/**
	 * Get the ID of the current message in the thread.
	 *
	 * @since 1.9.0
	 *
	 * @return int
	 */
	function bp_get_the_thread_message_id() {
		global $thread_template;

		$thread_message_id = isset( $thread_template->message->id )
			? (int) $thread_template->message->id
			: null;

		/**
		 * Filters the ID of the current message in the thread.
		 *
		 * @since 1.9.0
		 *
		 * @param int $thread_message_id ID of the current message in the thread.
		 */
		return apply_filters( 'bp_get_the_thread_message_id', $thread_message_id );
	}

/**
 * Output the CSS classes for messages within a single thread.
 *
 * @since 2.1.0
 */
function bp_the_thread_message_css_class() {
	echo esc_attr( bp_get_the_thread_message_css_class() );
}
	/**
	 * Generate the CSS classes for messages within a single thread.
	 *
	 * @since 2.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_css_class() {
		global $thread_template;

		$classes = array();

		// Zebra-striping.
		$classes[] = bp_get_the_thread_message_alt_class();

		// ID of the sender.
		$classes[] = 'sent-by-' . intval( $thread_template->message->sender_id );

		// Whether the sender is the same as the logged-in user.
		if ( bp_loggedin_user_id() == $thread_template->message->sender_id ) {
			$classes[] = 'sent-by-me';
		}

		/**
		 * Filters the CSS classes for messages within a single thread.
		 *
		 * @since 2.1.0
		 *
		 * @param array $classes Array of classes to add to the HTML class attribute.
		 */
		$classes = apply_filters( 'bp_get_the_thread_message_css_class', $classes );

		return implode( ' ', $classes );
	}

/**
 * Output the CSS class used for message zebra striping.
 */
function bp_the_thread_message_alt_class() {
	echo esc_attr( bp_get_the_thread_message_alt_class() );
}
	/**
	 * Get the CSS class used for message zebra striping.
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_alt_class() {
		global $thread_template;

		if ( $thread_template->current_message % 2 == 1 ) {
			$class = 'even alt';
		} else {
			$class = 'odd';
		}

		/**
		 * Filters the CSS class used for message zebra striping.
		 *
		 * @since 1.1.0
		 *
		 * @param string $class Class determined to be next for zebra striping effect.
		 */
		return apply_filters( 'bp_get_the_thread_message_alt_class', $class );
	}

/**
 * Output the ID for message sender within a single thread.
 *
 * @since 2.1.0
 */
function bp_the_thread_message_sender_id() {
	echo (int) bp_get_the_thread_message_sender_id();
}
	/**
	 * Return the ID for message sender within a single thread.
	 *
	 * @since 2.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_sender_id() {
		global $thread_template;

		$user_id = ! empty( $thread_template->message->sender_id )
			? $thread_template->message->sender_id
			: 0;

		/**
		 * Filters the ID for message sender within a single thread.
		 *
		 * @since 2.1.0
		 *
		 * @param int $user_id ID of the message sender.
		 */
		return (int) apply_filters( 'bp_get_the_thread_message_sender_id', (int) $user_id );
	}

/**
 * Output the avatar for the current message sender.
 *
 * @param array|string $args See {@link bp_get_the_thread_message_sender_avatar_thumb()}
 *                           for a description.
 */
function bp_the_thread_message_sender_avatar( $args = '' ) {
	echo bp_get_the_thread_message_sender_avatar_thumb( $args );
}
	/**
	 * Get the avatar for the current message sender.
	 *
	 * @param array|string $args {
	 *     Array of arguments. See {@link bp_core_fetch_avatar()} for more
	 *     complete details. All arguments are optional.
	 *     @type string $type   Avatar type. Default: 'thumb'.
	 *     @type int    $width  Avatar width. Default: default for your $type.
	 *     @type int    $height Avatar height. Default: default for your $type.
	 * }
	 * @return string <img> tag containing the avatar.
	 */
	function bp_get_the_thread_message_sender_avatar_thumb( $args = '' ) {
		global $thread_template;

		$r = bp_parse_args( $args, array(
			'type'   => 'thumb',
			'width'  => false,
			'height' => false,
		) );

		/**
		 * Filters the avatar for the current message sender.
		 *
		 * @since 1.1.0
		 *
		 * @param string $value <img> tag containing the avatar value.
		 */
		return apply_filters( 'bp_get_the_thread_message_sender_avatar_thumb', bp_core_fetch_avatar( array(
			'item_id' => $thread_template->message->sender_id,
			'type'    => $r['type'],
			'width'   => $r['width'],
			'height'  => $r['height'],
			'alt'     => bp_core_get_user_displayname( $thread_template->message->sender_id )
		) ) );
	}

/**
 * Output a link to the sender of the current message.
 *
 * @since 1.1.0
 */
function bp_the_thread_message_sender_link() {
	echo esc_url( bp_get_the_thread_message_sender_link() );
}
	/**
	 * Get a link to the sender of the current message.
	 *
	 * @since 1.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_sender_link() {
		global $thread_template;

		/**
		 * Filters the link to the sender of the current message.
		 *
		 * @since 1.1.0
		 *
		 * @param string $value Link to the sender of the current message.
		 */
		return apply_filters( 'bp_get_the_thread_message_sender_link', bp_core_get_userlink( $thread_template->message->sender_id, false, true ) );
	}

/**
 * Output the display name of the sender of the current message.
 *
 * @since 1.1.0
 */
function bp_the_thread_message_sender_name() {
	echo esc_html( bp_get_the_thread_message_sender_name() );
}
	/**
	 * Get the display name of the sender of the current message.
	 *
	 * @since 1.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_sender_name() {
		global $thread_template;

		$display_name = bp_core_get_user_displayname( $thread_template->message->sender_id );

		if ( empty( $display_name ) ) {
			$display_name = __( 'Deleted User', 'buddypress' );
		}

		/**
		 * Filters the display name of the sender of the current message.
		 *
		 * @since 1.1.0
		 *
		 * @param string $display_name Display name of the sender of the current message.
		 */
		return apply_filters( 'bp_get_the_thread_message_sender_name', $display_name );
	}

/**
 * Output the URL for deleting the current thread.
 *
 * @since 1.5.0
 */
function bp_the_thread_delete_link() {
	echo esc_url( bp_get_the_thread_delete_link() );
}
	/**
	 * Get the URL for deleting the current thread.
	 *
	 * @since 1.5.0
	 *
	 * @return string URL
	 */
	function bp_get_the_thread_delete_link() {

		/**
		 * Filters the URL for deleting the current thread.
		 *
		 * @since 1.0.0
		 *
		 * @param string $value URL for deleting the current thread.
		 * @param string $value Text indicating action being executed.
		 */
		return apply_filters( 'bp_get_message_thread_delete_link', wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/inbox/delete/' . bp_get_the_thread_id(), 'messages_delete_thread' ) );
	}

/**
 * Output the 'Sent x hours ago' string for the current message.
 *
 * @since 1.1.0
 */
function bp_the_thread_message_time_since() {
	echo bp_get_the_thread_message_time_since();
}
	/**
	 * Generate the 'Sent x hours ago' string for the current message.
	 *
	 * @since 1.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_time_since() {

		/**
		 * Filters the 'Sent x hours ago' string for the current message.
		 *
		 * @since 1.1.0
		 *
		 * @param string $value Default text of 'Sent x hours ago'.
		 */
		return apply_filters( 'bp_get_the_thread_message_time_since', sprintf( __( 'Sent %s', 'buddypress' ), bp_core_time_since( bp_get_the_thread_message_date_sent() ) ) );
	}

/**
 * Output the timestamp for the current message.
 *
 * @since 2.1.0
 */
function bp_the_thread_message_date_sent() {
	echo bp_get_the_thread_message_date_sent();
}
	/**
	 * Generate the 'Sent x hours ago' string for the current message.
	 *
	 * @since 2.1.0
	 *
	 * @uses strtotime() To convert the message string into a usable timestamp.
	 *
	 * @return int
	 */
	function bp_get_the_thread_message_date_sent() {
		global $thread_template;

		/**
		 * Filters the date sent value for the current message as a timestamp.
		 *
		 * @since 2.1.0
		 *
		 * @param string $value Timestamp of the date sent value for the current message.
		 */
		return apply_filters( 'bp_get_the_thread_message_date_sent', strtotime( $thread_template->message->date_sent ) );
	}

/**
 * Output the content of the current message in the loop.
 *
 * @since 1.1.0
 */
function bp_the_thread_message_content() {
	echo bp_get_the_thread_message_content();
}
	/**
	 * Get the content of the current message in the loop.
	 *
	 * @since 1.1.0
	 *
	 * @return string
	 */
	function bp_get_the_thread_message_content() {
		global $thread_template;

		/**
		 * Filters the content of the current message in the loop.
		 *
		 * @since 1.1.0
		 *
		 * @param string $message The content of the current message in the loop.
		 */
		return apply_filters( 'bp_get_the_thread_message_content', $thread_template->message->message );
	}

/** Embeds *******************************************************************/

/**
 * Enable oEmbed support for Messages.
 *
 * @since 1.5.0
 *
 * @see BP_Embed
 */
function bp_messages_embed() {
	add_filter( 'embed_post_id',         'bp_get_the_thread_message_id' );
	add_filter( 'bp_embed_get_cache',    'bp_embed_message_cache',      10, 3 );
	add_action( 'bp_embed_update_cache', 'bp_embed_message_save_cache', 10, 3 );
}
add_action( 'thread_loop_start', 'bp_messages_embed' );

/**
 * Fetch a private message item's cached embeds.
 *
 * Used during {@link BP_Embed::parse_oembed()} via {@link bp_messages_embed()}.
 *
 * @since 2.2.0
 *
 * @param string $cache    An empty string passed by BP_Embed::parse_oembed() for
 *                         functions like this one to filter.
 * @param int    $id       The ID of the message item.
 * @param string $cachekey The cache key generated in BP_Embed::parse_oembed().
 * @return mixed The cached embeds for this message item.
 */
function bp_embed_message_cache( $cache, $id, $cachekey ) {
	return bp_messages_get_meta( $id, $cachekey );
}

/**
 * Set a private message item's embed cache.
 *
 * Used during {@link BP_Embed::parse_oembed()} via {@link bp_messages_embed()}.
 *
 * @since 2.2.0
 *
 * @param string $cache    An empty string passed by BP_Embed::parse_oembed() for
 *                         functions like this one to filter.
 * @param string $cachekey The cache key generated in BP_Embed::parse_oembed().
 * @param int    $id       The ID of the message item.
 */
function bp_embed_message_save_cache( $cache, $cachekey, $id ) {
	bp_messages_update_meta( $id, $cachekey, $cache );
}

/**
 * Get time zone
 * @param string $country
 * @param string $region
 * @return string If the timezone is not found, returns null`
 */
function get_time_zone($country, $region)
{
    $timezone = null;
    switch ($country) {
        case "AD":
            $timezone = "Europe/Andorra";
            break;
        case "AE":
            $timezone = "Asia/Dubai";
            break;
        case "AF":
            $timezone = "Asia/Kabul";
            break;
        case "AG":
            $timezone = "America/Antigua";
            break;
        case "AI":
            $timezone = "America/Anguilla";
            break;
        case "AL":
            $timezone = "Europe/Tirane";
            break;
        case "AM":
            $timezone = "Asia/Yerevan";
            break;
        case "AN":
            $timezone = "America/Curacao";
            break;
        case "AO":
            $timezone = "Africa/Luanda";
            break;
        case "AQ":
            $timezone = "Antarctica/South_Pole";
            break;
        case "AR":
            switch ($region) {
                case "01":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "02":
                    $timezone = "America/Argentina/Catamarca";
                    break;
                case "03":
                    $timezone = "America/Argentina/Tucuman";
                    break;
                case "04":
                    $timezone = "America/Argentina/Rio_Gallegos";
                    break;
                case "05":
                    $timezone = "America/Argentina/Cordoba";
                    break;
                case "06":
                    $timezone = "America/Argentina/Tucuman";
                    break;
                case "07":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "08":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "09":
                    $timezone = "America/Argentina/Tucuman";
                    break;
                case "10":
                    $timezone = "America/Argentina/Jujuy";
                    break;
                case "11":
                    $timezone = "America/Argentina/San_Luis";
                    break;
                case "12":
                    $timezone = "America/Argentina/La_Rioja";
                    break;
                case "13":
                    $timezone = "America/Argentina/Mendoza";
                    break;
                case "14":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "15":
                    $timezone = "America/Argentina/San_Luis";
                    break;
                case "16":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "17":
                    $timezone = "America/Argentina/Salta";
                    break;
                case "18":
                    $timezone = "America/Argentina/San_Juan";
                    break;
                case "19":
                    $timezone = "America/Argentina/San_Luis";
                    break;
                case "20":
                    $timezone = "America/Argentina/Rio_Gallegos";
                    break;
                case "21":
                    $timezone = "America/Argentina/Buenos_Aires";
                    break;
                case "22":
                    $timezone = "America/Argentina/Catamarca";
                    break;
                case "23":
                    $timezone = "America/Argentina/Ushuaia";
                    break;
                case "24":
                    $timezone = "America/Argentina/Tucuman";
                    break;
                default:
                	$timezone = "America/Argentina/Buenos_Aires";
                    break;
        }
        break;
        case "AS":
            $timezone = "Pacific/Pago_Pago";
            break;
        case "AT":
            $timezone = "Europe/Vienna";
            break;
        case "AU":
            switch ($region) {
                case "01":
                    $timezone = "Australia/Sydney";
                    break;
                case "02":
                    $timezone = "Australia/Sydney";
                    break;
                case "03":
                    $timezone = "Australia/Darwin";
                    break;
                case "04":
                    $timezone = "Australia/Brisbane";
                    break;
                case "05":
                    $timezone = "Australia/Adelaide";
                    break;
                case "06":
                    $timezone = "Australia/Hobart";
                    break;
                case "07":
                    $timezone = "Australia/Melbourne";
                    break;
                case "08":
                    $timezone = "Australia/Perth";
                    break;
                default:
                	$timezone = "Australia/Melbourne";
                    break;
        }
        break;
        case "AW":
            $timezone = "America/Aruba";
            break;
        case "AX":
            $timezone = "Europe/Mariehamn";
            break;
        case "AZ":
            $timezone = "Asia/Baku";
            break;
        case "BA":
            $timezone = "Europe/Sarajevo";
            break;
        case "BB":
            $timezone = "America/Barbados";
            break;
        case "BD":
            $timezone = "Asia/Dhaka";
            break;
        case "BE":
            $timezone = "Europe/Brussels";
            break;
        case "BF":
            $timezone = "Africa/Ouagadougou";
            break;
        case "BG":
            $timezone = "Europe/Sofia";
            break;
        case "BH":
            $timezone = "Asia/Bahrain";
            break;
        case "BI":
            $timezone = "Africa/Bujumbura";
            break;
        case "BJ":
            $timezone = "Africa/Porto-Novo";
            break;
        case "BL":
            $timezone = "America/St_Barthelemy";
            break;
        case "BM":
            $timezone = "Atlantic/Bermuda";
            break;
        case "BN":
            $timezone = "Asia/Brunei";
            break;
        case "BO":
            $timezone = "America/La_Paz";
            break;
        case "BQ":
            $timezone = "America/Curacao";
            break;
        case "BR":
            switch ($region) {
                case "01":
                    $timezone = "America/Rio_Branco";
                    break;
                case "02":
                    $timezone = "America/Maceio";
                    break;
                case "03":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "04":
                    $timezone = "America/Manaus";
                    break;
                case "05":
                    $timezone = "America/Bahia";
                    break;
                case "06":
                    $timezone = "America/Fortaleza";
                    break;
                case "07":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "08":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "11":
                    $timezone = "America/Campo_Grande";
                    break;
                case "13":
                    $timezone = "America/Belem";
                    break;
                case "14":
                    $timezone = "America/Cuiaba";
                    break;
                case "15":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "16":
                    $timezone = "America/Belem";
                    break;
                case "17":
                    $timezone = "America/Recife";
                    break;
                case "18":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "20":
                    $timezone = "America/Fortaleza";
                    break;
                case "21":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "22":
                    $timezone = "America/Recife";
                    break;
                case "23":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "24":
                    $timezone = "America/Porto_Velho";
                    break;
                case "25":
                    $timezone = "America/Boa_Vista";
                    break;
                case "26":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "27":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "28":
                    $timezone = "America/Maceio";
                    break;
                case "29":
                    $timezone = "America/Sao_Paulo";
                    break;
                case "30":
                    $timezone = "America/Recife";
                    break;
                case "31":
                    $timezone = "America/Araguaina";
                    break;
                default:
                	$timezone = "America/Sao_Paulo";
                    break;
        }
        break;
        case "BS":
            $timezone = "America/Nassau";
            break;
        case "BT":
            $timezone = "Asia/Thimphu";
            break;
        case "BV":
            $timezone = "Antarctica/Syowa";
            break;
        case "BW":
            $timezone = "Africa/Gaborone";
            break;
        case "BY":
            $timezone = "Europe/Minsk";
            break;
        case "BZ":
            $timezone = "America/Belize";
            break;
        case "CA":
            switch ($region) {
                case "AB":
                    $timezone = "America/Edmonton";
                    break;
                case "BC":
                    $timezone = "America/Vancouver";
                    break;
                case "MB":
                    $timezone = "America/Winnipeg";
                    break;
                case "NB":
                    $timezone = "America/Halifax";
                    break;
                case "NL":
                    $timezone = "America/St_Johns";
                    break;
                case "NS":
                    $timezone = "America/Halifax";
                    break;
                case "NT":
                    $timezone = "America/Yellowknife";
                    break;
                case "NU":
                    $timezone = "America/Rankin_Inlet";
                    break;
                case "ON":
                    $timezone = "America/Toronto";
                    break;
                case "PE":
                    $timezone = "America/Halifax";
                    break;
                case "QC":
                    $timezone = "America/Montreal";
                    break;
                case "SK":
                    $timezone = "America/Regina";
                    break;
                case "YT":
                    $timezone = "America/Whitehorse";
                    break;
                default:
                	$timezone = "America/Toronto";
                    break;
        }
        break;
        case "CC":
            $timezone = "Indian/Cocos";
            break;
        case "CD":
            switch ($region) {
                case "01":
                    $timezone = "Africa/Kinshasa";
                    break;
                case "02":
                    $timezone = "Africa/Kinshasa";
                    break;
                case "03":
                    $timezone = "Africa/Kinshasa";
                    break;
                case "04":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "05":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "06":
                    $timezone = "Africa/Kinshasa";
                    break;
                case "07":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "08":
                    $timezone = "Africa/Kinshasa";
                    break;
                case "09":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "10":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "11":
                    $timezone = "Africa/Lubumbashi";
                    break;
                case "12":
                    $timezone = "Africa/Lubumbashi";
                    break;
                default:
                	$timezone = "Africa/Kinshasa";
                    break;
        }
        break;
        case "CF":
            $timezone = "Africa/Bangui";
            break;
        case "CG":
            $timezone = "Africa/Brazzaville";
            break;
        case "CH":
            $timezone = "Europe/Zurich";
            break;
        case "CI":
            $timezone = "Africa/Abidjan";
            break;
        case "CK":
            $timezone = "Pacific/Rarotonga";
            break;
        case "CL":
            $timezone = "America/Santiago";
            break;
        case "CM":
            $timezone = "Africa/Lagos";
            break;
        case "CN":
            switch ($region) {
                case "01":
                    $timezone = "Asia/Shanghai";
                    break;
                case "02":
                    $timezone = "Asia/Shanghai";
                    break;
                case "03":
                    $timezone = "Asia/Shanghai";
                    break;
                case "04":
                    $timezone = "Asia/Shanghai";
                    break;
                case "05":
                    $timezone = "Asia/Harbin";
                    break;
                case "06":
                    $timezone = "Asia/Chongqing";
                    break;
                case "07":
                    $timezone = "Asia/Shanghai";
                    break;
                case "08":
                    $timezone = "Asia/Harbin";
                    break;
                case "09":
                    $timezone = "Asia/Shanghai";
                    break;
                case "10":
                    $timezone = "Asia/Shanghai";
                    break;
                case "11":
                    $timezone = "Asia/Chongqing";
                    break;
                case "12":
                    $timezone = "Asia/Shanghai";
                    break;
                case "13":
                    $timezone = "Asia/Urumqi";
                    break;
                case "14":
                    $timezone = "Asia/Chongqing";
                    break;
                case "15":
                    $timezone = "Asia/Chongqing";
                    break;
                case "16":
                    $timezone = "Asia/Chongqing";
                    break;
                case "18":
                    $timezone = "Asia/Chongqing";
                    break;
                case "19":
                    $timezone = "Asia/Harbin";
                    break;
                case "20":
                    $timezone = "Asia/Harbin";
                    break;
                case "21":
                    $timezone = "Asia/Chongqing";
                    break;
                case "22":
                    $timezone = "Asia/Harbin";
                    break;
                case "23":
                    $timezone = "Asia/Shanghai";
                    break;
                case "24":
                    $timezone = "Asia/Chongqing";
                    break;
                case "25":
                    $timezone = "Asia/Shanghai";
                    break;
                case "26":
                    $timezone = "Asia/Chongqing";
                    break;
                case "28":
                    $timezone = "Asia/Shanghai";
                    break;
                case "29":
                    $timezone = "Asia/Chongqing";
                    break;
                case "30":
                    $timezone = "Asia/Chongqing";
                    break;
                case "31":
                    $timezone = "Asia/Chongqing";
                    break;
                case "32":
                    $timezone = "Asia/Chongqing";
                    break;
                case "33":
                    $timezone = "Asia/Chongqing";
                    break;
                default:
                	$timezone = "Asia/Shanghai";
                    break;
        }
        break;
        case "CO":
            $timezone = "America/Bogota";
            break;
        case "CR":
            $timezone = "America/Costa_Rica";
            break;
        case "CU":
            $timezone = "America/Havana";
            break;
        case "CV":
            $timezone = "Atlantic/Cape_Verde";
            break;
        case "CW":
            $timezone = "America/Curacao";
            break;
        case "CX":
            $timezone = "Indian/Christmas";
            break;
        case "CY":
            $timezone = "Asia/Nicosia";
            break;
        case "CZ":
            $timezone = "Europe/Prague";
            break;
        case "DE":
            $timezone = "Europe/Berlin";
            break;
        case "DJ":
            $timezone = "Africa/Djibouti";
            break;
        case "DK":
            $timezone = "Europe/Copenhagen";
            break;
        case "DM":
            $timezone = "America/Dominica";
            break;
        case "DO":
            $timezone = "America/Santo_Domingo";
            break;
        case "DZ":
            $timezone = "Africa/Algiers";
            break;
        case "EC":
            switch ($region) {
                case "01":
                    $timezone = "Pacific/Galapagos";
                    break;
                case "02":
                    $timezone = "America/Guayaquil";
                    break;
                case "03":
                    $timezone = "America/Guayaquil";
                    break;
                case "04":
                    $timezone = "America/Guayaquil";
                    break;
                case "05":
                    $timezone = "America/Guayaquil";
                    break;
                case "06":
                    $timezone = "America/Guayaquil";
                    break;
                case "07":
                    $timezone = "America/Guayaquil";
                    break;
                case "08":
                    $timezone = "America/Guayaquil";
                    break;
                case "09":
                    $timezone = "America/Guayaquil";
                    break;
                case "10":
                    $timezone = "America/Guayaquil";
                    break;
                case "11":
                    $timezone = "America/Guayaquil";
                    break;
                case "12":
                    $timezone = "America/Guayaquil";
                    break;
                case "13":
                    $timezone = "America/Guayaquil";
                    break;
                case "14":
                    $timezone = "America/Guayaquil";
                    break;
                case "15":
                    $timezone = "America/Guayaquil";
                    break;
                case "17":
                    $timezone = "America/Guayaquil";
                    break;
                case "18":
                    $timezone = "America/Guayaquil";
                    break;
                case "19":
                    $timezone = "America/Guayaquil";
                    break;
                case "20":
                    $timezone = "America/Guayaquil";
                    break;
                case "22":
                    $timezone = "America/Guayaquil";
                    break;
                case "24":
                    $timezone = "America/Guayaquil";
                    break;
                default:
                	$timezone = "America/Guayaquil";
                    break;
        }
        break;
        case "EE":
            $timezone = "Europe/Tallinn";
            break;
        case "EG":
            $timezone = "Africa/Cairo";
            break;
        case "EH":
            $timezone = "Africa/El_Aaiun";
            break;
        case "ER":
            $timezone = "Africa/Asmara";
            break;
        case "ES":
            switch ($region) {
                case "07":
                    $timezone = "Europe/Madrid";
                    break;
                case "27":
                    $timezone = "Europe/Madrid";
                    break;
                case "29":
                    $timezone = "Europe/Madrid";
                    break;
                case "31":
                    $timezone = "Europe/Madrid";
                    break;
                case "32":
                    $timezone = "Europe/Madrid";
                    break;
                case "34":
                    $timezone = "Europe/Madrid";
                    break;
                case "39":
                    $timezone = "Europe/Madrid";
                    break;
                case "51":
                    $timezone = "Africa/Ceuta";
                    break;
                case "52":
                    $timezone = "Europe/Madrid";
                    break;
                case "53":
                    $timezone = "Atlantic/Canary";
                    break;
                case "54":
                    $timezone = "Europe/Madrid";
                    break;
                case "55":
                    $timezone = "Europe/Madrid";
                    break;
                case "56":
                    $timezone = "Europe/Madrid";
                    break;
                case "57":
                    $timezone = "Europe/Madrid";
                    break;
                case "58":
                    $timezone = "Europe/Madrid";
                    break;
                case "59":
                    $timezone = "Europe/Madrid";
                    break;
                case "60":
                    $timezone = "Europe/Madrid";
                    break;
                default:
                	$timezone = "Europe/Madrid";
                    break;
        }
        break;
        case "ET":
            $timezone = "Africa/Addis_Ababa";
            break;
        case "FI":
            $timezone = "Europe/Helsinki";
            break;
        case "FJ":
            $timezone = "Pacific/Fiji";
            break;
        case "FK":
            $timezone = "Atlantic/Stanley";
            break;
        case "FM":
            $timezone = "Pacific/Pohnpei";
            break;
        case "FO":
            $timezone = "Atlantic/Faroe";
            break;
        case "FR":
            $timezone = "Europe/Paris";
            break;
        case "FX":
            $timezone = "Europe/Paris";
            break;
        case "GA":
            $timezone = "Africa/Libreville";
            break;
        case "GB":
            $timezone = "Europe/London";
            break;
        case "GD":
            $timezone = "America/Grenada";
            break;
        case "GE":
            $timezone = "Asia/Tbilisi";
            break;
        case "GF":
            $timezone = "America/Cayenne";
            break;
        case "GG":
            $timezone = "Europe/Guernsey";
            break;
        case "GH":
            $timezone = "Africa/Accra";
            break;
        case "GI":
            $timezone = "Europe/Gibraltar";
            break;
        case "GL":
            switch ($region) {
                case "01":
                    $timezone = "America/Thule";
                    break;
                case "02":
                    $timezone = "America/Godthab";
                    break;
                case "03":
                    $timezone = "America/Godthab";
                    break;
                default:
                    $timezone = "America/Godthab";
                    break;
        }
        break;
        case "GM":
            $timezone = "Africa/Banjul";
            break;
        case "GN":
            $timezone = "Africa/Conakry";
            break;
        case "GP":
            $timezone = "America/Guadeloupe";
            break;
        case "GQ":
            $timezone = "Africa/Malabo";
            break;
        case "GR":
            $timezone = "Europe/Athens";
            break;
        case "GS":
            $timezone = "Atlantic/South_Georgia";
            break;
        case "GT":
            $timezone = "America/Guatemala";
            break;
        case "GU":
            $timezone = "Pacific/Guam";
            break;
        case "GW":
            $timezone = "Africa/Bissau";
            break;
        case "GY":
            $timezone = "America/Guyana";
            break;
        case "HK":
            $timezone = "Asia/Hong_Kong";
            break;
        case "HN":
            $timezone = "America/Tegucigalpa";
            break;
        case "HR":
            $timezone = "Europe/Zagreb";
            break;
        case "HT":
            $timezone = "America/Port-au-Prince";
            break;
        case "HU":
            $timezone = "Europe/Budapest";
            break;
        case "ID":
            switch ($region) {
                case "01":
                    $timezone = "Asia/Pontianak";
                    break;
                case "02":
                    $timezone = "Asia/Makassar";
                    break;
                case "03":
                    $timezone = "Asia/Jakarta";
                    break;
                case "04":
                    $timezone = "Asia/Jakarta";
                    break;
                case "05":
                    $timezone = "Asia/Jakarta";
                    break;
                case "06":
                    $timezone = "Asia/Jakarta";
                    break;
                case "07":
                    $timezone = "Asia/Jakarta";
                    break;
                case "08":
                    $timezone = "Asia/Jakarta";
                    break;
                case "09":
                    $timezone = "Asia/Jayapura";
                    break;
                case "10":
                    $timezone = "Asia/Jakarta";
                    break;
                case "11":
                    $timezone = "Asia/Pontianak";
                    break;
                case "12":
                    $timezone = "Asia/Makassar";
                    break;
                case "13":
                    $timezone = "Asia/Makassar";
                    break;
                case "14":
                    $timezone = "Asia/Makassar";
                    break;
                case "15":
                    $timezone = "Asia/Jakarta";
                    break;
                case "16":
                    $timezone = "Asia/Makassar";
                    break;
                case "17":
                    $timezone = "Asia/Makassar";
                    break;
                case "18":
                    $timezone = "Asia/Makassar";
                    break;
                case "19":
                    $timezone = "Asia/Pontianak";
                    break;
                case "20":
                    $timezone = "Asia/Makassar";
                    break;
                case "21":
                    $timezone = "Asia/Makassar";
                    break;
                case "22":
                    $timezone = "Asia/Makassar";
                    break;
                case "23":
                    $timezone = "Asia/Makassar";
                    break;
                case "24":
                    $timezone = "Asia/Jakarta";
                    break;
                case "25":
                    $timezone = "Asia/Pontianak";
                    break;
                case "26":
                    $timezone = "Asia/Pontianak";
                    break;
                case "28":
                    $timezone = "Asia/Jayapura";
                    break;
                case "29":
                    $timezone = "Asia/Makassar";
                    break;
                case "30":
                    $timezone = "Asia/Jakarta";
                    break;
                case "31":
                    $timezone = "Asia/Makassar";
                    break;
                case "32":
                    $timezone = "Asia/Jakarta";
                    break;
                case "33":
                    $timezone = "Asia/Jakarta";
                    break;
                case "34":
                    $timezone = "Asia/Makassar";
                    break;
                case "35":
                    $timezone = "Asia/Pontianak";
                    break;
                case "36":
                    $timezone = "Asia/Jayapura";
                    break;
                case "37":
                    $timezone = "Asia/Pontianak";
                    break;
                case "38":
                    $timezone = "Asia/Makassar";
                    break;
                case "39":
                    $timezone = "Asia/Jayapura";
                    break;
                case "40":
                    $timezone = "Asia/Pontianak";
                    break;
                case "41":
                    $timezone = "Asia/Makassar";
                    break;
                default:
                    $timezone = "Asia/Jakarta";
                    break;
        }
        break;
        case "IE":
            $timezone = "Europe/Dublin";
            break;
        case "IL":
            $timezone = "Asia/Jerusalem";
            break;
        case "IM":
            $timezone = "Europe/Isle_of_Man";
            break;
        case "IN":
            $timezone = "Asia/Kolkata";
            break;
        case "IO":
            $timezone = "Indian/Chagos";
            break;
        case "IQ":
            $timezone = "Asia/Baghdad";
            break;
        case "IR":
            $timezone = "Asia/Tehran";
            break;
        case "IS":
            $timezone = "Atlantic/Reykjavik";
            break;
        case "IT":
            $timezone = "Europe/Rome";
            break;
        case "JE":
            $timezone = "Europe/Jersey";
            break;
        case "JM":
            $timezone = "America/Jamaica";
            break;
        case "JO":
            $timezone = "Asia/Amman";
            break;
        case "JP":
            $timezone = "Asia/Tokyo";
            break;
        case "KE":
            $timezone = "Africa/Nairobi";
            break;
        case "KG":
            $timezone = "Asia/Bishkek";
            break;
        case "KH":
            $timezone = "Asia/Phnom_Penh";
            break;
        case "KI":
            $timezone = "Pacific/Tarawa";
            break;
        case "KM":
            $timezone = "Indian/Comoro";
            break;
        case "KN":
            $timezone = "America/St_Kitts";
            break;
        case "KP":
            $timezone = "Asia/Pyongyang";
            break;
        case "KR":
            $timezone = "Asia/Seoul";
            break;
        case "KW":
            $timezone = "Asia/Kuwait";
            break;
        case "KY":
            $timezone = "America/Cayman";
            break;
        case "KZ":
            switch ($region) {
                case "01":
                    $timezone = "Asia/Almaty";
                    break;
                case "02":
                    $timezone = "Asia/Almaty";
                    break;
                case "03":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "04":
                    $timezone = "Asia/Aqtobe";
                    break;
                case "05":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "06":
                    $timezone = "Asia/Aqtau";
                    break;
                case "07":
                    $timezone = "Asia/Oral";
                    break;
                case "08":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "09":
                    $timezone = "Asia/Aqtau";
                    break;
                case "10":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "11":
                    $timezone = "Asia/Almaty";
                    break;
                case "12":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "13":
                    $timezone = "Asia/Aqtobe";
                    break;
                case "14":
                    $timezone = "Asia/Qyzylorda";
                    break;
                case "15":
                    $timezone = "Asia/Almaty";
                    break;
                case "16":
                    $timezone = "Asia/Aqtobe";
                    break;
                case "17":
                    $timezone = "Asia/Almaty";
                    break;
                default:
                	$timezone = "Asia/Almaty";
                    break;
        }
        break;
        case "LA":
            $timezone = "Asia/Vientiane";
            break;
        case "LB":
            $timezone = "Asia/Beirut";
            break;
        case "LC":
            $timezone = "America/St_Lucia";
            break;
        case "LI":
            $timezone = "Europe/Vaduz";
            break;
        case "LK":
            $timezone = "Asia/Colombo";
            break;
        case "LR":
            $timezone = "Africa/Monrovia";
            break;
        case "LS":
            $timezone = "Africa/Maseru";
            break;
        case "LT":
            $timezone = "Europe/Vilnius";
            break;
        case "LU":
            $timezone = "Europe/Luxembourg";
            break;
        case "LV":
            $timezone = "Europe/Riga";
            break;
        case "LY":
            $timezone = "Africa/Tripoli";
            break;
        case "MA":
            $timezone = "Africa/Casablanca";
            break;
        case "MC":
            $timezone = "Europe/Monaco";
            break;
        case "MD":
            $timezone = "Europe/Chisinau";
            break;
        case "ME":
            $timezone = "Europe/Podgorica";
            break;
        case "MF":
            $timezone = "America/Marigot";
            break;
        case "MG":
            $timezone = "Indian/Antananarivo";
            break;
        case "MH":
            $timezone = "Pacific/Kwajalein";
            break;
        case "MK":
            $timezone = "Europe/Skopje";
            break;
        case "ML":
            $timezone = "Africa/Bamako";
            break;
        case "MM":
            $timezone = "Asia/Rangoon";
            break;
        case "MN":
            switch ($region) {
                case "06":
                    $timezone = "Asia/Choibalsan";
                    break;
                case "11":
                    $timezone = "Asia/Ulaanbaatar";
                    break;
                case "17":
                    $timezone = "Asia/Choibalsan";
                    break;
                case "19":
                    $timezone = "Asia/Hovd";
                    break;
                case "20":
                    $timezone = "Asia/Ulaanbaatar";
                    break;
                case "21":
                    $timezone = "Asia/Ulaanbaatar";
                    break;
                case "25":
                    $timezone = "Asia/Ulaanbaatar";
                    break;
                default:
                	$timezone = "Asia/Ulaanbaatar";
                    break;
        }
        break;
        case "MO":
            $timezone = "Asia/Macau";
            break;
        case "MP":
            $timezone = "Pacific/Saipan";
            break;
        case "MQ":
            $timezone = "America/Martinique";
            break;
        case "MR":
            $timezone = "Africa/Nouakchott";
            break;
        case "MS":
            $timezone = "America/Montserrat";
            break;
        case "MT":
            $timezone = "Europe/Malta";
            break;
        case "MU":
            $timezone = "Indian/Mauritius";
            break;
        case "MV":
            $timezone = "Indian/Maldives";
            break;
        case "MW":
            $timezone = "Africa/Blantyre";
            break;
        case "MX":
            switch ($region) {
                case "01":
                    $timezone = "America/Mexico_City";
                    break;
                case "02":
                    $timezone = "America/Tijuana";
                    break;
                case "03":
                    $timezone = "America/Hermosillo";
                    break;
                case "04":
                    $timezone = "America/Merida";
                    break;
                case "05":
                    $timezone = "America/Mexico_City";
                    break;
                case "06":
                    $timezone = "America/Chihuahua";
                    break;
                case "07":
                    $timezone = "America/Monterrey";
                    break;
                case "08":
                    $timezone = "America/Mexico_City";
                    break;
                case "09":
                    $timezone = "America/Mexico_City";
                    break;
                case "10":
                    $timezone = "America/Mazatlan";
                    break;
                case "11":
                    $timezone = "America/Mexico_City";
                    break;
                case "12":
                    $timezone = "America/Mexico_City";
                    break;
                case "13":
                    $timezone = "America/Mexico_City";
                    break;
                case "14":
                    $timezone = "America/Mazatlan";
                    break;
                case "15":
                    $timezone = "America/Chihuahua";
                    break;
                case "16":
                    $timezone = "America/Mexico_City";
                    break;
                case "17":
                    $timezone = "America/Mexico_City";
                    break;
                case "18":
                    $timezone = "America/Mazatlan";
                    break;
                case "19":
                    $timezone = "America/Monterrey";
                    break;
                case "20":
                    $timezone = "America/Mexico_City";
                    break;
                case "21":
                    $timezone = "America/Mexico_City";
                    break;
                case "22":
                    $timezone = "America/Mexico_City";
                    break;
                case "23":
                    $timezone = "America/Cancun";
                    break;
                case "24":
                    $timezone = "America/Mexico_City";
                    break;
                case "25":
                    $timezone = "America/Mazatlan";
                    break;
                case "26":
                    $timezone = "America/Hermosillo";
                    break;
                case "27":
                    $timezone = "America/Merida";
                    break;
                case "28":
                    $timezone = "America/Monterrey";
                    break;
                case "29":
                    $timezone = "America/Mexico_City";
                    break;
                case "30":
                    $timezone = "America/Mexico_City";
                    break;
                case "31":
                    $timezone = "America/Merida";
                    break;
                case "32":
                    $timezone = "America/Monterrey";
                    break;
                default:
                	$timezone = "America/Mexico_City";
                    break;
        }
        break;
        case "MY":
            switch ($region) {
                case "01":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "02":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "03":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "04":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "05":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "06":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "07":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "08":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "09":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "11":
                    $timezone = "Asia/Kuching";
                    break;
                case "12":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "13":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "14":
                    $timezone = "Asia/Kuala_Lumpur";
                    break;
                case "15":
                    $timezone = "Asia/Kuching";
                    break;
                case "16":
                    $timezone = "Asia/Kuching";
                    break;
                default:
                	$timezone = "Asia/Kuala_Lumpur";
                    break;
        }
        break;
        case "MZ":
            $timezone = "Africa/Maputo";
            break;
        case "NA":
            $timezone = "Africa/Windhoek";
            break;
        case "NC":
            $timezone = "Pacific/Noumea";
            break;
        case "NE":
            $timezone = "Africa/Niamey";
            break;
        case "NF":
            $timezone = "Pacific/Norfolk";
            break;
        case "NG":
            $timezone = "Africa/Lagos";
            break;
        case "NI":
            $timezone = "America/Managua";
            break;
        case "NL":
            $timezone = "Europe/Amsterdam";
            break;
        case "NO":
            $timezone = "Europe/Oslo";
            break;
        case "NP":
            $timezone = "Asia/Kathmandu";
            break;
        case "NR":
            $timezone = "Pacific/Nauru";
            break;
        case "NU":
            $timezone = "Pacific/Niue";
            break;
        case "NZ":
            switch ($region) {
                case "85":
                    $timezone = "Pacific/Auckland";
                    break;
                case "E7":
                    $timezone = "Pacific/Auckland";
                    break;
                case "E8":
                    $timezone = "Pacific/Auckland";
                    break;
                case "E9":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F1":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F2":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F3":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F4":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F5":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F6":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F7":
                    $timezone = "Pacific/Chatham";
                    break;
                case "F8":
                    $timezone = "Pacific/Auckland";
                    break;
                case "F9":
                    $timezone = "Pacific/Auckland";
                    break;
                case "G1":
                    $timezone = "Pacific/Auckland";
                    break;
                case "G2":
                    $timezone = "Pacific/Auckland";
                    break;
                case "G3":
                    $timezone = "Pacific/Auckland";
                    break;
                default:
                	$timezone = "Pacific/Auckland";
                    break;
        }
        break;
        case "OM":
            $timezone = "Asia/Muscat";
            break;
        case "PA":
            $timezone = "America/Panama";
            break;
        case "PE":
            $timezone = "America/Lima";
            break;
        case "PF":
            $timezone = "Pacific/Marquesas";
            break;
        case "PG":
            $timezone = "Pacific/Port_Moresby";
            break;
        case "PH":
            $timezone = "Asia/Manila";
            break;
        case "PK":
            $timezone = "Asia/Karachi";
            break;
        case "PL":
            $timezone = "Europe/Warsaw";
            break;
        case "PM":
            $timezone = "America/Miquelon";
            break;
        case "PN":
            $timezone = "Pacific/Pitcairn";
            break;
        case "PR":
            $timezone = "America/Puerto_Rico";
            break;
        case "PS":
            $timezone = "Asia/Gaza";
            break;
        case "PT":
            switch ($region) {
                case "02":
                    $timezone = "Europe/Lisbon";
                    break;
                case "03":
                    $timezone = "Europe/Lisbon";
                    break;
                case "04":
                    $timezone = "Europe/Lisbon";
                    break;
                case "05":
                    $timezone = "Europe/Lisbon";
                    break;
                case "06":
                    $timezone = "Europe/Lisbon";
                    break;
                case "07":
                    $timezone = "Europe/Lisbon";
                    break;
                case "08":
                    $timezone = "Europe/Lisbon";
                    break;
                case "09":
                    $timezone = "Europe/Lisbon";
                    break;
                case "10":
                    $timezone = "Atlantic/Madeira";
                    break;
                case "11":
                    $timezone = "Europe/Lisbon";
                    break;
                case "13":
                    $timezone = "Europe/Lisbon";
                    break;
                case "14":
                    $timezone = "Europe/Lisbon";
                    break;
                case "16":
                    $timezone = "Europe/Lisbon";
                    break;
                case "17":
                    $timezone = "Europe/Lisbon";
                    break;
                case "18":
                    $timezone = "Europe/Lisbon";
                    break;
                case "19":
                    $timezone = "Europe/Lisbon";
                    break;
                case "20":
                    $timezone = "Europe/Lisbon";
                    break;
                case "21":
                    $timezone = "Europe/Lisbon";
                    break;
                case "22":
                    $timezone = "Europe/Lisbon";
                    break;
                case "23":
                    $timezone = "Atlantic/Azores";
                    break;
                default:
                    $timezone = "Europe/Lisbon";
                    break;
        }
        break;
        case "PW":
            $timezone = "Pacific/Palau";
            break;
        case "PY":
            $timezone = "America/Asuncion";
            break;
        case "QA":
            $timezone = "Asia/Qatar";
            break;
        case "RE":
            $timezone = "Indian/Reunion";
            break;
        case "RO":
            $timezone = "Europe/Bucharest";
            break;
        case "RS":
            $timezone = "Europe/Belgrade";
            break;
        case "RU":
            switch ($region) {
                case "01":
                    $timezone = "Europe/Volgograd";
                    break;
                case "02":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "03":
                    $timezone = "Asia/Novokuznetsk";
                    break;
                case "04":
                    $timezone = "Asia/Novosibirsk";
                    break;
                case "05":
                    $timezone = "Asia/Vladivostok";
                    break;
                case "06":
                    $timezone = "Europe/Moscow";
                    break;
                case "07":
                    $timezone = "Europe/Volgograd";
                    break;
                case "08":
                    $timezone = "Europe/Samara";
                    break;
                case "09":
                    $timezone = "Europe/Moscow";
                    break;
                case "10":
                    $timezone = "Europe/Moscow";
                    break;
                case "11":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "12":
                    $timezone = "Europe/Volgograd";
                    break;
                case "13":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "14":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "15":
                    $timezone = "Asia/Anadyr";
                    break;
                case "16":
                    $timezone = "Europe/Samara";
                    break;
                case "17":
                    $timezone = "Europe/Volgograd";
                    break;
                case "18":
                    $timezone = "Asia/Krasnoyarsk";
                    break;
                case "20":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "21":
                    $timezone = "Europe/Moscow";
                    break;
                case "22":
                    $timezone = "Europe/Volgograd";
                    break;
                case "23":
                    $timezone = "Europe/Kaliningrad";
                    break;
                case "24":
                    $timezone = "Europe/Volgograd";
                    break;
                case "25":
                    $timezone = "Europe/Moscow";
                    break;
                case "26":
                    $timezone = "Asia/Kamchatka";
                    break;
                case "27":
                    $timezone = "Europe/Volgograd";
                    break;
                case "28":
                    $timezone = "Europe/Moscow";
                    break;
                case "29":
                    $timezone = "Asia/Novokuznetsk";
                    break;
                case "30":
                    $timezone = "Asia/Vladivostok";
                    break;
                case "31":
                    $timezone = "Asia/Krasnoyarsk";
                    break;
                case "32":
                    $timezone = "Asia/Omsk";
                    break;
                case "33":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "34":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "35":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "36":
                    $timezone = "Asia/Anadyr";
                    break;
                case "37":
                    $timezone = "Europe/Moscow";
                    break;
                case "38":
                    $timezone = "Europe/Volgograd";
                    break;
                case "39":
                    $timezone = "Asia/Krasnoyarsk";
                    break;
                case "40":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "41":
                    $timezone = "Europe/Moscow";
                    break;
                case "42":
                    $timezone = "Europe/Moscow";
                    break;
                case "43":
                    $timezone = "Europe/Moscow";
                    break;
                case "44":
                    $timezone = "Asia/Magadan";
                    break;
                case "45":
                    $timezone = "Europe/Samara";
                    break;
                case "46":
                    $timezone = "Europe/Samara";
                    break;
                case "47":
                    $timezone = "Europe/Moscow";
                    break;
                case "48":
                    $timezone = "Europe/Moscow";
                    break;
                case "49":
                    $timezone = "Europe/Moscow";
                    break;
                case "50":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "51":
                    $timezone = "Europe/Moscow";
                    break;
                case "52":
                    $timezone = "Europe/Moscow";
                    break;
                case "53":
                    $timezone = "Asia/Novosibirsk";
                    break;
                case "54":
                    $timezone = "Asia/Omsk";
                    break;
                case "55":
                    $timezone = "Europe/Samara";
                    break;
                case "56":
                    $timezone = "Europe/Moscow";
                    break;
                case "57":
                    $timezone = "Europe/Samara";
                    break;
                case "58":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "59":
                    $timezone = "Asia/Vladivostok";
                    break;
                case "60":
                    $timezone = "Europe/Kaliningrad";
                    break;
                case "61":
                    $timezone = "Europe/Volgograd";
                    break;
                case "62":
                    $timezone = "Europe/Moscow";
                    break;
                case "63":
                    $timezone = "Asia/Yakutsk";
                    break;
                case "64":
                    $timezone = "Asia/Sakhalin";
                    break;
                case "65":
                    $timezone = "Europe/Samara";
                    break;
                case "66":
                    $timezone = "Europe/Moscow";
                    break;
                case "67":
                    $timezone = "Europe/Samara";
                    break;
                case "68":
                    $timezone = "Europe/Volgograd";
                    break;
                case "69":
                    $timezone = "Europe/Moscow";
                    break;
                case "70":
                    $timezone = "Europe/Volgograd";
                    break;
                case "71":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "72":
                    $timezone = "Europe/Moscow";
                    break;
                case "73":
                    $timezone = "Europe/Samara";
                    break;
                case "74":
                    $timezone = "Asia/Krasnoyarsk";
                    break;
                case "75":
                    $timezone = "Asia/Novosibirsk";
                    break;
                case "76":
                    $timezone = "Europe/Moscow";
                    break;
                case "77":
                    $timezone = "Europe/Moscow";
                    break;
                case "78":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "79":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "80":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "81":
                    $timezone = "Europe/Samara";
                    break;
                case "82":
                    $timezone = "Asia/Irkutsk";
                    break;
                case "83":
                    $timezone = "Europe/Moscow";
                    break;
                case "84":
                    $timezone = "Europe/Volgograd";
                    break;
                case "85":
                    $timezone = "Europe/Moscow";
                    break;
                case "86":
                    $timezone = "Europe/Moscow";
                    break;
                case "87":
                    $timezone = "Asia/Novosibirsk";
                    break;
                case "88":
                    $timezone = "Europe/Moscow";
                    break;
                case "89":
                    $timezone = "Asia/Vladivostok";
                    break;
                case "90":
                    $timezone = "Asia/Yekaterinburg";
                    break;
                case "91":
                    $timezone = "Asia/Krasnoyarsk";
                    break;
                case "92":
                    $timezone = "Asia/Anadyr";
                    break;
                case "93":
                    $timezone = "Asia/Irkutsk";
                    break;
                default:
                	$timezone = "Europe/Moscow";
                    break;
        }
        break;
        case "RW":
            $timezone = "Africa/Kigali";
            break;
        case "SA":
            $timezone = "Asia/Riyadh";
            break;
        case "SB":
            $timezone = "Pacific/Guadalcanal";
            break;
        case "SC":
            $timezone = "Indian/Mahe";
            break;
        case "SD":
            $timezone = "Africa/Khartoum";
            break;
        case "SE":
            $timezone = "Europe/Stockholm";
            break;
        case "SG":
            $timezone = "Asia/Singapore";
            break;
        case "SH":
            $timezone = "Atlantic/St_Helena";
            break;
        case "SI":
            $timezone = "Europe/Ljubljana";
            break;
        case "SJ":
            $timezone = "Arctic/Longyearbyen";
            break;
        case "SK":
            $timezone = "Europe/Bratislava";
            break;
        case "SL":
            $timezone = "Africa/Freetown";
            break;
        case "SM":
            $timezone = "Europe/San_Marino";
            break;
        case "SN":
            $timezone = "Africa/Dakar";
            break;
        case "SO":
            $timezone = "Africa/Mogadishu";
            break;
        case "SR":
            $timezone = "America/Paramaribo";
            break;
        case "SS":
            $timezone = "Africa/Juba";
            break;
        case "ST":
            $timezone = "Africa/Sao_Tome";
            break;
        case "SV":
            $timezone = "America/El_Salvador";
            break;
        case "SX":
            $timezone = "America/Curacao";
            break;
        case "SY":
            $timezone = "Asia/Damascus";
            break;
        case "SZ":
            $timezone = "Africa/Mbabane";
            break;
        case "TC":
            $timezone = "America/Grand_Turk";
            break;
        case "TD":
            $timezone = "Africa/Ndjamena";
            break;
        case "TF":
            $timezone = "Indian/Kerguelen";
            break;
        case "TG":
            $timezone = "Africa/Lome";
            break;
        case "TH":
            $timezone = "Asia/Bangkok";
            break;
        case "TJ":
            $timezone = "Asia/Dushanbe";
            break;
        case "TK":
            $timezone = "Pacific/Fakaofo";
            break;
        case "TL":
            $timezone = "Asia/Dili";
            break;
        case "TM":
            $timezone = "Asia/Ashgabat";
            break;
        case "TN":
            $timezone = "Africa/Tunis";
            break;
        case "TO":
            $timezone = "Pacific/Tongatapu";
            break;
        case "TR":
            $timezone = "Asia/Istanbul";
            break;
        case "TT":
            $timezone = "America/Port_of_Spain";
            break;
        case "TV":
            $timezone = "Pacific/Funafuti";
            break;
        case "TW":
            $timezone = "Asia/Taipei";
            break;
        case "TZ":
            $timezone = "Africa/Dar_es_Salaam";
            break;
        case "UA":
            switch ($region) {
                case "01":
                    $timezone = "Europe/Kiev";
                    break;
                case "02":
                    $timezone = "Europe/Kiev";
                    break;
                case "03":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "04":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "05":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "06":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "07":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "08":
                    $timezone = "Europe/Simferopol";
                    break;
                case "09":
                    $timezone = "Europe/Kiev";
                    break;
                case "10":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "11":
                    $timezone = "Europe/Simferopol";
                    break;
                case "12":
                    $timezone = "Europe/Kiev";
                    break;
                case "13":
                    $timezone = "Europe/Kiev";
                    break;
                case "14":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "15":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "16":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "17":
                    $timezone = "Europe/Simferopol";
                    break;
                case "18":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "19":
                    $timezone = "Europe/Kiev";
                    break;
                case "20":
                    $timezone = "Europe/Simferopol";
                    break;
                case "21":
                    $timezone = "Europe/Kiev";
                    break;
                case "22":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "23":
                    $timezone = "Europe/Kiev";
                    break;
                case "24":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "25":
                    $timezone = "Europe/Uzhgorod";
                    break;
                case "26":
                    $timezone = "Europe/Zaporozhye";
                    break;
                case "27":
                    $timezone = "Europe/Kiev";
                    break;
                default:
                	$timezone = "Europe/Kiev";
                    break;
        }
        break;
        case "UG":
            $timezone = "Africa/Kampala";
            break;
        case "UM":
            $timezone = "Pacific/Wake";
            break;
        case "US":
            switch ($region) {
                case "AK":
                    $timezone = "America/Anchorage";
                    break;
                case "AL":
                    $timezone = "America/Chicago";
                    break;
                case "AR":
                    $timezone = "America/Chicago";
                    break;
                case "AZ":
                    $timezone = "America/Phoenix";
                    break;
                case "CA":
                    $timezone = "America/Los_Angeles";
                    break;
                case "CO":
                    $timezone = "America/Denver";
                    break;
                case "CT":
                    $timezone = "America/New_York";
                    break;
                case "DC":
                    $timezone = "America/New_York";
                    break;
                case "DE":
                    $timezone = "America/New_York";
                    break;
                case "FL":
                    $timezone = "America/New_York";
                    break;
                case "GA":
                    $timezone = "America/New_York";
                    break;
                case "HI":
                    $timezone = "Pacific/Honolulu";
                    break;
                case "IA":
                    $timezone = "America/Chicago";
                    break;
                case "ID":
                    $timezone = "America/Denver";
                    break;
                case "IL":
                    $timezone = "America/Chicago";
                    break;
                case "IN":
                    $timezone = "America/Indiana/Indianapolis";
                    break;
                case "KS":
                    $timezone = "America/Chicago";
                    break;
                case "KY":
                    $timezone = "America/New_York";
                    break;
                case "LA":
                    $timezone = "America/Chicago";
                    break;
                case "MA":
                    $timezone = "America/New_York";
                    break;
                case "MD":
                    $timezone = "America/New_York";
                    break;
                case "ME":
                    $timezone = "America/New_York";
                    break;
                case "MI":
                    $timezone = "America/New_York";
                    break;
                case "MN":
                    $timezone = "America/Chicago";
                    break;
                case "MO":
                    $timezone = "America/Chicago";
                    break;
                case "MS":
                    $timezone = "America/Chicago";
                    break;
                case "MT":
                    $timezone = "America/Denver";
                    break;
                case "NC":
                    $timezone = "America/New_York";
                    break;
                case "ND":
                    $timezone = "America/Chicago";
                    break;
                case "NE":
                    $timezone = "America/Chicago";
                    break;
                case "NH":
                    $timezone = "America/New_York";
                    break;
                case "NJ":
                    $timezone = "America/New_York";
                    break;
                case "NM":
                    $timezone = "America/Denver";
                    break;
                case "NV":
                    $timezone = "America/Los_Angeles";
                    break;
                case "NY":
                    $timezone = "America/New_York";
                    break;
                case "OH":
                    $timezone = "America/New_York";
                    break;
                case "OK":
                    $timezone = "America/Chicago";
                    break;
                case "OR":
                    $timezone = "America/Los_Angeles";
                    break;
                case "PA":
                    $timezone = "America/New_York";
                    break;
                case "RI":
                    $timezone = "America/New_York";
                    break;
                case "SC":
                    $timezone = "America/New_York";
                    break;
                case "SD":
                    $timezone = "America/Chicago";
                    break;
                case "TN":
                    $timezone = "America/Chicago";
                    break;
                case "TX":
                    $timezone = "America/Chicago";
                    break;
                case "UT":
                    $timezone = "America/Denver";
                    break;
                case "VA":
                    $timezone = "America/New_York";
                    break;
                case "VT":
                    $timezone = "America/New_York";
                    break;
                case "WA":
                    $timezone = "America/Los_Angeles";
                    break;
                case "WI":
                    $timezone = "America/Chicago";
                    break;
                case "WV":
                    $timezone = "America/New_York";
                    break;
                case "WY":
                    $timezone = "America/Denver";
                    break;
                default:
                	$timezone = "America/New_York";
        }
        break;
        case "UY":
            $timezone = "America/Montevideo";
            break;
        case "UZ":
            switch ($region) {
                case "01":
                    $timezone = "Asia/Tashkent";
                    break;
                case "02":
                    $timezone = "Asia/Samarkand";
                    break;
                case "03":
                    $timezone = "Asia/Tashkent";
                    break;
                case "05":
                    $timezone = "Asia/Samarkand";
                    break;
                case "06":
                    $timezone = "Asia/Tashkent";
                    break;
                case "07":
                    $timezone = "Asia/Samarkand";
                    break;
                case "08":
                    $timezone = "Asia/Samarkand";
                    break;
                case "09":
                    $timezone = "Asia/Samarkand";
                    break;
                case "10":
                    $timezone = "Asia/Samarkand";
                    break;
                case "12":
                    $timezone = "Asia/Samarkand";
                    break;
                case "13":
                    $timezone = "Asia/Tashkent";
                    break;
                case "14":
                    $timezone = "Asia/Tashkent";
                    break;
                default:
                	$timezone = "Asia/Tashkent";
                    break;
        }
        break;
        case "VA":
            $timezone = "Europe/Vatican";
            break;
        case "VC":
            $timezone = "America/St_Vincent";
            break;
        case "VE":
            $timezone = "America/Caracas";
            break;
        case "VG":
            $timezone = "America/Tortola";
            break;
        case "VI":
            $timezone = "America/St_Thomas";
            break;
        case "VN":
            $timezone = "Asia/Phnom_Penh";
            break;
        case "VU":
            $timezone = "Pacific/Efate";
            break;
        case "WF":
            $timezone = "Pacific/Wallis";
            break;
        case "WS":
            $timezone = "Pacific/Pago_Pago";
            break;
        case "YE":
            $timezone = "Asia/Aden";
            break;
        case "YT":
            $timezone = "Indian/Mayotte";
            break;
        case "YU":
            $timezone = "Europe/Belgrade";
            break;
        case "ZA":
            $timezone = "Africa/Johannesburg";
            break;
        case "ZM":
            $timezone = "Africa/Lusaka";
            break;
        case "ZW":
            $timezone = "Africa/Harare";
            break;
    }
    return $timezone;
}

function get_country_code($country_name) {
	$countrycodes = array (
	  'AF' => 'Afghanistan',
	  'AX' => 'Åland Islands',
	  'AL' => 'Albania',
	  'DZ' => 'Algeria',
	  'AS' => 'American Samoa',
	  'AD' => 'Andorra',
	  'AO' => 'Angola',
	  'AI' => 'Anguilla',
	  'AQ' => 'Antarctica',
	  'AG' => 'Antigua and Barbuda',
	  'AR' => 'Argentina',
	  'AU' => 'Australia',
	  'AT' => 'Austria',
	  'AZ' => 'Azerbaijan',
	  'BS' => 'Bahamas',
	  'BH' => 'Bahrain',
	  'BD' => 'Bangladesh',
	  'BB' => 'Barbados',
	  'BY' => 'Belarus',
	  'BE' => 'Belgium',
	  'BZ' => 'Belize',
	  'BJ' => 'Benin',
	  'BM' => 'Bermuda',
	  'BT' => 'Bhutan',
	  'BO' => 'Bolivia',
	  'BA' => 'Bosnia and Herzegovina',
	  'BW' => 'Botswana',
	  'BV' => 'Bouvet Island',
	  'BR' => 'Brazil',
	  'IO' => 'British Indian Ocean Territory',
	  'BN' => 'Brunei Darussalam',
	  'BG' => 'Bulgaria',
	  'BF' => 'Burkina Faso',
	  'BI' => 'Burundi',
	  'KH' => 'Cambodia',
	  'CM' => 'Cameroon',
	  'CA' => 'Canada',
	  'CV' => 'Cape Verde',
	  'KY' => 'Cayman Islands',
	  'CF' => 'Central African Republic',
	  'TD' => 'Chad',
	  'CL' => 'Chile',
	  'CN' => 'China',
	  'CX' => 'Christmas Island',
	  'CC' => 'Cocos (Keeling) Islands',
	  'CO' => 'Colombia',
	  'KM' => 'Comoros',
	  'CG' => 'Congo',
	  'CD' => 'Zaire',
	  'CK' => 'Cook Islands',
	  'CR' => 'Costa Rica',
	  'CI' => 'Côte D\'Ivoire',
	  'HR' => 'Croatia',
	  'CU' => 'Cuba',
	  'CY' => 'Cyprus',
	  'CZ' => 'Czech Republic',
	  'DK' => 'Denmark',
	  'DJ' => 'Djibouti',
	  'DM' => 'Dominica',
	  'DO' => 'Dominican Republic',
	  'EC' => 'Ecuador',
	  'EG' => 'Egypt',
	  'SV' => 'El Salvador',
	  'GQ' => 'Equatorial Guinea',
	  'ER' => 'Eritrea',
	  'EE' => 'Estonia',
	  'ET' => 'Ethiopia',
	  'FK' => 'Falkland Islands (Malvinas)',
	  'FO' => 'Faroe Islands',
	  'FJ' => 'Fiji',
	  'FI' => 'Finland',
	  'FR' => 'France',
	  'GF' => 'French Guiana',
	  'PF' => 'French Polynesia',
	  'TF' => 'French Southern Territories',
	  'GA' => 'Gabon',
	  'GM' => 'Gambia',
	  'GE' => 'Georgia',
	  'DE' => 'Germany',
	  'GH' => 'Ghana',
	  'GI' => 'Gibraltar',
	  'GR' => 'Greece',
	  'GL' => 'Greenland',
	  'GD' => 'Grenada',
	  'GP' => 'Guadeloupe',
	  'GU' => 'Guam',
	  'GT' => 'Guatemala',
	  'GG' => 'Guernsey',
	  'GN' => 'Guinea',
	  'GW' => 'Guinea-Bissau',
	  'GY' => 'Guyana',
	  'HT' => 'Haiti',
	  'HM' => 'Heard Island and Mcdonald Islands',
	  'VA' => 'Vatican City State',
	  'HN' => 'Honduras',
	  'HK' => 'Hong Kong',
	  'HU' => 'Hungary',
	  'IS' => 'Iceland',
	  'IN' => 'India',
	  'ID' => 'Indonesia',
	  'IR' => 'Iran, Islamic Republic of',
	  'IQ' => 'Iraq',
	  'IE' => 'Ireland',
	  'IM' => 'Isle of Man',
	  'IL' => 'Israel',
	  'IT' => 'Italy',
	  'JM' => 'Jamaica',
	  'JP' => 'Japan',
	  'JE' => 'Jersey',
	  'JO' => 'Jordan',
	  'KZ' => 'Kazakhstan',
	  'KE' => 'KENYA',
	  'KI' => 'Kiribati',
	  'KP' => 'Korea, Democratic People\'s Republic of',
	  'KR' => 'Korea, Republic of',
	  'KW' => 'Kuwait',
	  'KG' => 'Kyrgyzstan',
	  'LA' => 'Lao People\'s Democratic Republic',
	  'LV' => 'Latvia',
	  'LB' => 'Lebanon',
	  'LS' => 'Lesotho',
	  'LR' => 'Liberia',
	  'LY' => 'Libyan Arab Jamahiriya',
	  'LI' => 'Liechtenstein',
	  'LT' => 'Lithuania',
	  'LU' => 'Luxembourg',
	  'MO' => 'Macao',
	  'MK' => 'Macedonia, the Former Yugoslav Republic of',
	  'MG' => 'Madagascar',
	  'MW' => 'Malawi',
	  'MY' => 'Malaysia',
	  'MV' => 'Maldives',
	  'ML' => 'Mali',
	  'MT' => 'Malta',
	  'MH' => 'Marshall Islands',
	  'MQ' => 'Martinique',
	  'MR' => 'Mauritania',
	  'MU' => 'Mauritius',
	  'YT' => 'Mayotte',
	  'MX' => 'Mexico',
	  'FM' => 'Micronesia, Federated States of',
	  'MD' => 'Moldova, Republic of',
	  'MC' => 'Monaco',
	  'MN' => 'Mongolia',
	  'ME' => 'Montenegro',
	  'MS' => 'Montserrat',
	  'MA' => 'Morocco',
	  'MZ' => 'Mozambique',
	  'MM' => 'Myanmar',
	  'NA' => 'Namibia',
	  'NR' => 'Nauru',
	  'NP' => 'Nepal',
	  'NL' => 'Netherlands',
	  'AN' => 'Netherlands Antilles',
	  'NC' => 'New Caledonia',
	  'NZ' => 'New Zealand',
	  'NI' => 'Nicaragua',
	  'NE' => 'Niger',
	  'NG' => 'Nigeria',
	  'NU' => 'Niue',
	  'NF' => 'Norfolk Island',
	  'MP' => 'Northern Mariana Islands',
	  'NO' => 'Norway',
	  'OM' => 'Oman',
	  'PK' => 'Pakistan',
	  'PW' => 'Palau',
	  'PS' => 'Palestinian Territory, Occupied',
	  'PA' => 'Panama',
	  'PG' => 'Papua New Guinea',
	  'PY' => 'Paraguay',
	  'PE' => 'Peru',
	  'PH' => 'Philippines',
	  'PN' => 'Pitcairn',
	  'PL' => 'Poland',
	  'PT' => 'Portugal',
	  'PR' => 'Puerto Rico',
	  'QA' => 'Qatar',
	  'RE' => 'Réunion',
	  'RO' => 'Romania',
	  'RU' => 'Russian Federation',
	  'RW' => 'Rwanda',
	  'SH' => 'Saint Helena',
	  'KN' => 'Saint Kitts and Nevis',
	  'LC' => 'Saint Lucia',
	  'PM' => 'Saint Pierre and Miquelon',
	  'VC' => 'Saint Vincent and the Grenadines',
	  'WS' => 'Samoa',
	  'SM' => 'San Marino',
	  'ST' => 'Sao Tome and Principe',
	  'SA' => 'Saudi Arabia',
	  'SN' => 'Senegal',
	  'RS' => 'Serbia',
	  'SC' => 'Seychelles',
	  'SL' => 'Sierra Leone',
	  'SG' => 'Singapore',
	  'SK' => 'Slovakia',
	  'SI' => 'Slovenia',
	  'SB' => 'Solomon Islands',
	  'SO' => 'Somalia',
	  'ZA' => 'South Africa',
	  'GS' => 'South Georgia and the South Sandwich Islands',
	  'ES' => 'Spain',
	  'LK' => 'Sri Lanka',
	  'SD' => 'Sudan',
	  'SR' => 'Suriname',
	  'SJ' => 'Svalbard and Jan Mayen',
	  'SZ' => 'Swaziland',
	  'SE' => 'Sweden',
	  'CH' => 'Switzerland',
	  'SY' => 'Syrian Arab Republic',
	  'TW' => 'Taiwan, Province of China',
	  'TJ' => 'Tajikistan',
	  'TZ' => 'Tanzania, United Republic of',
	  'TH' => 'Thailand',
	  'TL' => 'Timor-Leste',
	  'TG' => 'Togo',
	  'TK' => 'Tokelau',
	  'TO' => 'Tonga',
	  'TT' => 'Trinidad and Tobago',
	  'TN' => 'Tunisia',
	  'TR' => 'Turkey',
	  'TM' => 'Turkmenistan',
	  'TC' => 'Turks and Caicos Islands',
	  'TV' => 'Tuvalu',
	  'UG' => 'Uganda',
	  'UA' => 'Ukraine',
	  'AE' => 'United Arab Emirates',
	  'GB' => 'United Kingdom',
	  'US' => 'United States',
	  'UM' => 'United States Minor Outlying Islands',
	  'UY' => 'Uruguay',
	  'UZ' => 'Uzbekistan',
	  'VU' => 'Vanuatu',
	  'VE' => 'Venezuela',
	  'VN' => 'Viet Nam',
	  'VG' => 'Virgin Islands, British',
	  'VI' => 'Virgin Islands, U.S.',
	  'WF' => 'Wallis and Futuna',
	  'EH' => 'Western Sahara',
	  'YE' => 'Yemen',
	  'ZM' => 'Zambia',
	  'ZW' => 'Zimbabwe',
	);

	$code = array_search($country_name, $countrycodes);

	return $code;
}