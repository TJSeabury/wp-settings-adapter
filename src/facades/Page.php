<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\PageOptions;
use ArdentIntent\WpSettingsAdapter\models\SectionCollection;
use ArdentIntent\WpSettingsAdapter\models\SubPageCollection;
use Closure;

class Page
{
  public PageOptions $options;
  private SectionCollection $sections;
  private SubPageCollection $subPages;

  public function __construct(
    PageOptions $options
  ) {
    $this->options = $options;
    $this->sections = new SectionCollection();
    $this->subPages = new SubPageCollection();
  }

  public function register(): void
  {
    \add_action(
      'admin_menu',
      function () {
        \add_menu_page(
          $this->options->title,
          $this->options->title,
          $this->options->capability,
          $this->options->slug,
          $this->render(),
          $this->options->icon,
          $this->options->position
        );

        foreach ($this->subPages as $subPage) {
          $subPage->register();
        }
      }
    );

    \add_action(
      'admin_init',
      function () {
        foreach ($this->sections as $section) {
          $section->register();
          foreach ($section->settings as $setting) {
            $setting->register();
          }
        }
      }
    );
  }

  private function render(): Closure
  {
    return function () {
      global $wp_settings_sections;

      if (!isset($wp_settings_sections[$this->options->slug])) {
        return;
      }

      if (!current_user_can($this->options->capability)) {
        return;
      }

      $type = ucwords($this->options->type);
      $viewName = "Page.{$type}";

      echo Blade::getInstance()->render(
        $viewName,
        [
          'title' => $this->options->title,
          'slug' => $this->options->slug,
          'description' => $this->options->description,
          'sections' => $wp_settings_sections[$this->options->slug],
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
    foreach (new SubPagecollection($subPages) as $subPage) {
      $this->subPages[] = $subPage;
    }
  }
}
