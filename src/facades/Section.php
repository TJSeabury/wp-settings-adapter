<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\facades\Setting;
use ArdentIntent\WpSettingsAdapter\models\SectionOptions;
use ArdentIntent\WpSettingsAdapter\models\SettingCollection;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\models\settings\SettingTypes;

class Section
{
  private SectionOptions $options;
  public SettingCollection $settings;

  public function __construct(
    SectionOptions $options
  ) {
    $this->options = $options;

    $this->settings = new SettingCollection();
  }

  /**
   *
   */
  public function register()
  {
    \add_settings_section(
      $this->options->id,
      $this->options->title,
      $this->render(),
      $this->options->pageOptions->slug
    );
  }

  private function render()
  {
    return function () {

      global $wp_settings_fields;

      if (
        !isset($wp_settings_fields)
        || !isset($wp_settings_fields[$this->options->pageOptions->slug])
        || !isset($wp_settings_fields[$this->options->pageOptions->slug][$this->options->id])
      ) {
        return;
      }

      $type = ucwords($this->options->type);
      $viewName = "Section.{$type}";

      echo Blade::getInstance()->render(
        $viewName,
        [
          'title' => $this->options->title,
          'settings' => (array)$wp_settings_fields[$this->options->pageOptions->slug][$this->options->id],
        ]
      );
    };
  }

  public function withSettings(array $settings)
  {
    foreach (new SettingCollection($settings) as $setting) {
      $this->settings[] = $setting;
    }
  }

  /**
   * Create a new Setting associated with this section.
   * The default SettingType is text.
   * A different type may be set by invoking ->ofType()->{TYPE}(); 
   */
  public function createSetting(
    string $id,
    string $description = ''
  ): Setting {
    return new Setting(new SettingOptions(
      $this->options->pageOptions,
      $this->options->id,
      $this->options->id,
      $id,
      SettingTypes::TEXT,
      $description
    ));
  }
}
