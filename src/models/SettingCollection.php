<?php

namespace ArdentIntent\WpSettingsAdapter\models;

use ArdentIntent\WpSettingsAdapter\facades\settings\Setting;

class SettingCollection extends AbstractTypedArray
{
  const ARRAY_TYPE = Setting::class;
}
