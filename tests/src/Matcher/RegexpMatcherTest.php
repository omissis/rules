<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\RegexpMatcherTest.
 */

namespace Drupal\rules\Tests;

use Drupal\rules\Matcher\RegexpMatcher;

/**
 * @coversDefaultClass \Drupal\rules\Matcher\RegexpMatcher
 * @group rules
 */
class RegexpMatcherTest extends RulesUnitTestBase {

  /**
   * The condition to be tested.
   *
   * @var \Drupal\rules\Matcher\MatcherInterface
   */
  protected $matcher;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->matcher = new RegexpMatcher();
  }

  /**
   * @dataProvider matchesProvider
   */
  public function testMatch($expectedMatchResult, $subject, $object) {
    $this->assertSame($expectedMatchResult, $this->matcher->match($subject, $object));
  }

  public function matchesProvider() {
    return array(
      array(TRUE, 'foo', '/^foo$/'),
      array(TRUE, 'FOO', '/foo/i'),
      array(TRUE, 'BAR FOO BAZ', '/foo/i'),

      array(FALSE, 'foobar', '/^bar/'),
      array(FALSE, 'BARBAZ', '/bar$/i'),
      array(FALSE, 'foobar', '/^bar$/i'),
    );
  }
}
