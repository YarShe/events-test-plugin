
## Introduction
The Event Banner Plugin is a WordPress plugin designed to enhance your website with custom event banners. With this plugin, you can easily create custom post types for events and display event banners using shortcodes.

## Installation
1. Download the Plugin: Download the Event Banner Plugin from the WordPress Plugin Directory or obtain the plugin files from another trusted source.
2. Install Dependencies:
- Before installing the plugin, make sure you have Composer and npm installed on your system.
- Navigate to the plugin directory using the command line.
- Run the following commands to install dependencies:
```bash
composer install
npm install
```

3.Activate the Plugin: Upload the plugin files to your WordPress plugins directory (wp-content/plugins/) and activate the Event Banner Plugin through the WordPress admin dashboard.
4.Frontend Customization: 
- After activating the plugin, you can customize the frontend by modifying the source files located in the plugin directory.
- Use Gulp to watch for changes in your frontend assets. Run the following command:
```bash
gulp watch_assets
```

## Getting Started
**Creating Events**
1. Navigate to the WordPress admin dashboard.
2. Click on "Events" in the sidebar menu.
3. Click on "Add New" to create a new event.
4. Fill in the event details such as title, description, date, and any other relevant information.
5. Optionally, assign event types using the "Event Type" taxonomy.


**Events List**
The Event Banner Plugin automatically creates an events list page at the /**events** URL on your WordPress site. This page displays a list of all events created using the plugin.

**Switching Between Horizontal and Vertical Views**
Users visiting the events list page have the option to switch between horizontal and vertical views of event banners.

*Horizontal View*: Displays event banners in a horizontal layout.
*Vertical View:* Displays event banners in a vertical layout.
**To switch between views:
**
Look for the view switcher option, typically located at the top or bottom of the page.
Click on the desired view option (horizontal or vertical).
The page will automatically update to display event banners according to the selected view.

**Displaying Banners**
The plugin provides a shortcode [event-sc] to display event banners on your website.

**Usage**:
```php
[event-sc id=<event_id> orientation=<orientation>]```

**Attributes:**

*id (required)*: The ID of the event you want to display.
orientation (optional): The orientation of the banner. Accepts either "vertical" or "horizontal". Defaults is "horizontal" if not specified.

**Examples:**

Display a horizontal banner for an event with ID 123:
```php
[event-sc id=123 orientation=horizontal]
```
Display a vertical banner for an event with ID 456:
```php
[event-sc id=456 orientation=vertical]
```

