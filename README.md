# AJAX JSON PHP Contact Form (with Bootstrap 3.3.7 CSS) v1.0.0 (@ /JuggerGrimrod/ajax-php-contact-form)

## This Git repository contains markup, style and script file assets, and a sample dataFile.csv for a feature-rich, responsive, cross-browser, AJAX JSON PHP contact form.

This contact form was built to fulfill the needs of a website using AJAX, JSON, PHP and Bootstrap 3.3.7 CSS for layout and UI elements.

The form includes the following elements and options:

* ### HTML form /index.html file: 
  This file contains links to local **JS/jQuery** and **CSS** assets (default), and CDN links to **JS/jQuery** and **CSS** assets (optional):
  * **Responsive design** using **Bootstrap 3.3.7 CSS** layout, form and error UI elements via **/css/bootstrap.min.css**.
  * Link to local custom CSS pointing to the **/css/styles.css** file.
  * Link to local jQuery 2.0.3 library file pointing to the **/js/jquery.min.js** file.
  * Hidden form input fields for **date** and **time** data.
  * **US/CANADA state/province** SELECT field (default) and **US-only state** SELECT field (optional).
  * TEXTAREA character counter display container in **/index.html on line 205**.
  * Success message (below the form) and Error message (below each invalid form field) displays.
  * Form file max-length values are enforces in each relevant input field via *maxlength=""* attributes, and in **/processor.php** via each field's validation REGEX strings. 
  * **Opt-In** checkbox, **required to submit the form** (for cases where something like 'Terms & Conditions' must be viewed/checked and user-acknowledgement captured before the user may continue).
  * CDN (Content Delivery Network) assets:
    * **netdna.bootstrapcdn.com** Bootstrap 3.3.7 minified css file.
    * **ajax.googleapis.com** jQuery v2.0.3 minified library file.


* ### HTML thank-you response /thankyou.html file (optional):
  This file demonstrates the optional presentation of a 'thank you' success message via page-level redirect.  This option is activated in **/js/handler.js on line 138 (uncomment line 138, and comment out line 129 where the on-page success message is enabled by default)**.


* ### JS/jQuery /js/scripts.js file:
  This file enforces TEXTAREA character limit and corresponding error messaging via the *taLimit()* function, and performs date and time retrieval and formatting via the *getDT()* function:
  * Configurable **date** and **time** data *getDT()* function for submission timestamps with US (default) and CANADA (optional) date formatting in **/js/scripts.js on lines 6 - 39**.
  * **onkeyup** client-side TEXTAREA character counter with color-coded **remaining** and **over the limit** labels in **/js/scripts.js on lines 45 - 62**:
    * **#ccff00** (green) indicates TEXTAREA length is *within* the max character limit.
    * **#ff0000** (red) indicates TEXTAREA length *exceeds* the max character limit.
  * Configurable client-side TEXTAREA character limiter function *taLimit()* in **/js/scripts.js on lines 67 - 76**:
    * **512 character limit (default)**, can be adjusted to suit developer's requirements
    * **onblur** error message display animation, warning users if their message size exceeds the character limit. 


* ### Custom CSS file at **/css/styles.css**.  


* ### AJAX JSON /js/handler.js file:
  This client-side submission event handling file uses AJAX to create and POST a JSON data object to **/processor.php** and defines error display container elements:
  * UI alerts and console logging for development and debugging purposes:
    * AJAX *.done()* data function *console.log(data)* in **/js/handler.js on line 50**.
    * AJAX *.done()* data function *alert('success')* in **/js/handler.js on line 132**.
    * AJAX *.fail()* data function *console.log(data)* in **/js/handler.js on line 146**.
  * On-page submission success message display (default) container defined in **/js/handler.js on line 129**.  
  * Form fields cleared of user data on successful submission:
    * Implemented via *.reset()* function in **/js/handler.js on line 135**.
  * Page-level redirect on successful submission (optional):
    * Implemented via *window.location* in **/js/handler.js on line 138** (uncomment line 138 to use it, and remember to turn off the on-page success messaging display by commenting-out line 129).


* ### PHP /processor.php file:
  This is a server-side form-field validation and data-management file:
  * **$_POST** *$data* array created from **/index.html** form-fields (*$date, $time, $salutation, $firstname, $lastName, $email, $email2, $phone, $address1, $address2, $city, $state, $postalCode, $age, $commentType, $comments, $agreeToTerms*).
  * **Required** validation, so incomplete forms cannot be submitted or processed.
  * **Form fields secured from injection attacks** via PHP's **FILTER_SANITIZE_STRING** method. 
  * Robust **regular expressions (REGEX)** for multilingual form-field validation:
    * Includes **REGEX for US and CANADA zip/postal codes** in **/processor.php on lines 101 to 103**.
    * Includes **REGEX for multilingual special language characters (e.g.: áàâÁÀÂ éèêëÉÈÊË íîïÍÎÏ óôÓÔ ùúûüÙÚÛÜ çÇ ñÑ ÿŸ æÆ œŒ ß)** such as those used in French (FR), German (DE) and Spanish (ES) via the **\p{L}** and **/u** REGEX methods for *$firstname, $lastName, $address1, $address2* and *$city* fields in **/processor.php on lines 26, 35, 68, 77 and 86**.
    * **Non-English (EN) special language characters will NOT validate within the $email field.**
    * **English (EN) REGEX strings (optional) are commented out at the end of each of those lines if you require English-only form data handling.**   
  * IP Address data element, pulled from *$_SERVER['REMOTE_ADDR']* (present in email response options only).
  * Data-object handling options:
    * **.csv data-file** submission storage on server (i.e. *dataFile.csv*), with options to write ('w') or append ('a') in **/processor.php on lines 151 to 156**. The sample data file is populated with test examples from seven browsers using dummy data.  Instances of "link", "bold" and "italic" represent HTML form data that was altered via the PHP strip_tags() method in **/processor.php on line 125**.
    * **html email** data fulfillment: 
      * **html email output is defined in /processor.php on lines 160 - 217** and is set as an HTML table to 100% email client viewport width.  Additionally, a placeholder image is set in the top of the table, using an image pulled from https://placeholder.com.  To see your logo image within the email output, you must link the <IMG /> tag therein to an image file on your server via an absolute URL pointing to the image asset.
      * **html Content-type header must be set in /processor.php on line 250 (default UTF-8) or line 251 (optional ISO-8859-1)**.
    * **plain-text email** data fulfillment:
      * **plain-text email output is defined in /processor.php on lines 220 - 237**.
      * **plain-text Content-type header must be set in /processor.php on line 252**.
    * Email *$to, $from, $subject and $headers* definitions are set in **/processor.php on lines 240 - 258**.
    * **A NOTE about your mailserver:** to avoid issues with cross-domain, same-origin policy rules and email spam filters, it is recommended that your test *$to* and *$from* email addresses defined in **/processor.php** utilize email accounts belonging to the server/domain from which you are testing/running the form.  Failure to follow this recommendation will likely result in no emails being sent by your designated *$from* email account or received by your designated *$to* email account.  	
  * All form field error messages (required and validation), are defined throughout **/processor.php**.
  * The on-page submission success message is enabled by default, and is defined as *$data['message']* in **/processor.php on line 267**.
  * PHP error reporting enabled in **/processor.php on line 5** via the *error_reporting(E_ALL);* method.

* ### jQuery 2.0.3 library file at **/js/jquery.min.js**.

* ### Bootstrap 3.3.7 CSS file at **/css/bootstrap.3.3.7.min.css**.  

* ### Bootstrap 3.0.3 CSS file at **/css/bootstrap.3.0.3.min.css** (optional):
  * This form was also tested with Bootstrap 3.0.3 CSS without issue.  To use this version of Bootstrap CSS, just change the local css filename reference in **/index.html on line 11*.   

* ### File Permissions: 
  * The parent directory on your server where you are running the form from should have permissions set to 755.    
    * **index.html** and **thankyou.html** file permissions should be set to 664.
    * **processor.php** file permissions should be set to 755 (if permissions on this file are set to lower values, the form will not submit and you will probably see *404 file not found* errors in your developer console when testing a form submission).
    * **dataFile.csv** file permissions should be set to 644.
  * **/css** and **/js** directory permissions should be set to 755.
  * **/css** and **/js** directory contents (all .js and .css files) should have permissions set to 664.

This contact form was tested from a production Linux server running PHP v5.6.33 in Chrome 63.0.3239.132, Firefox 57.0.4, IE Edge, IE10 and IE9 (emulated via IE Edge console), Windows Safari 5.1.7 (lol...but seriously, this obsolete Safari browser still retains some value as a sort of 'indicator-species': when 'normal' or 'routine' layout and display features fail in Windows Safari, they're likely also fail in iOS Mobile Safari, which is handy for developers who don't have access to a Mac), iOS Mobile Safari via iPad Air 2, and Android Chrome.

### COMMENTS GALORE: Comments appear throughout each of the contact form's asset files; if you need to figure out what a given element is doing, chances are very good that there are comments explaining in detail what is going on with each component within each file.

Future enhancements for this contact form may include:

  * **reCAPTCHA** (a commented-out placeholder div container for reCAPTCHA is in **/index.html on lines 228 - 234**).
  * Foreign language character validation for the *$email* and *$email2* fields, both of which currently utilize the PHP FILTER_VALIDATE_EMAIL method using only English (EN) characters.
  * **MySQL database storage option**.
  * Eventual migration to **Bootstrap 4.0.x**.

That's it.  Enjoy!

##  AJAX JSON PHP Contact Form (with Bootstrap 3.3.7 CSS) README.md file v1.0.0 

### Free to all via GNU General Public License v3.0

- - -

## Change Log

* v1.0.0 posted to Github on 2/8/2018
