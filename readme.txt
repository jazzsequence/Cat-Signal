=== Internet Defense League Cat Signal ===
Contributors: jazzs3quence
Donate link: https://www.paypal.me/jazzsequence
Tags: internet defense league, activism, cat signal, freedom, online activism
Requires at least: 2.7
Tested up to: 5.0
Stable tag: 1.1.3

A WordPress plugin to automatically load either the modal or the banner Cat Signal when there is an active campaign from the Internet Defense League.

== Description ==

The [Internet Defense League](https://internetdefenseleague.org) is an online activist group organized to defend your online freedoms. When a bill is threatening to pass that would inhibit the way you live your online life, they put up the Cat Signal, a way to collectively black out or put notices on a large number of websites simultaneously.

This plugin adds the javascript for the Cat Signal to your site so you don't need to mess with the code. It's enqueued like any other javascript file and has an options page to select either the banner or the modal window option.

= Events Supported =

Some of the events supported by this plugin:

* [Internet Slowdown](https://www.battleforthenet.com/sept10th/) - 10 September, 2014
* [Save Net Neutrality](https://www.battleforthenet.com/july12/) - 12 July, 2017

= About the plugin =

At first glance, it may appear that the plugin isn't doing anything because you don't have a banner or a modal window. *Don't panic!!!* What this means is that all is safe in Gotham and the Cat Signal has not been activated (read: there probably isn't an active IDL campaign running). To keep up to date on Internet Defense League campaigns, I recommend signing up for their mailing list (ed. note: I'm not affiliated with them at all, I'm just your friendly neighborhood internet activist). Once you're on the list, you'll get emails when they're about to launch a campaign.

== FAQ ==

**This plugin isn't updated often. Did you abandon it?**

This plugin is a very simple implementation of the javascript code provided by the Internet Defense League to add their campaigns to your site when they go out. It does one thing — load the javascript — and nothing else. The actual code required to load said javascript from the IDL hasn’t changed, so there has been no need to update this plugin — as long as their code remains the same, this plugin will still work.

The Cat Signal plugin is what could be considered [“complete software”](https://engineering.hmn.md/how-we-work/philosophy/completion/). There’s nothing else that needs to be done. There are no new features it needs, it does only one thing and nothing else, it’s just done. The only thing that I would be doing with each update is editing the readme file to change the version of WordPress it’s been tested up to and that’s not particularly high on my list of priorities, unfortunately.

**How do I know if it's working?**

If you're savvy, you can check the HTML source of your site and check that either the `modal.js` is loading. If it is, you're good to go, and the banner or modal window will work automagically when the IDL launch a new campaign.

The `?_idl_test=1` test URL is no longer supported, sadly.


== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Screenshots ==

1. Modal option

2. Options page

== Upgrade Notice ==

= 1.1.3 =
- Removed support for banner option (does not appear to be used anymore).

== Changelog ==

= 1.1.3 =
- Tested on WordPress 5.0
- Removed banner option (no longer used)
- Updated modal javascript

= 1.1.2 =
- Compatibility bump
- Added FAQ
- Remove http check from js code
- Tweaked js
- Updated readmes

= 1.1.1 =
- version bump, no major changes

= 1.1 =
- removed Stop the Secrecy option
- removed the idl_test (temporarily, see [developer thread](https://groups.google.com/d/msg/internetdefenseleague/7OWDjdEDwJ0/HX1MBpjnbr8J))
- tested with WordPress 4.0
- added plugin icon

= 1.0.9 =
- fixed the fatal error on activation for PHP < 5.3

= 1.0.8 =
- added widget for [Stop the Secrecy](https://openmedia.org/stopthesecrecy/resources) campaign. May be used later for other campaigns.

= 1.0.6 =
- fixed banner/modal bug (saved option was getting stripped in the validation function)
- moved IDL banner locally

= 1.0.5 =
- fixes validation `_doing_it_wrong()`

= 1.0.4 =
- Fixed open `<div>` tag
- added an option to define where the alert appears
- added link to test that the script is working

= 1.0.3 =
- Removed `die` function that was making the page quit if no option was set. Reported [here](http://wordpress.org/support/topic/not-working-on-my-site-3) and [here](http://wordpress.org/support/topic/indexphp-quits-after-wordpress-meta-tag).

= 1.0.2 =
- Changed how the validation pulled the options

= 1.0.1 =
- Added validation function

= 1.0 =
- Initial release.
