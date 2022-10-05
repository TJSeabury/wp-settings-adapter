<?php

namespace ArdentIntent\WpSettingsAdapter\models;

/**
 * @param PageOptions $pageOptions (Required) The root page options.
 * 
 * @param string $id The section id. Used to register the section and to register settings fields.
 *
 * @param string $type (Required) The type of view to use for rendering.
 
 * @var string $title The formatted title of the section. Shown as the heading for the section.
 * 
 * @param string $description The section description.
 * 
 */
class SectionOptions
{
  public PageOptions $pageOptions;

  public string $id;
  public string $title;
  public string $type;
  public string $description;

  public function __construct(
    PageOptions $pageOptions,
    string $id,
    string $type = 'general',
    string $description = ''
  ) {
    $this->pageOptions = $pageOptions;
    $this->id = $id;
    $this->title = ucwords(str_replace(['_', '-'], ' ', $id));
    $this->type = $type;
    $this->description = $description;
  }
}
