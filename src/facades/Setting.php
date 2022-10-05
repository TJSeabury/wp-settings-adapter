<?php

namespace ArdentIntent\WpSettingsAdapter\facades;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\interfaces\SettingRenderer;
use ArdentIntent\WpSettingsAdapter\factories\SettingRendererFactory;
use ArdentIntent\WpSettingsAdapter\models\settings\TypeHelper;

class Setting
{

  private SettingOptions $options;

  private SettingRenderer $view;

  public function __construct(SettingOptions $options)
  {
    $this->options = $options;

    $this->view = SettingRendererFactory::request(
      $this->options
    );
  }

  public function register()
  {
    \add_settings_field(
      $this->options->options_id,
      $this->options->title,
      $this->render(),
      $this->options->pageOptions->slug,
      $this->options->section,
      [
        'section' => $this->options->section,
        'group' => $this->options->options_group,
        'id' => $this->options->options_id,
        'type' => $this->options->type,
        'description' => $this->options->description
      ]
    );

    \register_setting(
      $this->options->pageOptions->slug,
      $this->options->options_id
    );
  }

  private function render()
  {
    return function () {
      echo Blade::getInstance()->render(
        "Setting.Wrap",
        [
          'options' => $this->options,
          'id' => $this->options->options_id,
          'title' => $this->options->title,
          'desc' => $this->options->description,
          'view' => $this->view
        ]
      );
    };
  }

  public function ofType(): TypeHelper
  {
    return new TypeHelper($this);
  }

  public function changeType(string $type): void
  {
    $this->options->type = $type;
    $this->view = SettingRendererFactory::request(
      $this->options
    );
  }

  public function withDefault($value): Setting
  {
    $this->options->defaultValue = $value;
    return $this;
  }

  public function withValues(array $values): Setting
  {
    $this->options->values = $values;
    return $this;
  }
}
