<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataMatcher\StringEqualsTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataMatcher;

use Drupal\rules\Plugin\DataMatcher\StringEquals;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\DataMatcher\StringEquals
 * @group rules
 */
class StringEqualsTest extends DataMatcherTestBase {
  /**
   * @dataProvider matchesProvider
   */
  public function testMatch($expectedMatchResult, $trim, $case_sensitive, $subject, $object) {
    $matcher = new StringEquals([], 'foo_bar', [], $this->dataProcessorManager);

    $matcher->setCaseSensitive($case_sensitive);
    $matcher->setTrimmed($trim);

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
