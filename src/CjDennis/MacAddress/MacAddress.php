<?php
namespace CjDennis\MacAddress;

use CjDennis\Random\Random;

class MacAddress {
  protected static $mac_address;
  protected static $fake_mac_address;

  public static function mac_address_hex() {
    if (static::$mac_address === null) {
      $connected_mac_addresses = static::system_mac_addresses();

      if (!$connected_mac_addresses) {
        static::$mac_address = static::fake_mac_address_hex();
      }
      else {
        static::$mac_address = substr($connected_mac_addresses[0], 0, 17);
      }
    }
    return static::$mac_address;
  }

  public static function fake_mac_address_hex() {
    if (static::$fake_mac_address === null) {
      static::$fake_mac_address = dechex(Random::random_int() | 0x0100) . Random::random_hex_bytes(4);
      static::$fake_mac_address = join('-', str_split(static::$fake_mac_address, 2));
    }
    return static::$fake_mac_address;
  }

  protected static function system_mac_addresses() {
    // TODO: Windows only! Universal method needed, or faker if none available
    exec('getmac /nh', $output, $return_code);
    $connected_mac_addresses = array_values(preg_grep('/^(.{17}) {3}(\S+)$/', $output));
    return $connected_mac_addresses;
  }
}
