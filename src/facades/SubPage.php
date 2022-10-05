<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\SubPageOptions;
use ArdentIntent\WpSettingsAdapter\models\SectionCollection;
use ArdentIntent\WpSettingsAdapter\facades\Section;
use ArdentIntent\WpSettingsAdapter\models\SectionOptions;
use Closure;

class SubPage
{
  public SubPageOptions $options;
  private SectionCollection $sections;

  public function __construct(
    SubPageOptions $options
  ) {
    $this->options = $options;
    $this->sections = new SectionCollection();
  }

  public function register()
  {
    \add_submenu_page(
      $this->options->parentSlug,
      $this->options->title,
      $this->options->title,
      $this->options->capability,
      $this->options->slug,
      $this->render(),
      $this->options->position
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

  public function createSection(
    string $id,
    string $type = 'general',
    string $description = ''
  ): Section {
    return new Section(new SectionOptions(
      $this->options,
      $id,
      $type,
      $description
    ));
  }

  public function withSections(array $sections): SubPage
  {
    foreach (new SectionCollection($sections) as $section) {
      $this->sections[] = $section;
    }
    return $this;
  }
}
