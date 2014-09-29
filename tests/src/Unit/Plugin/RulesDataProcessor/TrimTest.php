<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor\TrimTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\RulesDataProcessor\Trim;

/**
 * @coversDefaultClass \Drupal\rules\RulesDataProcessor\Trim
 * @group rules
 */
class TrimTest extends RulesUnitTestBase {
  /**
   * @dataProvider stringsProvider
   */
  public function testTrim($expectedMatchResult, $string) {
    $processor = new Trim([], 'rules_data_processor_trim', []);

    $this->assertSame($expectedMatchResult, $processor->process($string));
  }

  public function stringsProvider() {
    return array(
      array('foo', 'foo'),
      array('foo', ' foo'),
      array('foo', 'foo '),
      array('foo', ' foo '),
      array('foo bar', ' foo bar '),
    );
  }
}
