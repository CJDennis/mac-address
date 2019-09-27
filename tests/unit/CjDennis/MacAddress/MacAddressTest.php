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

  public function testShouldGetAFakeMacAddressWhenTheSystemHasNone() {
    MacAddressSeam::set_override_system();
    $mac_address_hex = MacAddressSeam::mac_address_hex();
    $this->assertRegExp('/^[\da-f][13579bdf](?:-[\da-f]{2}){5}$/i', $mac_address_hex);
  }

  public function testShouldGetAWindowsMacAddressFromTheMocker() {
    $mac_address_windows_mock = new MacAddressWindowsMock();
    $mac_address_windows_mock->output(<<<OUTPUT

65-67-CD-05-F7-DC   Media disconnected
86-6A-13-82-2A-47   Media disconnected
4D-40-9E-D8-71-03   \Device\Tcpip_{BE1196AC-789C-4C88-AEDB-60F396CFFEB6}
93-6E-51-EA-79-C7   Media disconnected
C9-7C-8E-0C-9A-A5   \Device\Tcpip_{1DCC5F79-E47D-40CC-B002-ED81C7F4160E}
41-4F-9B-59-3D-C6   Media disconnected
OUTPUT
    );
    $this->assertSame('4D-40-9E-D8-71-03', $mac_address_windows_mock->mac_address_hex());
  }
}
