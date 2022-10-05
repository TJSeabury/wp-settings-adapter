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
        || !isset($wp_settings_fields[$this->pageOptions->slug])
        || !isset($wp_settings_fields[$this->pageOptions->slug][$this->settings->title])
      ) {
        return;
      }

      $type = ucwords($this->settings->type);
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

  public function Setting(
    string $group,
    string $id,
    string $type = SettingTypes::TEXT,
    string $description = ''
  ): Setting {
    return new Setting(new SettingOptions(
      $this->options->pageOptions,
      $this->options->id,
      $group,
      $id,
      $type,
      $description
    ));
  }
}
