<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\StringContainsMatcherTest.
 */

namespace Drupal\rules\Tests;

use Drupal\rules\Matcher\StringContainsMatcher;

/**
 * @coversDefaultClass \Drupal\rules\Matcher\StringContainsMatcher
 * @group rules
 */
class StringContainsMatcherTest extends RulesUnitTestBase {
  /**
   * @dataProvider caseSensitiveMatchesProvider
   */
  public function testCaseSensitiveMatch($expectedMatchResult, $subject, $object) {
    $matcher = new StringContainsMatcher();
    $this->assertSame($expectedMatchResult, $matcher->match($subject, $object));
  }

  /**
   * @dataProvider caseInsensitiveMatchesProvider
   */
  public function testCaseInsensitiveMatch($expectedMatchResult, $subject, $object) {
    $matcher = new StringContainsMatcher(0, FALSE);
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
