<?php

namespace ArdentIntent\WpSettingsAdapter\models\settings;

use ArdentIntent\Blade\Blade;
use ArdentIntent\WpSettingsAdapter\Adapter;
use ArdentIntent\WpSettingsAdapter\models\SettingOptions;
use ArdentIntent\WpSettingsAdapter\interfaces\SettingRenderer;

class SelectView implements SettingRenderer
{
  public function __construct(SettingOptions $options)
  {
    $this->options = $options;
  }

  public function render()
  {
    return Blade::getInstance()->render(
      "Setting.Select",
      [
        'adapter' => Adapter::class,
        'options' => $this->options,
        'id' => $this->options->options_id,
        'desc' => $this->options->description,
      ]
    );
  }
}
