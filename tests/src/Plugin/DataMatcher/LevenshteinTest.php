<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Plugin\DataMatcher\LevenshteinTest.
 */

namespace Drupal\rules\Tests\Plugin\DataMatcher;

use Drupal\rules\Tests\RulesUnitTestBase;
use Drupal\rules\Plugin\DataMatcher\Levenshtein;

/**
 * @coversDefaultClass \Drupal\rules\DataMatcher\LevenshteinMatcher
 * @group rules
 */
class LevenshteinTest extends RulesUnitTestBase {
  /**
   * @dataProvider caseSensitiveMatchesProvider
   */
  public function testCaseSensitiveMatch($expectedMatchResult, $threshold, $subject, $object) {
    $matcher = new Levenshtein(TRUE, $threshold);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  /**
   * @dataProvider caseInsensitiveMatchesProvider
   */
  public function testCaseInsensitiveMatch($expectedMatchResult, $threshold, $subject, $object) {
    $matcher = new Levenshtein(FALSE, $threshold);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  public function caseSensitiveMatchesProvider() {
    return array(
      array(TRUE, 1, 'foo', 'foo'),
      array(TRUE, 1, 'bar', 'baz'),
      array(FALSE, 1, 'foo', 'bar'),

      array(TRUE, 3, 'foo', 'foo'),
      array(TRUE, 3, 'bar', 'baz'),
      array(TRUE, 3, 'foo', 'bar'),
    );
  }

  public function caseInsensitiveMatchesProvider() {
    return array(
      array(TRUE, 1, 'foo', 'FOO'),
      array(TRUE, 1, 'bar', 'BAZ'),
      array(FALSE, 1, 'foo', 'BAR'),

      array(TRUE, 3, 'foo', 'FOO'),
      array(TRUE, 3, 'bar', 'BAZ'),
      array(TRUE, 3, 'foo', 'BAR'),
    );
  }
}
