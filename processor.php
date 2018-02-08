<?php
// processor.php - server-side form data validation, error-reporting, data-proessing and email fulfillment

// php error reporting (set to E_ALL so the file will display any errors if something in the processor script blow up)
error_reporting(E_ALL);

$errors = array(); // array to hold validation errors
$data = array(); // array to pass form data

// validate the $_POST array variables
// required fields (if these aren't filled out by the user, add an error to the $errors array)
// regex validation (if input data is invalid, add an error to the $errors array)
// sanitize all text fields and the comments textarea

$_POST['date'] = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
$_POST['time'] = filter_var($_POST['time'], FILTER_SANITIZE_STRING);

if(isset($_POST['salutation']) && $_POST['salutation'] == '0'){
  $errors['salutation'] = 'Title selection is required.';       
}else{
  $_POST['salutation'] = filter_var($_POST['salutation'], FILTER_SANITIZE_STRING);  
}

if(empty($_POST['firstName'])){
	$errors['firstName'] = 'First Name is required.';
}elseif(!preg_match("/^[a-zA-Z\s\-\'\p{L}]{2,20}$/u",$_POST['firstName'])){ // EN only: "/^[a-zA-Z\s\-\']{2,20}$/"
	$errors['firstName'] = "Invalid <b>First Name</b>.  Letters, (-), (') and spaces only (2-20).";
}else{
  $_POST['firstName'] = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
  $_POST['firstName'] = htmlspecialchars_decode($_POST['firstName'], ENT_QUOTES);
}

if(empty($_POST['lastName'])){
	$errors['lastName'] = 'Last Name is required.';
}elseif(!preg_match("/^[a-zA-Z\s\-\'\p{L}]{2,20}$/u",$_POST['lastName'])){ // EN only: "/^[a-zA-Z\s\-\']{2,20}$/"
	$errors['lastName'] = "Invalid <b>last name</b>.  Letters, (-), (') and spaces only (2-20).";            
}else{
	$_POST['lastName'] = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
  $_POST['lastName'] = htmlspecialchars_decode($_POST['lastName'], ENT_QUOTES);
}

if(empty($_POST['email'])){
  $errors['email'] = 'Email Address is required.';
}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){                  
  $errors['email'] = "Invalid <b>email address</b>.  Valid: account@domain.com  Only letters, (-), (.), and (_) allowed.";
}else{
  $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
}

if(empty($_POST['email2'])){
  $errors['email2'] = 'Confirm Email Address is required.';
}elseif($_POST['email2'] !== $_POST['email']){                  
  $errors['email2'] = "<b>Email addresses do not match</b>. Check your email address and try again.";
}else{
  $_POST['email2'] = filter_var($_POST['email2'], FILTER_SANITIZE_EMAIL);
}

if(empty($_POST['phone'])){
	$errors['phone'] = 'Phone Number is required.';
}elseif(!preg_match("/^[0-9]{10}$/",$_POST['phone'])){
	$errors['phone'] = "Invalid <b>phone number</b>.  Numbers only (10).";
}else{
	$_POST['phone'] = filter_var($_POST['phone'], FILTER_SANITIZE_STRING); 
}

if(empty($_POST['address1'])){
  $errors['address1'] = 'Address 1 is required.';
}elseif((!empty($_POST['address1'])) && (!preg_match("/^[0-9a-zA-Z\s\-\'\p{L}]{7,30}$/u",$_POST['address1']))){ // EN only: "/^[0-9a-zA-Z\s\-\']{7,30}$/"
  $errors['address1'] = "Invalid <b>Address 1</b>.  Letters, numbers, (-), (') and spaces only (7-30 characters).";
}else{
  $_POST['address1'] = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
  $_POST['address1'] = htmlspecialchars_decode($_POST['address1'], ENT_QUOTES);
}

if(empty($_POST['address2'])){
  // do nothing, address2 is NOT required
}elseif((!empty($_POST['address2'])) && (!preg_match("/^[0-9a-zA-Z\s\-\'\p{L}]{4,30}$/u",$_POST['address2']))){ // EN only: "/^[0-9a-zA-Z\s\-\']{4,30}$/"
  $errors['address2'] = "Invalid <b>Address 2</b>.  Letters, numbers, (-), (') and spaces only (4-30 characters).";
}else{
  $_POST['address2'] = filter_var($_POST['address2'], FILTER_SANITIZE_STRING); 
  $_POST['address2'] = htmlspecialchars_decode($_POST['address2'], ENT_QUOTES);
}

if(empty($_POST['city'])){
  $errors['city'] = 'City is required.';
}elseif((!empty($_POST['city'])) && (!preg_match("/^[a-zA-Z\s\-\'\p{L}]{2,20}$/u",$_POST['city']))){ // EN only: "/^[a-zA-Z\s\-\']{2,20}$/"
  $errors['city'] = "Invalid <b>City</b>.  Letters, (-), (') and spaces only (2-20 characters).";
}else{
  $_POST['city'] = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
  $_POST['city'] = htmlspecialchars_decode($_POST['city'], ENT_QUOTES);
}

if(isset($_POST['state']) && $_POST['state'] == '0'){
  $errors['state'] = 'State/Province selection is required.';       
}else{
  $_POST['state'] = filter_var($_POST['state'], FILTER_SANITIZE_STRING);  
}

if(empty($_POST['postalCode'])){
  $errors['postalCode'] = 'Zip/Postal Code is required.';
}elseif(((!preg_match("/^([0-9]{5}(?:-[0-9]{4})?)*$/",$_POST['postalCode']))) && ((!preg_match("/^([ABCEGHJKLMNPRSTVXY][0-9][A-Z] [0-9][A-Z][0-9])*$/",$_POST['postalCode'])))){
  // CA: (!preg_match("/^([ABCEGHJKLMNPRSTVXY][0-9][A-Z] [0-9][A-Z][0-9])*$/",$_POST['postalCode']))
  // US: (!preg_match("/^([0-9]{5}(?:-[0-9]{4})?)*$/",$_POST['postalCode']))
  $errors['postalCode'] = "Invalid <b>Zip/Postal Code</b>.  US Zip Code Numbers and hyphens only (e.g. 12345 or 12345-6789).  CA Postal Code Numbers and spaces only (e.g. A1A 1A1).";
}else{
  $_POST['postalCode'] = filter_var($_POST['postalCode'], FILTER_SANITIZE_STRING); 
}

if(isset($_POST['age']) && $_POST['age'] == '0'){
  $errors['age'] = 'Age selection is required.';       
}else{
  $_POST['age'] = filter_var($_POST['age'], FILTER_SANITIZE_STRING);  
}

if(isset($_POST['commentType']) && $_POST['commentType'] == '0'){
  $errors['commentType'] = 'Comment type selection is required.';       
}else{
  $_POST['commentType'] = filter_var($_POST['commentType'], FILTER_SANITIZE_STRING);  
}

if(empty($_POST['comments'])){
	$errors['comments'] = 'Comments are required.';
}else{
	$_POST['comments'] = filter_var($_POST['comments'], FILTER_SANITIZE_STRING);
  $_POST['comments'] = strip_tags($_POST['comments']); // optional flag for stripping out HTML tags
  $_POST['comments'] = htmlspecialchars_decode($_POST['comments'], ENT_QUOTES); // optional flag for decoding single and double-quotes
}  

if(empty($_POST['agreeToTerms'])){
    $errors['agreeToTerms'] = 'You must agree to our Terms and Conditions.';
}else{
	$_POST['agreeToTerms'] = 'opted-in';
} 

// return a response
// if there are errors in the $errors array, return a 'success' boolean of false
if(!empty($errors)){
	// return the $errors in the array
	$data['success'] = false;
	$data['errors'] = $errors;
}else{
	// if there are no $errors, process the form $data (append to .csv file and send php mail), then return a message

	// .csv and mail processing - send validated form data to email addess
  if (!$errors){

    // send form output to data file first
    $data = array(
      array($_POST['date'], $_POST['time'], $_SERVER['REMOTE_ADDR'], $_POST['firstName'], $_POST['lastName'], $_POST['phone'], $_POST['email'], $_POST['email2'], $_POST['address1'], $_POST['address2'], $_POST['city'], $_POST['state'], $_POST['postalCode'], $_POST['age'], $_POST['commentType'], $_POST['comments'], $_POST['agreeToTerms'].PHP_EOL)
    );
    $fp = fopen('dataFile.csv', 'a'); // 'w' = write, 'a' = append
    foreach ($data as $fields) {
      //fputcsv($fp, $fields); // encapsulates string-data containing spaces with double-quotes
      fwrite($fp, implode(';',$fields)); // removes encapsulating double-quotes from string-data containing spaces
    }
    fclose($fp);

    // then send to email
    // for HTML email formatting use this
    $message = '
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
    <HTML><HEAD><TITLE>AJAX JSON PHP Contact Form (with Bootstrap 3.3.7 CSS)</TITLE>
    <META http-equiv=Content-Type content="text/html; charset=us-ascii">
    <META content="MSHTML 6.00.3790.1830" name=GENERATOR></HEAD>
    <BODY><table width="100%" border="0" cellpadding="5" style="font-family:arial,helvetica,sans-serif;font-size:14px;color:#000000;border:2px solid #333333;">
    <tr>
      <td colspan="2"><img src="http://via.placeholder.com/166x60" width="166" height="60" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" style="font-family:arial,helvetica,sans-serif;font-size:16px;color:#000000;">The information below was submitted via Contact Form:</td>
    </tr>
    <tr style="background-color:#cecece;">
      <td width="170" align="right"><b>Submitted:</b></td><td>' . $_POST['date'] . ' ' . $_POST['time'] . '</td>
    </tr>
    <tr style="background-color:#cecece;">
      <td align="right"><b>IP Address:</b></td><td>' . $_SERVER['REMOTE_ADDR'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Name:</b></td><td>' . $_POST['salutation'] . ' ' . $_POST['firstName'] . ' ' . $_POST['lastName'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Phone Number:</b></td><td>' . $_POST['phone'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Email Address:</b></td><td>' . $_POST['email'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Confirm Email Address:</b></td><td>' . $_POST['email2'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Address 1:</b></td><td>' . $_POST['address1'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Address 2:</b></td><td>' . $_POST['address2'] . '</td>
    </tr>             
    <tr>
      <td align="right"><b>City:</b></td><td>' . $_POST['city'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>State:</b></td><td>' . $_POST['state'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Postal Code:</b></td><td>' . $_POST['postalCode'] . '</td>
    </tr>
    <tr>
      <td align="right"><b>Age:</b></td><td>' . $_POST['age'] . '</td>
    </tr>
    <tr style="background-color:#cccccc;">
      <td align="right"><b>Comment Type:</b></td><td>' . $_POST['commentType'] . '</td>
    </tr>
    <tr style="background-color:#cccccc;">
      <td align="right"><b>Comments:</b></td><td>' . $_POST['comments'] . '</td>
    </tr>
    <tr style="background-color:#e8e8e8;">
      <td align="right"><b>Terms & Conditions Opt-In:</b></td><td>' . $_POST['agreeToTerms'] . '</td>
    </tr>    
    </table></body></html>';

    // for text/plain email formatting use this
    /*$message = "Submitted Date: ".$_POST['date']."\r"; 
    $message .= "Submitted Time: ".$_POST['time']."\r\r";
    $message .= "IP Address: ".$_SERVER['REMOTE_ADDR']."\r\r";
    $message .= "Salutation: ".$_POST['salutation']."\r";
    $message .= "First Name: ".$_POST['firstName']."\r"; 
    $message .= "Last Name: ".$_POST['lastName']."\r\r";
    $message .= "Phone Number: ".$_POST['phone']."\r";
    $message .= "Email Address: ".$_POST['email']."\r\r";
    $message .= "Confirm Email Address: ".$_POST['email2']."\r\r";
    $message .= "Address 1: ".$_POST['address1']."\r";
    $message .= "Address 2: ".$_POST['address2']."\r";
    $message .= "City: ".$_POST['city']."\r";
    $message .= "State: ".$_POST['state']."\r";
    $message .= "Postal Code: ".$_POST['postalCode']."\r\r";
    $message .= "Age: ".$_POST['age']."\r";
    $message .= "Comment Type: ".$_POST['commentType']."\r\r";
    $message .= "Comments: ".html_entity_decode($_POST['comments'],ENT_QUOTES)."\r\r";
    $message .= "Terms & Conditions Opt-In: ".$_POST['agreeToTerms'];*/

    // set origin address 
    $from = "contact@yourdomainname.com";
    $headers = "From: $from";

    // set subject  
    $subject = 'AJAX JSON PHP Contact Form (with Bootstrap 3.3.7 CSS)';

    // set the MIME-type verion
    $headers  = 'MIME-Version: 1.0' . "\n";

    // to send HTML and plain-text mail, the requisite Content-type header must be set
    $headers .= 'Content-type: text/html; charset=utf-8' . "\n"; 
    //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
    //$headers .= 'Content-type: text/plain; charset=utf-8' . "\n";

    // assign the return address 
    $headers .= 'From: YourDomainName.com <contact@yourdomainname.com>' . "\n"; 

    // set recipient email address
    $to  = 'webmaster@yourdomainname.com';                

    // send the mail
    mail($to, $subject, $message, $headers);    

  }

	// show a success message and provide success boolean variable of true
	$data['success'] = true;
	$data['message'] = '<b>Your information was submitted successfully.</b> Thank you for your interest, we appreciate your input!';  

}

// return all data to an AJAX call (NOT a 'return' - return would not provide JSON data)
echo json_encode($data);

?>