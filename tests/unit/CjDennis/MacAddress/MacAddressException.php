<?php
namespace CjDennis\MacAddress;

use CjDennis\Message\MessageException;

class MacAddressException extends MessageException {
  const INVALID_MAC_ADDRESS = 0x01;

  const MESSAGE = [
    self::INVALID_MAC_ADDRESS => 'The MAC address is invalid',
  ];
}
