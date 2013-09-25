=== The City Plaza ===
Contributors: weshays
Tags: city, thecity, onthecity, plaza, acs
Requires at least: 2.8
Tested up to: 3.1
Stable tag: 0.8.4

Pull church needs, topics, events, prayers and albums from the Plaza so that you can use them within your WordPress site.


== Description ==

It is possible to pull church needs, topics, events, prayers and albums from the Plaza so that you can use them within your WordPress site.

Data pulled from The City is by default cached for 1 day (24 hours) so that subsequent requests are faster.  This is configurable should your needs be more frequent.


== Installation ==

Install from within WordPress:
<br>
Go to Plugins => Add New => search for "the city plaza".


Install manually:

1. Unzip the file you downloaded.

2. Upload files to a 'the-city-plaza' folder in the '/wp-content/plugins/' directory.

3. Log into your Wordpress admin and activate the plugin through the 'Plugins' menu.

4. In the widgets screen drag the widget to the content section you want it to show up in.

5. Set the fields as shown and then save.



== Frequently Asked Questions == 

= How do I get involved =

Visit our GitHub page and fork the project.
<br>
https://github.com/thecity/thecity-plaza-wordpress


= I found a bug =

Visit this projects GitHub page create an issue for the bug.
<br>
https://github.com/thecity/thecity-plaza-wordpress/issues


= I have a feature request =

Visit this projects GitHub page create an issue for the feature request.
<br>
https://github.com/thecity/thecity-plaza-wordpress/issues


== Screenshots ==

Here is the link to the description of the plugin:
http://developer.onthecity.org/thecity-plugins/wordpress/


== Upgrade Notice == 

None yet...


== Changelog ==

= 0.8.4 =
* Missed changing the order of priority for curl and fopen for the plugin. 0.8.3 only updated the thecity-plaza-php library.

= 0.8.3 =
* Changed the order of priority for curl and fopen.  Priority is now given to curl.
* Updated the PlazaPHP lib to the latest.

= 0.8.2 =
* Updated the check for allow_url_fopen.
* Updated the PlazaPHP lib to the latest.

= 0.8.1 =
* Changed where and when the cache table is created/rebuilt.  Now caching to the database really works.

= 0.8.0 =
* Updating caching to use the database instead of the file system.

= 0.7.1 =
* Fixed how cache key was generated.
* Updated how the URL was generated for pulling plaza data.

= 0.7.0 = 
* Added a field for group nickname to pull plaza items specific to that group.

= 0.6.1 =
* Added checks for different ways of getting data from the plaza.  If allow_url_fopen is disabled then an attempt will be made to use cURL.  If both are not available then an error message will be displayed.

= 0.6 =
* Added checkbox to clear the cache when the widget is saved.

= 0.5 =
* Added option to show all plaza items in the same list, which will show a mixture of items depending on the date created (or date "of" if item is an event).  The total number of items in the list will be limited to the number selected.
* Added option to display Plaza item type above title.  If date is also displayed the Plaza item type will show to the right of the date.  This was really meant to be used with the "Show All" option.

= 0.4 =
* Added option for number of items to display.  Up 15 items.

= 0.3 =
* Changed example link under subdomain field to reference OnTheCity.org.
* Moved dates to show before the link.
* Updated styling.
* Using a list instead of div tags.
* Events now show the data of the event rather then the date the event was created.

= 0.2 =
* Added date to list if available.
* Updated CSS to style the date.
* Added option to show dates item was posted.

= 0.1 =
* Initial release of the Plaza-Wordpress plugin.
