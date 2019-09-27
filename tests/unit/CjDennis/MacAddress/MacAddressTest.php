<?php
namespace CjDennis\MacAddress;

use Codeception\Test\Unit;
use UnitTester;

class MacAddressTest extends Unit {
  /**
   * @var UnitTester
   */
  protected $tester;

  protected function _before() {
    MacAddressSeam::set_mac_address(null);
    MacAddressSeam::set_fake_mac_address(null);
    MacAddressSeam::clear_override_system();
  }

  protected function _after() {
    MacAddressSeam::set_fake_mac_address(null);
    MacAddressSeam::clear_override_system();
  }

  // tests
  public function testShouldGetAMacAddressFromTheSystem() {
    $mac_address_hex = MacAddressSeam::mac_address_hex();
    $this->assertRegExp('/^[\dA-F]{2}(?:-[\dA-F]{2}){5}$/i', $mac_address_hex);
  }

  public function testShouldGetAFakeMacAddress() {
    $fake_mac_address_hex = MacAddressSeam::fake_mac_address_hex();
    $this->assertRegExp('/^[\da-f][13579bdf](?:-[\da-f]{2}){5}$/i', $fake_mac_address_hex);
  }
}
