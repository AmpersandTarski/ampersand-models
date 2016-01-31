Messaging README
================

The purpose of the Messaging module is to allow the sending of messages from within prototype applications.

Sending messages from a prototype consists of two parts:
1) the creation of so-called 'contact endpoints' (concept `ContactEndpoint`, abbreviated as 'CEP'), i.e. records that can be linked to other atoms (e.g. persons, accounts, etc.), and that contain information about how to send messages (e.g. through email, pushover, SMS, etc.) and what address to use when doing so.
2) the creation of so-called 'message send requests' (concept `MsgSendReq`), i.e. records that contain:
  * a recipient (`msgRecipient`, required)
  * the message body (`msgMsgText`, required)
  * a message title (`msgMsgTitle`, optional)
  * a URL (`msgURLText`, optional)
  * a URL title (`msgURLTitle`, optional)
Each of these relations can be readily populated from a VIOLATION-statement by the ExecEngine. When the property-relation `msgSendReq` is set, the module will look for a CEP that is appropriately related to the recipient, and send the message through that channel. If the recipient has multiple such CEPs, the message will be sent through each of these channels.

Getting the module to work in a prototype requires that the `localSettings.php` file be edited, as follows:

* Enabeling contact endpoint validation (i.e. the stuff in the file `MSG_Validation.adl`) requires you to specify a URL that provides the web-page in which a user can type the validation code that has been sent to it. This would be a web-page that shows the `INTERFACE "MessageEndpoint"` (or something similar). The URL should replace the text 'http://MyPrototype/#/MyAccount' in the following line, that is to be included in `localSettings.php`:
  Config::set('url', 'msg_validation', 'http://MyPrototype/#/MyAccount');

* Enabling the sending of Email requires the following lines to be included in `localSettings.php`:
     require_once(__DIR__ . '/extensions/Messaging/Email.php');
     Config::set('sendEmailConfig', 'msg_email', array('from' => '<gmailaddr>', 'username' => '<gmailusername>', '<gmailpassword>' => ''));
  The arguments between sharp brackets '<' and '>' in the configuration line must be replaced with appropriate values, so as to instruct the extension to access the Gmail-account that is used for sending messages, as follows:
  - '<gmailaddr>': the Gmail-address associated with the Gmail-account
  - '<gmailusername>': the username that is needed to login to the Gmail-account 
  - '<gmailpassword>': the password that is needed to login to the Gmail-account. Note that if the gmail account uses 2-factor authentication, this password is application specific, and you have to get it from Google.
  
* Enabling the sending of Pushover messages requires the following lines to be included in `localSettings.php`:
     require_once(__DIR__ . '/extensions/Messaging/Pushover.php');
     Config::set('applicationToken', 'msg_pushover', '<apptoken>');
  The `<apptoken>` text must be replaced by a Pushover application token, that can be obtained from the Pushover website (https://pushover.net/). 

* Enabeling the sending of Pushalot messages requires the following lines to be included in `localSettings.php`:
     require_once(__DIR__ . '/extensions/Messaging/Pushalot.php');
