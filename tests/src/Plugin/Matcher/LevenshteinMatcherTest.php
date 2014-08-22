<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Plugin\Matcher\LevenshteinMatcherTest.
 */

namespace Drupal\rules\Tests\Plugin\Matcher;

use Drupal\rules\Tests\RulesUnitTestBase;
use Drupal\rules\Plugin\Matcher\LevenshteinMatcher;

/**
 * @coversDefaultClass \Drupal\rules\Matcher\LevenshteinMatcher
 * @group rules
 */
class LevenshteinMatcherTest extends RulesUnitTestBase {
  /**
   * @dataProvider matchesProvider
   */
  public function testMatch($expectedMatchResult, $threshold, $subject, $object) {
    $matcher = new LevenshteinMatcher($threshold);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  public function matchesProvider() {
    return array(
      array(TRUE, 1, 'foo', 'foo'),
      array(TRUE, 1, 'bar', 'baz'),
      array(FALSE, 1, 'foo', 'bar'),

      array(TRUE, 3, 'foo', 'foo'),
      array(TRUE, 3, 'bar', 'baz'),
      array(TRUE, 3, 'foo', 'bar'),
    );
  }
}
