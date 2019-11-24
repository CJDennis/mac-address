<?php
namespace CJDennis\MacAddress;

class MacAddressOsSeam extends MacAddress {
  public const OPERATING_SYSTEM = null;

  protected static $output_lines;

  protected static function os_name() {
    return static::OPERATING_SYSTEM;
  }

  public static function output($output) {
    static::$output_lines = preg_split('/\R/', $output);
  }

  protected static function system_output_lines($operating_system_type) {
    return static::$output_lines;
  }
}
