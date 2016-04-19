=== Fortytwo - Two Factor Authentication ===
Contributors: Sebastien Lemarinel
Tags: 2fa, Two factor authentication, login, register
Requires at least: 4.4
Tested up to: 4.4
Stable tag: 1.0.0-RC11
License: MIT
License URI: https://opensource.org/licenses/MIT

Two factor Authentication plugin using Fortytwo.com service. This plugin add 2FA
on Register and Login.

== Description ==

Two factor Authentication plugin based on [Fortytwo.com](https://www.fortytwo.com/ "Your Preferred Messaging Solutions Partner") service. Add Two factor authentication for Login and register.

Features:

* Activate/Disabled Two Factor Authentication on Login/Register
* Manage trusted devices
* Activate Login Two factor authentication depending of the user roles
* Ability to resend SMS code (or not)

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

= 1.0.0-RC10 =
- [BUG] Fix phone number validation on register.
- [BUG] Fix various typos.
- [BUG] Fix code validation on register/login
- [BUG] Fix bug when we validate code after a fail on register.
- [BUG] Fix inconsistency on naming of authentication code.

= 1.0.0-RC9 =
- [BUG] Device was always setup as trusted.
- [BUG] Fix missing phone helper on edit user.
- [BUG] Fix nullable callbackurl.
- [BUG] Fix validation code after one fail.
- [BUG] Fix resend option on login.

= 1.0.0-RC8 =
- [BUG] Add missing jquery dependency on login
- [BUG] Fix Trusted device Activate/Disabled option
- [BUG] Fix naming convention for Authentication code
- [IMPROVEMENT] Update in code documentation
- [IMPROVEMENT] Adding field validation in the settings
- [BUG] Fix missing dependency - Jquery
- [BUG] Fix a typo on setting panel.
- [BUG] Fix a bug with the cookie path.

= 1.0.0-RC7 =
* Resend SMS no showing on login.
* Disable 2FA on register not working properly.

= 1.0.0-RC6 =
- Updating versions numbers

= 1.0.0-RC5 =
* Small fixes

= 1.0.0-RC4 =
* Fixing various bugs
* Adding screenshots for the wordpress plugin website

= 1.0.0-RC3 =
* Adding Assets and updating Readme file.
* Adding assets : banner and icons.

= 1.0.0-RC1 =
* Initial features - Release Candidate.
