<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataMatcher\StringContainsTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataMatcher;

use Drupal\rules\Plugin\DataMatcher\StringContains;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\DataMatcher\StringContains
 * @group rules
 */
class StringContainsTest extends DataMatcherTestBase {
  /**
   * @dataProvider caseSensitiveMatchesProvider
   */
  public function testCaseSensitiveMatch($expectedMatchResult, $subject, $object) {
    $matcher = new StringContains([], 'foo_bar', [], $this->dataProcessorManager);

    $matcher->setCaseSensitive(TRUE);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  /**
   * @dataProvider caseInsensitiveMatchesProvider
   */
  public function testCaseInsensitiveMatch($expectedMatchResult, $subject, $object) {
    $matcher = new StringContains([], 'foo_bar', [], $this->dataProcessorManager);

    $matcher->setCaseSensitive(FALSE);

    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  public function caseSensitiveMatchesProvider() {
    return array(
      array(TRUE, 'foo', 'foo'),
      array(TRUE, 'foobar', 'oob'),
      array(TRUE, 'foobarfoobar', 'foo'),

      array(FALSE, 'foo', 'FOO'),
      array(FALSE, 'foobar', 'OOB'),
      array(FALSE, 'foobarfoobar', 'FOO'),
    );
  }

  public function caseInsensitiveMatchesProvider() {
    return array(
      array(TRUE, 'foo', 'foo'),
      array(TRUE, 'foobar', 'oob'),
      array(TRUE, 'foobarfoobar', 'foo'),

      array(TRUE, 'foo', 'FOO'),
      array(TRUE, 'foobar', 'OOB'),
      array(TRUE, 'foobarfoobar', 'FOO'),
    );
  }
}
