<?php
    include "apiClient.class.php";
/**
 * GET Example
 * ---------------------------------------------
 *
 * $result = APIClient::serverInfo( array( 'serverID' => '1' ) );
 *
 */

$result = APIClient::serverInfo( array( 'serverID' => '1' ) );

/**
 * POST Example
 * ---------------------------------------------
 *
 * $data = array(
 *             'serverID'  => '1',
 *             'message'   => 'your message',
 *             'block'     => '/19');
 * $result = APIClient::requestIP( $data) );
 *
 */
 
 ?>