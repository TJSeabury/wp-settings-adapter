<?php

namespace ArdentIntent\WpSettingsAdapter\models\settings;

use ArdentIntent\WpSettingsAdapter\models\AbstractEnum;

final class SettingTypes extends AbstractEnum
{
  const TEXT = 'text';
  const TOGGLE = 'toggle';
  const SELECT = 'select';
  const COLOR = 'color';
}
