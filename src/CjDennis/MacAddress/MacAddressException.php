<?php
namespace CjDennis\MacAddress;

use CjDennis\Message\MessageException;

class MacAddressException extends MessageException {
  const INVALID_MAC_ADDRESS = 0x01;
  const INVALID_BINARY_STRING = 0x02;
  const BLANK_DELIMITER = 0x03;

  const MESSAGE = [
    self::INVALID_MAC_ADDRESS => 'The MAC address is invalid',
    self::INVALID_BINARY_STRING => 'The binary MAC address is invalid',
    self::BLANK_DELIMITER => 'The delimiter must not be blank',
  ];
}
