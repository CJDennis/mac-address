<?php
namespace CJDennis\MacAddress;

use CJDennis\Random\RandomSeam;

class MacAddressSeam extends MacAddress {
  protected static $override_system = false;

  public static function set_mac_address($mac_address) {
    static::$mac_address = $mac_address;
  }

  public static function set_fake_mac_address($fake_mac_address) {
    static::$fake_mac_address = $fake_mac_address;
  }

  public static function random_bytes($bytes) {
    RandomSeam::set_bytes($bytes);
  }

  protected static function random_short_int() {
    parent::random_short_int();
    return RandomSeam::random_short_int();
  }

  protected static function random_hex_bytes($count) {
    parent::random_hex_bytes($count);
    return RandomSeam::random_hex_bytes($count);
  }

  public static function set_override_system() {
    static::$override_system = true;
  }

  public static function clear_override_system() {
    static::$override_system = false;
  }

  protected static function system_mac_addresses() {
    $system_mac_addresses = [];
    if (static::$override_system === false) {
      $system_mac_addresses = parent::system_mac_addresses();
    }
    return $system_mac_addresses;
  }

  protected static function system_output_lines(string $operating_system_type) {
    return parent::system_output_lines($operating_system_type);
  }

  protected static function operating_system() {
    return parent::operating_system();
  }

  protected static function os_name() {
    return parent::os_name();
  }

  protected static function validate_delimiter($delimiter): void {
    /** @noinspection PhpUnhandledExceptionInspection */
    parent::validate_delimiter($delimiter);
  }

  protected static function validate_hex(string $mac_address) {
    /** @noinspection PhpUnhandledExceptionInspection */
    parent::validate_hex($mac_address);
  }

  protected static function validate_binary($mac_address): void {
    /** @noinspection PhpUnhandledExceptionInspection */
    parent::validate_binary($mac_address);
  }
}
