<?php
namespace CJDennis\MacAddress;

use PHPUnit\Framework\TestCase;

/** @covers \CJDennis\MacAddress\MacAddress */
class MacAddressTest extends TestCase {
  use MacAddressTestCommon;

  protected function setUp(): void {
    $this->_before();
  }

  protected function tearDown(): void {
    $this->_after();
  }
}
