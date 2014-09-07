![cat signal](http://internetdefenseleague.org/images/vector/city_bat_signal.png)
#Internet Defense League Cat Signal

Contributors: jazzs3quence
Donate link: https://coinbase.com/checkouts/64d7bc3204fb355ff92f4c47b48cfa87
Tags: internet defense league, activism, cat signal, freedom, online activism
Requires at least: 2.7
Tested up to: 4.0
Stable tag: 1.1

A WordPress plugin to automatically load either the modal or the banner Cat Signal when there is an active campaign from the Internet Defense League.

## Description

The Internet Defense League is an online activist group organized to defend your online freedoms. When a bill is threatening to pass that would inhibit the way you live your online life, they put up the Cat Signal, a way to collectively black out or put notices on a large number of websites simultaneously.

This plugin adds the javascript for the Cat Signal to your site so you don't need to mess with the code. It's enqueued like any other javascript file and has an options page to select either the banner or the modal window option.

The current action centers around the Internet Slowdown campaign, to protest against cable companies that want to inhibit your browsing experience by enabling a "fast-lane" where service providers (like YouTube and Netflix) get priority access to faster speeds for a fee. Learn more on the [Battle for the Net](https://www.battleforthenet.com/sept10th/) site. This campaign will run for one day on September 10th.

### About this plugin

At first glance, it may appear that the plugin isn't doing anything because you don't have a banner or a modal window. *Don't panic!!!* What this means is that all is safe in Gotham and the Cat Signal has not been activated (read: there probably isn't an active IDL campaign running). To keep up to date on Internet Defense League campaigns, I recommend signing up for their mailing list (ed. note: I'm not affiliated with them at all, I'm just your friendly neighborhood internet activist). Once you're on the list, you'll get emails when they're about to launch a campaign.

**So how do I know if it's working?**
If you're savvy, you can check the HTML source of your site and check that either the `modal.js` or `banner.js` is loading. If it is, you're good to go, and the banner or modal window will work automagically when the IDL launch a new campaign.

You can also add `?_idl_test=1` to the end of any page URL configured to display the alert. This will display a banner or modal in the style of the actual alert while not actually displaying a pretty banner or graphic.

## Installation

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

## Screenshots

![modal window](https://github.com/jazzsequence/Cat-Signal/raw/master/screenshot-1.png)
1. Modal option

![banner](https://raw.github.com/jazzsequence/Cat-Signal/master/screenshot-2.png)
2. Banner option

![options page](https://raw.github.com/jazzsequence/Cat-Signal/master/screenshot-3.png)
3. Options page


## Changelog
**1.1**
- removed Stop the Secrecy option
- removed the idl_test (temporarily, see [developer thread](https://groups.google.com/d/msg/internetdefenseleague/7OWDjdEDwJ0/HX1MBpjnbr8J))
- tested with WordPress 4.0
- added plugin icon

**1.0.9**
- fixed the fatal error on activation for PHP < 5.3

**1.0.8**
- added widget for [Stop the Secrecy](https://openmedia.org/stopthesecrecy/resources) campaign. May be used later for other campaigns.

**1.0.6**
- fixed banner/modal bug (saved option was getting stripped in the validation function)
- moved IDL banner locally

**1.0.5**
- fixes validation _doing_it_wrong()

**1.0.4**
- Fixed open `<div>` tag
- added an option to define where the alert appears
- added link to test that the script is working

**1.0.3**
- Removed `die` function that was making the page quit if no option was set. Reported [here](http://wordpress.org/support/topic/not-working-on-my-site-3) and [here](http://wordpress.org/support/topic/indexphp-quits-after-wordpress-meta-tag).

**1.0.2**
- Changed how the validation pulled the options

**1.0.1**
- added validation function

**1.0**
- Initial release.