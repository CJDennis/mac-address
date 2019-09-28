<?php /** @noinspection PhpUnhandledExceptionInspection */
namespace CjDennis\MacAddress;

use CjDennis\Random\Random;

class MacAddress {
  protected const COMMANDS = [
    'WIN' => ['identifier' => '/^(Win).*/i', 'command' => 'getmac /nh', 'search' => '/^(.{17}) {3}\S+$/'],
    'LINUX' => ['identifier' => '/^(Linux).*/i', 'command' => 'ifconfig', 'search' => '/^.* HWaddr (\S+)$/'],
    'DARWIN' => ['identifier' => '/^(Darwin).*/i', 'command' => 'ifconfig', 'search' => '/^.* HWaddr (\S+)$/'],
  ];
  protected const MASK = 0xFCFF;
  protected const UNICAST = 0x0000;
  protected const MULTICAST = 0x0100;
  protected const UNIVERSAL = 0x0000;
  protected const LOCAL = 0x0200;

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
      static::$fake_mac_address = sprintf('%04X', static::random_short_int() & static::MASK | static::UNICAST | static::LOCAL) . strtoupper(static::random_hex_bytes(4));
      static::$fake_mac_address = join('-', str_split(static::$fake_mac_address, 2));
    }
    return static::$fake_mac_address;
  }

  protected static function random_short_int() {
    return Random::random_short_int();
  }

  protected static function random_hex_bytes($count) {
    return Random::random_hex_bytes($count);
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

  public static function format($mac_address, $delimiter = '-') {
    $mac_address = static::hex($mac_address);
    static::validate_delimiter($delimiter);
    return join($delimiter, str_split(strtoupper($mac_address), 2));
  }

  protected static function validate_delimiter($delimiter): void {
    if (strlen($delimiter) === 0) {
      throw MacAddressException::new(MacAddressException::DELIMITER_BLANK);
    }
    if (strlen($delimiter) > 1) {
      throw MacAddressException::new(MacAddressException::DELIMITER_TOO_LONG);
    }
    if (preg_match('/\s/', $delimiter)) {
      throw MacAddressException::new(MacAddressException::DELIMITER_WHITESPACE);
    }
    if (preg_match('/[^\W_]/', $delimiter)) {
      throw MacAddressException::new(MacAddressException::DELIMITER_ALPHANUMERIC);
    }
  }

  public static function is_unicast(string $mac_address) {
    $mac_address = static::hex($mac_address);
    return (hexdec(substr($mac_address, 0, 2)) & 0x01) === 0;
  }

  public static function binary($mac_address) {
    return hex2bin(static::hex($mac_address));
  }

  public static function hex($mac_address) {
    if (strlen($mac_address) > 8) {
      static::validate_hex($mac_address);
      $mac_address = preg_replace('/[^\dA-F]/i', '', $mac_address);
    }
    else {
      static::validate_binary($mac_address);
      $mac_address = bin2hex($mac_address);
    }
    return strtoupper($mac_address);
  }

  protected static function validate_hex(string $mac_address) {
    if (!(preg_match('/\A\s*[\da-f]{2}(?:\W*[\da-f]{2}){5}\s*\z/i', $mac_address))) {
      throw MacAddressException::new(MacAddressException::INVALID_MAC_ADDRESS);
    }
  }

  protected static function validate_binary($mac_address): void {
    if (strlen($mac_address) < 6) {
      throw MacAddressException::new(MacAddressException::INVALID_BINARY_STRING);
    }
    if (strlen($mac_address) > 6) {
      throw MacAddressException::new(MacAddressException::INVALID_BINARY_STRING);
    }
  }
}
