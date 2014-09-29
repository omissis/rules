<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor\LowercaseTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\RulesDataProcessor\Lowercase;

/**
 * @coversDefaultClass \Drupal\rules\RulesDataProcessor\Lowercase
 * @group rules
 */
class LowercaseTest extends RulesUnitTestBase {
  /**
   * @dataProvider stringsProvider
   */
  public function testTrim($expectedMatchResult, $string) {
    $processor = new Lowercase([], 'rules_data_processor_lowercase', []);

    $this->assertSame($expectedMatchResult, $processor->process($string));
  }

  public function stringsProvider() {
    return array(
      array('foo', 'foo'),
      array('foo', 'FOO'),
      array('foo ', 'fOo '),
    );
  }
}
