<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\StringEqualityMatcherTest.
 */

namespace Drupal\rules\Tests\Plugin\Matcher;

use Drupal\rules\Tests\RulesUnitTestBase;
use Drupal\rules\Plugin\Matcher\StringEqualsMatcher;

/**
 * @coversDefaultClass \Drupal\rules\Matcher\StringEqualsMatcher
 * @group rules
 */
class StringEqualsMatcherTest extends RulesUnitTestBase {
  /**
   * @dataProvider matchesProvider
   */
  public function testMatch($expectedMatchResult, $trim, $case_sensitive, $subject, $object) {
    $matcher = new StringEqualsMatcher($case_sensitive, $trim);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  public function matchesProvider() {
    return array(
      array(TRUE, TRUE, TRUE, 'foo ', ' foo'),
      array(TRUE, FALSE, TRUE, 'foo', 'foo'),
      array(TRUE, TRUE, FALSE, 'foo ', ' FOO'),
      array(TRUE, FALSE, FALSE, 'foo', 'foo'),

      array(FALSE, TRUE, TRUE, 'foo ', ' fo'),
      array(FALSE, FALSE, TRUE, 'foo', 'FOO'),
      array(FALSE, TRUE, FALSE, 'foo ', ' FO'),
      array(FALSE, FALSE, FALSE, 'foo', 'fo'),
    );
  }
}
