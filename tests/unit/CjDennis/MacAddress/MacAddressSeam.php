<?php
namespace CjDennis\MacAddress;

use CjDennis\Random\RandomSeam;

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
    return RandomSeam::random_short_int();
  }

  protected static function random_hex_bytes($count) {
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
}
