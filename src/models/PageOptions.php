<?php

namespace ArdentIntent\WpSettingsAdapter\models;

/**
 * The page options.
 * 
 * @param string $title (required) The text to be displayed in the title tags of the page when the menu is selected.
 * 
 * @param string $capability (required) The capability required for this menu to be displayed to the user.
 * 
 * @param string $slug (required) The slug name to refer to this menu by.
 * 		Should be unique for this menu page and only include lowercase alphanumeric, dashes, 
 * 		and underscores characters to be compatible with sanitize_key().
 * 
 * @param string $type (required) The type of menu page to be rendered.
 * 
 * @param string $icon (Optional) The URL to the icon to be used for this menu. 
 *     	- Pass a base64-encoded SVG using a data URI, which will be colored to match the color scheme. This should begin with 'data:image/svg+xml;base64,'. 
 *     	- Pass the name of a Dashicons helper class to use a font icon, e.g. 'dashicons-chart-pie'. 
 *     	- Pass 'none' to leave div.wp-menu-image empty so an icon can be added via CSS.
 * 
 *     	Default value: ''
 * 
 * @param int $position (Optional) The position in the menu order where this should appear.
 *     	Default value: null
 */
class PageOptions
{
  public string $title;
  public string $capability;
  public string $slug;
  public string $icon;
  public string $position;
  public string $type;

  public function __construct(
    string $title,
    string $capability,
    string $slug,
    string $type,
    string $icon = '',
    int $position = null
  ) {
    $this->title = $title;
    $this->capability = $capability;
    $this->slug = $slug;
    $this->type = $type;
    $this->icon = $icon;
    $this->position = $position;
  }
}
