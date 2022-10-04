<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\PageOptions;
use ArdentIntent\WpSettingsAdapter\models\SectionCollection;
use ArdentIntent\WpSettingsAdapter\models\PageCollection;

class Page
{
  public PageOptions $options;
  private SectionCollection $sections;
  private PageCollection $subPages;

  public function __construct(
    PageOptions $options
  ) {
    $this->options = $options;
    $this->sections = new SectionCollection();
    $this->subPages = new PageCollection();
  }

  public function register()
  {
    add_action(
      'admin_init',
      function () {
        foreach ($this->sections as $section) {
          $section->register();
          foreach ($section->fields as $field) {
            $field->register();
          }
        }
      }
    );

    add_action(
      'admin_menu',
      function () {
        add_menu_page(
          $this->settings->title,
          $this->settings->title,
          $this->settings->capability,
          $this->settings->slug,
          $this->render(),
          $this->settings->icon,
          $this->settings->position
        );
      }
    );
  }

  private function render()
  {
    return function () {
      global $wp_settings_sections;

      if (!isset($wp_settings_sections[$this->settings->slug])) {
        return;
      }

      if (!current_user_can($this->settings->capability)) {
        return;
      }

      $type = ucwords($this->settins->type);
      $viewName = "Page.{$type}";

      echo Blade::getInstance()->render(
        $viewName,
        [
          'title' => $this->settings->title,
          'slug' => $this->settings->slug,
          'sections' => $wp_settings_sections,
        ]
      );
    };
  }

  public function withSections(array $sections): void
  {
    foreach (new SectionCollection($sections) as $section) {
      $this->sections[] = $section;
    }
  }

  public function withSubPages(array $subPages): void
  {
    foreach (new Pagecollection($subPages) as $subPage) {
      $this->subPages[] = $subPage;
    }
  }
}
