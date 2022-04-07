<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'email@example.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfuly!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm.. seems there is a problem, sorry!';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if(
    !isset($_POST['contact-name']) || 
	!isset($_POST['contact-email']) ||
    empty($_POST['contact-name']) ||
    empty($_POST['contact-email'])
) {
	
	if( empty($_POST['contact-name']) && empty($_POST['contact-email']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );		
	} else {

		$fields = "";
		if( !isset( $_POST['contact-name'] ) || empty( $_POST['contact-name'] ) ) {
			$fields .= "Name";
		}
		
		if( !isset( $_POST['contact-email'] ) || empty( $_POST['contact-email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Email";
			} else {
				$fields .= ", Email";
			}
		}
		
		$json_arr = array( "type" => "error", "msg" => "Please fill ".$fields." fields!" );
		echo json_encode( $json_arr );		
	
	}

} else {

	// Validate e-mail
	if (!filter_var($_POST['contact-email'], FILTER_VALIDATE_EMAIL) === false) {
		
		$msg = "Name: ".$_POST['contact-name']."\r\n";		
		$msg .= "Email: ".$_POST['contact-email']."\r\n";
		if( isset( $_POST['contact-phone'] ) && $_POST['contact-phone'] != '' ) { $msg .= "Phone: ".$_POST['contact-phone']."\r\n"; }
		if( isset( $_POST['textarea-message'] ) && $_POST['textarea-message'] != '' ) { $msg .= "Message: ".$_POST['textarea-message']."\r\n"; }
		
		$success = @mail($mailTo, $_POST['contact-email'], $msg, 'From: ' . $_POST['contact-name'] . '<' . $_POST['contact-email'] . '>');
		
		if ($success) {
			$json_arr = array( "type" => "success", "msg" => $successMsg );
			echo json_encode( $json_arr );
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Please enter valid email address!" );
		echo json_encode( $json_arr );	
	}

}