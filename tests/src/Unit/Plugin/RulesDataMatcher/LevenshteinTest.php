<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\RulesDataMatcher\LevenshteinTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\RulesDataMatcher;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\RulesDataMatcher\Levenshtein;
use Drupal\rules\Plugin\RulesDataProcessor\Lowercase;

/**
 * @coversDefaultClass \Drupal\rules\RulesDataMatcher\LevenshteinMatcher
 * @group rules
 */
class LevenshteinTest extends RulesDataMatcherTestBase {

  /**
   * @dataProvider caseSensitiveMatchesProvider
   */
  public function testCaseSensitiveMatch($expectedMatchResult, $threshold, $subject, $object) {
    $matcher = new Levenshtein([], 'foo_bar', [], $this->dataProcessorManager);

    $matcher->setThreshold($threshold);
    $matcher->setCaseSensitive(TRUE);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  /**
   * @dataProvider caseInsensitiveMatchesProvider
   */
  public function testCaseInsensitiveMatch($expectedMatchResult, $threshold, $subject, $object) {
    $matcher = new Levenshtein([], 'foo_bar', [], $this->dataProcessorManager);

    $matcher->setThreshold($threshold);
    $matcher->setCaseSensitive(FALSE);

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
