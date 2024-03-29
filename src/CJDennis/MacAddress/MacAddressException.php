<?php
namespace CJDennis\MacAddress;

use CJDennis\Message\MessageException;

class MacAddressException extends MessageException {
  const INVALID_MAC_ADDRESS = 0x01;
  const INVALID_BINARY_STRING = 0x02;
  const DELIMITER_BLANK = 0x03;
  const DELIMITER_TOO_LONG = 0x04;
  const DELIMITER_WHITESPACE = 0x05;
  const DELIMITER_ALPHANUMERIC = 0x06;

  const MESSAGE = [
    self::INVALID_MAC_ADDRESS => 'The MAC address is invalid',
    self::INVALID_BINARY_STRING => 'The binary MAC address is invalid',
    self::DELIMITER_BLANK => 'The delimiter must not be blank',
    self::DELIMITER_TOO_LONG => 'The delimiter must be a single character',
    self::DELIMITER_WHITESPACE => 'The delimiter must not be whitespace',
    self::DELIMITER_ALPHANUMERIC => 'The delimiter must not be alphanumeric',
  ];
}
