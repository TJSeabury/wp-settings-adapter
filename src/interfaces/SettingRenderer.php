<?php

namespace ArdentIntent\WpSettingsAdapter\interfaces;

use ArdentIntent\WpSettingsAdapter\models\SettingOptions;

interface SettingRenderer
{
  public function __construct(SettingOptions $options);

  public function render();
}
