<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataInflector\LowercaseTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataInflector;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\DataInflector\Lowercase;

/**
 * @coversDefaultClass \Drupal\rules\DataInflector\Lowercase
 * @group rules
 */
class LowercaseTest extends RulesUnitTestBase {
  /**
   * @dataProvider stringsProvider
   */
  public function testTrim($expectedMatchResult, $string) {
    $inflector = new Lowercase([], 'rules_data_inflector_lowercase', []);

    $this->assertSame($expectedMatchResult, $inflector->inflect($string));
  }

  public function stringsProvider() {
    return array(
      array('foo', 'foo'),
      array('foo', 'FOO'),
      array('foo ', 'fOo '),
    );
  }
}
