<?php

namespace ArdentIntent\WpSettingsAdapter\models;

/**
 * This is a work-around because we are still on php7.4 
 * and Enums are not available until php8.1. :c
 * This can probably be replaced when we switch to php8.1.
 */
abstract class AbstractEnum
{
  private static $constCacheArray = NULL;

  private static function getConstants(): array
  {
    if (self::$constCacheArray == NULL) {
      self::$constCacheArray = [];
    }
    $calledClass = get_called_class();
    if (!array_key_exists($calledClass, self::$constCacheArray)) {
      $reflect = new \ReflectionClass($calledClass);
      self::$constCacheArray[$calledClass] = $reflect->getConstants();
    }
    return self::$constCacheArray[$calledClass];
  }

  public static function asArray(): array
  {
    return self::getConstants();
  }

  public static function isValidName($name, $strict = false)
  {
    $constants = self::getConstants();

    if ($strict) {
      return array_key_exists($name, $constants);
    }

    $keys = array_map('strtolower', array_keys($constants));
    return in_array(strtolower($name), $keys);
  }

  public static function isValidValue($value, $strict = true)
  {
    $values = array_values(self::getConstants());
    return in_array($value, $values, $strict);
  }
}
