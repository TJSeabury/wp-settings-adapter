<?php

namespace ArdentIntent\WpSettingsAdapter\models;

/**
 * @param PageOptions $pageOptions The root page options.
 * @param string $section (required) The slug-name of the section of the settings page in which to show the box.
 * @param string $group (required) The unprefixed field group. Used to register the settings field.
 * @param string $id (required) The unprefixed field id. Used to register the settings field.
 * @param	string $type (required) The type of field. Used to get the field view.
 * @param string $description (required) The field description.
 */
class SettingOptions
{
  public PageOptions $pageOptions;

  public string $section;
  public string $group;
  public string $id;
  public string $type;
  public string $options_group;
  public string $options_id;
  public string $display_name;
  public string $description;

  public function __construct(
    PageOptions $pageOptions,
    string $section,
    string $group,
    string $id,
    string $type,
    string $description
  ) {
    $this->pageOptions = $pageOptions;
    $this->section = $section;
    $this->group = $group;
    $this->id = $id;
    $this->type = $type;
    $this->options_group = "{$pageOptions->slug}_{$group}";
    $this->options_id = "{$pageOptions->slug}_{$id}";
    $this->display_name = ucwords(str_replace(['_', '-'], ' ', $id));
    $this->description = $description;
  }
}
