<?php
namespace CjDennis\MacAddress;

class MacAddressSeam extends MacAddress {
  protected static $override_system = false;

  public static function set_mac_address($mac_address) {
    static::$mac_address = $mac_address;
  }

  public static function set_fake_mac_address($fake_mac_address) {
    static::$fake_mac_address = $fake_mac_address;
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
