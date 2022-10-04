<?php

namespace ArdentIntent\WpSettingsAdapter\models;

use ArdentIntent\WpSettingsAdapter\facades\Section;

class SectionCollection extends AbstractTypedArray
{
  const ARRAY_TYPE = Section::class;
}
