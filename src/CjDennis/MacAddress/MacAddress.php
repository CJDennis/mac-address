<?php /** @noinspection PhpUnhandledExceptionInspection */
namespace CjDennis\MacAddress;

use CjDennis\Random\Random;

class MacAddress {
  const COMMANDS = [
    'WIN' => ['identifier' => '/^(Win).*/i', 'command' => 'getmac /nh', 'search' => '/^(.{17}) {3}\S+$/'],
  ];

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
    $operating_system_type = static::operating_system();
    $output = static::system_output_lines($operating_system_type);

    $connected_mac_addresses = array_values(preg_grep(static::COMMANDS[$operating_system_type]['search'], $output));
    $connected_mac_addresses = preg_replace(static::COMMANDS[$operating_system_type]['search'], '$1', $connected_mac_addresses);

    return $connected_mac_addresses;
  }

  protected static function system_output_lines(string $operating_system_type) {
    exec(static::COMMANDS[$operating_system_type]['command'], $output, $return_code);
    return $output;
  }

  protected static function operating_system() {
    $operating_system_type = static::os_name();
    $identifiers = array_map(function ($item) {
      return $item['identifier'];
    }, static::COMMANDS);
    $operating_system_type = preg_replace($identifiers, '$1', $operating_system_type);
    return strtoupper($operating_system_type);
  }

  protected static function os_name() {
    return php_uname('s');
  }
}
