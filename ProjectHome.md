Project home of some [ImpressCMS](http://www.impresscms.org) modules like **'Album'**,  **'Downloads'**, **'Career'**, **'Visitorvoice'**, **'Guestbook'**, **'Article'**, **'Forms'**, **'Menu'**, **'Event'** & **'Icmspoll'**. The modules are using IPF and are optimized for ImpressCMS 1.3+.
For wishes in any module use the Ticket System here in Google Code, not assembla please.. All Modules have a Manual. If you're running into trouble check manual first.
# Module Descriptions #
## Album ##
**Album** is a gallery module for ImpressCMS. Each Album might have several Sub-Albums and several Images. All Albums are using the group permissions from core to keep the contained Images more private. Images can be watermarked and commented, if needed. Currently it's a bit community- and a bit commercial orientated. In the future I will go more to community based albums with more community related functions. Also the module currently is more php based, which will switch to an ajax based gallery.
## Guestbook and VisitorVoice ##
Both modules are the same - just different names- Both are Guestbooks for ImpressCMS, started in PHP and ported to be used more Ajax to load the page. Guests might be allowed or even not allowed to submit entries. Also it's possible to give moderate permissions to user groups.
## Event ##
**Event** is a calendar module for ImpressCMS. It's based on Arshaw's jquery fullCalendar Plugin, which has been ported to ImpressCMS. Google-Calendars are included, but only for fetching. For all others you can create several Calendar Categories with different view- and submit-permissions. Current Development state is 1.2 in trunk. The module can include ImpressCMS's profile module to share user birthdays or show up friends, which are currently joining the event. Now users also can comment Events and maybe later sharing events with friends.
## Menu ##
**Menu** is a very basic and easy-to-use menu-/navigation-builder Module for ImpressCMS. It comes up with two MegaMenus and some small basic menus for example. You can create as much navigation elements as needed, the same for navigation Links. Links are using core Permissions to make it possible keeping some links more private for special groups.
The menu module generates a new block position to include it fast into your theme.
## Icmspoll ##
**Icmspoll** is a poll module for ImpressCMS to deal with user polls/visitor polls. Polls can use multiple options and they're also using the group permissions.
Results can be printed or exported to pdf.