<?php
/** @noinspection PhpUnused */
namespace CJDennis\MacAddress;

trait MacAddressTestCommon {
  protected function common_before() {
    MacAddressSeam::set_mac_address(null);
    MacAddressSeam::set_fake_mac_address(null);
    MacAddressSeam::clear_override_system();
  }

  protected function common_after() {
    MacAddressSeam::set_fake_mac_address(null);
    MacAddressSeam::clear_override_system();
  }

  // tests
  public function testShouldGetAMacAddressFromTheSystem() {
    $mac_address_hex = MacAddressSeam::mac_address_hex();
    $this->assertRegExp('/^[\dA-F]{2}(?:[-:][\dA-F]{2}){5}$/i', $mac_address_hex);
  }

  public function testShouldGetAFakeMacAddress() {
    $fake_mac_address_hex = MacAddress::fake_mac_address_hex();
    $this->assertRegExp('/^[\da-f][26ae](?:[-:][\da-f]{2}){5}$/i', $fake_mac_address_hex);
  }

  public function testShouldGetAFakeMacAddressWhenTheSystemHasNone() {
    MacAddressSeam::set_override_system();
    $mac_address_hex = MacAddressSeam::mac_address_hex();
    $this->assertRegExp('/^[\da-f][26ae](?:[-:][\da-f]{2}){5}$/i', $mac_address_hex);
  }

  public function testShouldGetAWindowsMacAddressFromTheMocker() {
    $mac_address_windows_mock = new MacAddressWindowsMock();
    /** @noinspection SpellCheckingInspection */
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

  public function testShouldGetALinuxMacAddressFromTheMocker() {
    $mac_address_linux_mock = new MacAddressLinuxMock;
    /** @noinspection SpellCheckingInspection */
    $mac_address_linux_mock->output(<<<OUTPUT
eth0      Link encap:Ethernet  HWaddr 9a:fa:c9:2d:40:a8
          inet addr:10.0.2.15  Bcast:10.0.2.255  Mask:255.255.255.0
          inet6 addr: fe80::a00:27ff:febb:9737/64 Scope:Link
          UP BROADCAST RUNNING MULTICAST  MTU:1500  Metric:1
          RX packets:277 errors:0 dropped:0 overruns:0 frame:0
          TX packets:245 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:1000
          RX bytes:23761 (23.7 KB)  TX bytes:36705 (36.7 KB)

lo        Link encap:Local Loopback
          inet addr:127.0.0.1  Mask:255.0.0.0
          inet6 addr: ::1/128 Scope:Host
          UP LOOPBACK RUNNING  MTU:65536  Metric:1
          RX packets:0 errors:0 dropped:0 overruns:0 frame:0
          TX packets:0 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:0
          RX bytes:0 (0.0 B)  TX bytes:0 (0.0 B)

OUTPUT
    );
    $this->assertSame('9a:fa:c9:2d:40:a8', ($mac_address_linux_mock)->mac_address_hex());
  }

  public function testShouldGetAMacOsMacAddressFromTheMocker() {
    $mac_address_mac_os_mock = new MacAddressMacOsMock;
    /** @noinspection SpellCheckingInspection */
    $mac_address_mac_os_mock->output(<<<OUTPUT
eth0      Link encap:Ethernet  HWaddr 9a:fa:c9:2d:40:a8
          inet addr:10.0.2.15  Bcast:10.0.2.255  Mask:255.255.255.0
          inet6 addr: fe80::a00:27ff:febb:9737/64 Scope:Link
          UP BROADCAST RUNNING MULTICAST  MTU:1500  Metric:1
          RX packets:277 errors:0 dropped:0 overruns:0 frame:0
          TX packets:245 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:1000
          RX bytes:23761 (23.7 KB)  TX bytes:36705 (36.7 KB)

lo        Link encap:Local Loopback
          inet addr:127.0.0.1  Mask:255.0.0.0
          inet6 addr: ::1/128 Scope:Host
          UP LOOPBACK RUNNING  MTU:65536  Metric:1
          RX packets:0 errors:0 dropped:0 overruns:0 frame:0
          TX packets:0 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:0
          RX bytes:0 (0.0 B)  TX bytes:0 (0.0 B)

OUTPUT
    );
    $this->assertSame('9a:fa:c9:2d:40:a8', $mac_address_mac_os_mock->mac_address_hex());
  }

  public function testFixMeShouldFailToGetAnOverlyLongLinuxMacAddressFromTheMocker() {
    $mac_address_linux_mock = new MacAddressLinuxMock;
    /** @noinspection SpellCheckingInspection */
    $mac_address_linux_mock->output(<<<OUTPUT
eth0      Link encap:Ethernet  HWaddr 9a:fa:c9:2d:40:a8:4f
          inet addr:10.0.2.15  Bcast:10.0.2.255  Mask:255.255.255.0
          inet6 addr: fe80::a00:27ff:febb:9737/64 Scope:Link
          UP BROADCAST RUNNING MULTICAST  MTU:1500  Metric:1
          RX packets:277 errors:0 dropped:0 overruns:0 frame:0
          TX packets:245 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:1000
          RX bytes:23761 (23.7 KB)  TX bytes:36705 (36.7 KB)

lo        Link encap:Local Loopback
          inet addr:127.0.0.1  Mask:255.0.0.0
          inet6 addr: ::1/128 Scope:Host
          UP LOOPBACK RUNNING  MTU:65536  Metric:1
          RX packets:0 errors:0 dropped:0 overruns:0 frame:0
          TX packets:0 errors:0 dropped:0 overruns:0 carrier:0
          collisions:0 txqueuelen:0
          RX bytes:0 (0.0 B)  TX bytes:0 (0.0 B)

OUTPUT
    );
    $this->assertSame('9a:fa:c9:2d:40:a8', ($mac_address_linux_mock)->mac_address_hex());
  }

  public function testShouldNotValidateAStringMacAddressNotInPairsOfHexDigits() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::INVALID_MAC_ADDRESS), function () {
      MacAddress::is_unicast('12-3A-D6-4BC-5-EF');
    });
  }

  public function testShouldNotValidateAStringMacAddressWithNonHexAlphanumericCharacters() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::INVALID_MAC_ADDRESS), function () {
      MacAddress::is_unicast('12-3A-D6-4B-C5-EG');
    });
  }

  public function testShouldOutputABinaryMacAddressFromAString() {
    $this->assertSame("\x12\x3A\xD6\x4B\xC5\xEF", MacAddress::binary('12-3A-D6-4B-C5-EF'));
  }

  public function testShouldOutputABinaryMacAddressFromAStringMacAddressWithPairsOfHexDigits() {
    $this->assertSame("\x12\x3A\xD6\x4B\xC5\xEF", MacAddress::binary('  12-  *3a: :D6  4Bc5-Ef   '));
  }

  public function testShouldOutputABinaryMacAddressFromABinaryString() {
    $this->assertSame("\x12\x3A\xD6\x4B\xC5\xEF", MacAddress::binary("\x12\x3A\xD6\x4B\xC5\xEF"));
  }

  public function testShouldVerifyAMacAddressIsUnicast() {
    $this->assertTrue(MacAddress::is_unicast('F0-FF-FF-FF-FF-FF'));
  }

  public function testShouldVerifyAMacAddressIsNotUnicast() {
    $this->assertFalse(MacAddress::is_unicast('F1-FF-FF-FF-FF-FF'));
  }

  public function testShouldVerifyAMacAddressIsUnicastFromABinaryString() {
    $this->assertTrue(MacAddress::is_unicast("\xF0\xFF\xFF\xFF\xFF\xFF"));
  }

  public function testShouldVerifyAMacAddressIsNotMulticastFromABinaryString() {
    $this->assertFalse(MacAddress::is_multicast("\xF0\xFF\xFF\xFF\xFF\xFF"));
  }

  public function testShouldVerifyAMacAddressIsMulticastFromAHexString() {
    $this->assertTrue(MacAddress::is_multicast('F1-FF-FF-FF-FF-FF'));
  }

  public function testShouldVerifyAMacAddressIsUniversalFromABinaryString() {
    $this->assertTrue(MacAddress::is_universal("\xF0\xFF\xFF\xFF\xFF\xFF"));
  }

  public function testShouldVerifyAMacAddressIsNotUniversalFromAHexString() {
    $this->assertFalse(MacAddress::is_universal('F2-FF-FF-FF-FF-FF'));
  }

  public function testShouldVerifyAMacAddressIsNotLocalFromABinaryString() {
    $this->assertFalse(MacAddress::is_local("\xF0\xFF\xFF\xFF\xFF\xFF"));
  }

  public function testShouldVerifyAMacAddressIsLocalFromAHexString() {
    $this->assertTrue(MacAddress::is_local('F2-FF-FF-FF-FF-FF'));
  }

  public function testShouldOutputAHexMacAddressFromABinaryString() {
    $this->assertSame('123AD64BC5EF', MacAddressSeam::hex("\x12\x3A\xD6\x4B\xC5\xEF"));
  }

  public function testShouldOutputAHexMacAddressFromAHexString() {
    $this->assertSame('123AD64BC5EF', MacAddress::hex("123aD64bC5Ef"));
  }

  public function testShouldThrowAnExceptionWhenPassedABinaryStringShorterThanSixBytes() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::INVALID_BINARY_STRING), function () {
      MacAddress::hex("\x12\x3A\xD6\x4B\xC5");
    });
  }

  public function testShouldThrowAnExceptionWhenPassedABinaryStringLongerThanSixBytes() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::INVALID_BINARY_STRING), function () {
      MacAddress::hex("\x12\x3A\xD6\x4B\xC5\xEF\x79\x08");
    });
  }

  public function testShouldOutputAFormattedMacAddressFromABinaryString() {
    $this->assertSame('12-3A-D6-4B-C5-EF', MacAddress::format("\x12\x3A\xD6\x4B\xC5\xEF"));
  }

  public function testShouldOutputAFormattedMacAddressFromAHexString() {
    $this->assertSame('12-3A-D6-4B-C5-EF', MacAddressSeam::format('123Ad64bC5eF'));
  }

  public function testShouldOutputAFormattedMacAddressFromAHexStringWithACustomDelimiter() {
    $this->assertSame('12:3A:D6:4B:C5:EF', MacAddress::format('123Ad64bC5eF', ':'));
  }

  public function testShouldThrowAnExceptionWhenTryingToOutputAFormattedMacAddressFromAHexStringWithABlankDelimiter() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::DELIMITER_BLANK), function () {
      MacAddress::format('123Ad64bC5eF', '');
    });
  }

  public function testShouldThrowAnExceptionWhenTryingToOutputAFormattedMacAddressFromAHexStringWithAMultipleCharacterDelimiter() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::DELIMITER_TOO_LONG), function () {
      MacAddress::format('123Ad64bC5eF', '::');
    });
  }

  public function testShouldThrowAnExceptionWhenTryingToOutputAFormattedMacAddressFromAHexStringWithAWhitespaceDelimiter() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::DELIMITER_WHITESPACE), function () {
      MacAddress::format('123Ad64bC5eF', ' ');
    });
  }

  public function testShouldThrowAnExceptionWhenTryingToOutputAFormattedMacAddressFromAHexStringWithANumericDelimiter() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::DELIMITER_ALPHANUMERIC), function () {
      MacAddress::format('123Ad64bC5eF', '9');
    });
  }

  public function testShouldThrowAnExceptionWhenTryingToOutputAFormattedMacAddressFromAHexStringWithAnAlphabeticDelimiter() {
    $this->compatibilityExpectException(MacAddressException::new(MacAddressException::DELIMITER_ALPHANUMERIC), function () {
      MacAddress::format('123Ad64bC5eF', 'x');
    });
  }

  public function testShouldOutputAFormattedMacAddressFromAHexStringWithDelimitedWithUnderscores() {
    $this->assertSame('12_3A_D6_4B_C5_EF', MacAddress::format('123Ad64bC5eF', '_'));
  }

  public function testShouldPadAllSingleDigitValuesWithALeadingZeroInFakeMacAddresses() {
    MacAddressSeam::random_bytes("\x00\x00\x00\x00\x00\x00");
    $this->assertSame('02-00-00-00-00-00', MacAddressSeam::fake_mac_address_hex());
  }

  public function testShouldSetTheBitsForLocalAndUnicastWhenGettingAFakeMacAddress() {
    MacAddressSeam::random_bytes("\xFF\xFF\xFF\xFF\xFF\xFF");
    $this->assertSame('FE-FF-FF-FF-FF-FF', MacAddressSeam::fake_mac_address_hex());
  }
}
