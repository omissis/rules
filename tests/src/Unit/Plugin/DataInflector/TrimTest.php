<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataInflector\TrimTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataInflector;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\DataInflector\Trim;

/**
 * @coversDefaultClass \Drupal\rules\DataInflector\Trim
 * @group rules
 */
class TrimTest extends RulesUnitTestBase {
  /**
   * @dataProvider stringsProvider
   */
  public function testTrim($expectedMatchResult, $string) {
    $inflector = new Trim([], 'rules_data_inflector_trim', []);

    $this->assertSame($expectedMatchResult, $inflector->inflect($string));
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
