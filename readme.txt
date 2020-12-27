=== Fortytwo - Two-Factor Authentication ===
Contributors: fortytwotele
Tags: 2fa, Two factor authentication, 2 factor authentication,  2 step authentication, 2-Factor, 2-step verification, login, register
Requires at least: 4.4
Tested up to: 5.6
Stable tag: 1.1.2
License: MIT
License URI: https://opensource.org/licenses/MIT

Fortytwo’s 2FA plugin controls access to your site by sending an authentication code via SMS to your mobile phone when you register or login.

== Description ==

= What is Two-factor Authentication? =

Authentication - the process of verifying your identity - boils down to one of three simple elements:

* Something the user knows (PIN, password)
* Something the user owns (mobile phone, device)
* Something the user is (biometric, retina, fingerprint)

[Two-factor Authentication](https://www.fortytwo.com/solutions/two-factor-authentication/) (2FA) is a combination of any two of these unique identifiers.

= How does our 2FA plugin work? =

With [Fortytwo](https://www.fortytwo.com)’s 2FA WordPress plugin, the user only requires the username and password to login to their site (as per any standard login sequence) and a mobile phone to receive the one-time authentication code via SMS.

Our plugin is fully customisable and can be adapted to meet your specific needs, for example, you can assign 2FA to certain users depending on their specific administrative roles in Wordpress and disable 2FA for users when they are using a known or ‘trusted’ device for a specific period of time. Fortytwo’s Wordpress 2FA plugin offers the unique advantage of providing a highly customisable authentication process for users and provides an additional level of security when and as required.

= What features does it include? =

Fortytwo’s WordPress plugin comes with a myriad of features including the option to:

* **activate or disable 2FA for registration and/or login** allowing the user to login using a username, password and 2FA or just a username and password
* **activate 2FA for login according to the user’s role in WordPress**, for example, you can disable 2FA for certain users such as subscribers while maintaining 2FA for users with critical roles
* **Activate 2FA as optional or mandatory option for users**, so you can give to your user the option to activate 2FA or force the option by default.
* **assign ‘trusted’ devices to specific users** allowing the user - after their initial 2FA login -  to validate their devices as ‘trusted’ for a specific time period, assigned by them in the settings. This option ensures that users aren’t required to enter an authentication code repeatedly with an assigned trusted device, after the initial 2FA login
* **resend the authentication code after registration** if the SMS was not received - this allows the user to request the authentication code after 60 seconds and/or change his phone number in the event that an incorrect phone number was submitted
* **resend the authentication code after login** if the SMS was not received - this allows the user to request the authentication code again after 60 seconds - this re-send option can also be disabled in the settings
* **to customize the behavior of the 2FA as [documented on the API](https://www.fortytwo.com/apis/two-factor-authentication/)** including changes to the authentication code length and type (numeric, alpha or alphanumeric), case sensitive validation, options to log a response via a callback URL and customise sender ID ‘s visible to the users

Fortytwo’s 2FA Wordpress plugin supports 2FA for all Smart phones (iPhone, Android, BlackBerry), as well as basic phones.

= Why use Fortytwo’s WordPress plugin? =

* **Security** Incorporating 2FA in to the user login process, creates a level of protection and security for your WordPress site that complex passwords can no longer guarantee
* **Customised functionality** This is our first version of the plugin and we’re keenly interested in your feedback.

If there is additional functionality that you would you like to see, please let us know - we are happy to work on developing features to meet your specific requirements and endeavor to implement this in as short a time-frame as possible.

== Installation ==

Installing "Fortytwo Two Factor Authentication plugin" can be done either by searching for "Fortytwo Two Factor Authentication" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org
1. Upload the ZIP file through the 'Plugins > Add New > Upload' screen in your WordPress dashboard
1. Activate the plugin through the 'Plugins' menu in WordPress

== Configuration ==

Once the plugin is activated you have to configure the plugin before use:

1. In the admin panel go to **Settings > Two Factor Authentication**
1. Enter the token you have from the [fortytwo control panel](https://controlpanel.fortytwo.com/)
1. Configure the other options accordingly to your needs
1. push the save button

**Note:** The Two factor authentication works only for the users who have the 2FA phone number on their profile.

== Frequently Asked Questions ==

= Where can I report a bug? =

The project is managed with Github. So you can report an issues on our [Repository](https://github.com/42Telecom/wordpress-plugin-two-factor-authentication "Fortytwo Two Factor Authentication").

== Screenshots ==

1. Setting panel
2. On Register
3. Input the SMS code
4. Resend the SMS code

== Changelog ==


## Version 1.1.1
_2016-12-22_
* **[IMPROVEMENT]** Support for Wordpress 4.6.X.
* **[IMPROVEMENT]** Don't call login_header if the function was disabled.

== Version 1.1.0 ==
_2016-10-04_
* **[IMPROVEMENT]** Support for Wordpress 4.6.X.
* **[IMPROVEMENT]** Update SDK dependencies.
* **[IMPROVEMENT]** Phone field rendering updated.
* **[IMPROVEMENT]** New API Paremeter : Message template to personalize the message sent with the 2FA Code.
* **[IMPROVEMENT]** New Mandatory option allowing to have 2FA option as optional or mandatory on login and/or on register.

== Version 1.0.8 ==
_2016-05-02_
* **[DOCUMENTATION]** Fix typo in the readme file.

* **[DOCUMENTATION]** Fix typo in the readme file.

= Version 1.0.7 =
_2016-05-02_
* **[BUG]** Update publish script to properly track/add new files and directory and untrack/delete deleted files.
* **[BUG]** Clean the SVN tree.

* **[BUG]** Update publish script to properly track/add new files and directory and untrack/delete deleted files.
* **[BUG]** Clean the SVN tree.

= Version 1.0.6 =
_2016-04-28_
* **[BUG]** Settings - Update "API Sensitive case" field ID.
* **[DOCUMENTATION]** Change "why" items to list.

* **[BUG]** Settings - Update "API Sensitive case" field ID.
* **[DOCUMENTATION]** Change "why" items to list.

= Version 1.0.5 =
_2016-04-26_
* **[IMPROVEMENT]** Update contributor id

* **[IMPROVEMENT]** Update contributor id

= Version 1.0.4 =
_2016-04-25_
* **[IMPROVEMENT]** Support for Wordpress 4.5

* **[IMPROVEMENT]** Support for Wordpress 4.5

= Version 1.0.3 =
_2016-04-25_
* **[DOCUMENTATION]** Add some tags on the presentation of the plugin.
* **[DOCUMENTATION]** Update the screenshots.
* **[DOCUMENTATION]** Update readme.txt description.

* **[DOCUMENTATION]** Add some tags on the presentation of the plugin.
* **[DOCUMENTATION]** Update the screenshots.
* **[DOCUMENTATION]** Update readme.txt description.

= Version 1.0.2 =
_2016-04-20_
* **[DOCUMENTATION]** Fix header description to feet in 150 characters

* **[DOCUMENTATION]** Fix header description to feet in 150 characters

= Version 1.0.1 =
_2016-04-20_
* **[DOCUMENTATION]** Update the readme.txt

* **[DOCUMENTATION]** Update the readme.txt

= Version 1.0.0 =
_2016-04-19_
* First stable version.

* First stable version.

= Version 1.0.0-RC11 =
_2016-04-19_
* **[BUG]** Fix error message when invalid token used.
* **[BUG]** Fix a typo.
* **[IMPROVEMENT]** Update readme.txt

* **[BUG]** Fix error message when invalid token used.
* **[BUG]** Fix a typo.
* **[IMPROVEMENT]** Update readme.txt

= Version 1.0.0-RC10 =
_2016-04-18_
* **[BUG]** Fix phone number validation on register.
* **[BUG]** Fix various typos.
* **[BUG]** Fix code validation on register/login
* **[BUG]** Fix bug when we validate code after a fail on register.
* **[BUG]** Fix inconsistency on naming of authentication code.

* **[BUG]** Fix phone number validation on register.
* **[BUG]** Fix various typos.
* **[BUG]** Fix code validation on register/login
* **[BUG]** Fix bug when we validate code after a fail on register.
* **[BUG]** Fix inconsistency on naming of authentication code.

= Version 1.0.0-RC9 =
_2016-04-14_
* **[BUG]** Device was always setup as trusted.
* **[BUG]** Fix missing phone helper on edit user.
* **[BUG]** Fix nullable callbackurl.
* **[BUG]** Fix validation code after one fail.
* **[BUG]** Fix resend option on login.

* **[BUG]** Device was always setup as trusted.
* **[BUG]** Fix missing phone helper on edit user.
* **[BUG]** Fix nullable callbackurl.
* **[BUG]** Fix validation code after one fail.
* **[BUG]** Fix resend option on login.

= Version 1.0.0-RC8 =
_2016-04-12_
* **[BUG]** Add missing jquery dependency on login
* **[BUG]** Fix Trusted device Activate/Disabled option
* **[BUG]** Fix naming convention for Authentication code
* **[IMPROVEMENT]** Update in code documentation
* **[IMPROVEMENT]** Adding field validation in the settings
* **[BUG]** Fix missing dependency * Jquery
* **[BUG]** Fix a typo on setting panel.
* **[BUG]** Fix a bug with the cookie path.

* **[BUG]** Add missing jquery dependency on login
* **[BUG]** Fix Trusted device Activate/Disabled option
* **[BUG]** Fix naming convention for Authentication code
* **[IMPROVEMENT]** Update in code documentation
* **[IMPROVEMENT]** Adding field validation in the settings
* **[BUG]** Fix missing dependency - Jquery
* **[BUG]** Fix a typo on setting panel.
* **[BUG]** Fix a bug with the cookie path.

= Version 1.0.0-RC7 =
_2016-04-06_
* **[BUG]** Resend SMS no showing on login.
* **[BUG]** Disable 2FA on register not working properly.

* **[BUG]** Resend SMS no showing on login.
* **[BUG]** Disable 2FA on register not working properly.

= Version 1.0.0-RC6 =
_2016-04-06_
* **[IMPROVEMENTS]** Updating versions numbers

* **[IMPROVEMENTS]** Updating versions numbers

= Version 1.0.0-RC5 =
_2016-04-04_
* **[IMPROVEMENTS]** Small fixes

* **[IMPROVEMENTS]** Small fixes

= Version 1.0.0-RC4 =
_2016-04-04_
* **[IMPROVEMENTS]** Fixing various bugs
* **[IMPROVEMENTS]** Adding screenshots for the wordpress plugin website

* **[IMPROVEMENTS]** Fixing various bugs
* **[IMPROVEMENTS]** Adding screenshots for the wordpress plugin website

= Version 1.0.0-RC3 =
_2016-04-01_
* **[IMPROVEMENTS]** Adding assets : banner and icons.

* **[IMPROVEMENTS]** Adding assets : banner and icons.

= Version 1.0.0-RC2 =
_2016-03-30_
* **[IMPROVEMENTS]** Update assets for Wordpress publication
* **[IMPROVEMENTS]** Add publish.sh file for publishing version on the SVN repo.

* **[IMPROVEMENTS]** Update assets for Wordpress publication
* **[IMPROVEMENTS]** Add publish.sh file for publishing version on the SVN repo.

= Version 1.0.0-RC1 =
_2016-03-24_
* **[IMPROVEMENTS]** : Add Readme.txt for wordpress repo and the icon image.
* **[IMPROVEMENTS]** : Updating documentation.
* **[FEATURES]** : Initial features.

* **[IMPROVEMENTS]** : Add Readme.txt for wordpress repo and the icon image.
* **[IMPROVEMENTS]** : Updating documentation.
* **[FEATURES]** : Initial features.
