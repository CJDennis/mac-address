<?php
namespace CjDennis\MacAddress;

class MacAddress {
  protected static $mac_address;
  protected static $fake_mac_address;

  public static function mac_address_hex() {
    if (static::$mac_address === null) {
      $connected_mac_addresses = static::system_mac_addresses();

      static::$mac_address = substr($connected_mac_addresses[0], 0, 17);
    }
    return static::$mac_address;
  }

  protected static function system_mac_addresses() {
    // TODO: Windows only! Universal method needed, or faker if none available
    exec('getmac /nh', $output, $return_code);
    $connected_mac_addresses = array_values(preg_grep('/^(.{17}) {3}(\S+)$/', $output));
    return $connected_mac_addresses;
  }
}
