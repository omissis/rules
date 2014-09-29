<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor\TrimTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\RulesDataProcessor;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\RulesDataProcessor\NumericOffset;

/**
 * @coversDefaultClass \Drupal\rules\RulesDataProcessor\NumericOffset
 * @group rules
 */
class NumericOffsetTest extends RulesUnitTestBase {
  /**
   * @dataProvider stringsProvider
   */
  public function testNumericOffset($expectedMatchResult, $offset, $value) {
    $processor = new NumericOffset(['offset' => $offset], 'foo_bar', []);

    $this->assertSame($expectedMatchResult, $processor->process($value));
  }

  public function stringsProvider() {
    return array(
      array(5, 0, 5),
      array(5, 1, 4),
      array(5, '1', '4'),
      array(5, 1, '4'),
      array(5, '1', 4),
      array(5, '-1', 6),
      array(5, -1, 6),
      array(5.0, -1, 6.0),
    );
  }
}
