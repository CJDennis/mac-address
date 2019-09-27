<?php
namespace CjDennis\MacAddress;

class MacAddressOsSeam extends MacAddress {
  public const OPERATING_SYSTEM = null;

  protected $output_lines;

  protected function os_name() {
    return static::OPERATING_SYSTEM;
  }

  public function output($output) {
    $this->output_lines = preg_split('/\R/', $output);
  }

  protected function system_output_lines($operating_system_type) {
    return $this->output_lines;
  }
}
