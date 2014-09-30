<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\RulesDataMatcher\RegexpTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\RulesDataMatcher;

use Drupal\rules\Plugin\RulesDataMatcher\Regexp;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\RulesDataMatcher\RegexpMatcher
 * @group rules
 */
class RegexpTest extends RulesDataMatcherTestBase {

  /**
   * The condition to be tested.
   *
   * @var \Drupal\rules\Plugin\RulesDataMatcher\MatcherInterface
   */
  protected $matcher;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->matcher = new Regexp([], 'foo_bar', [], $this->dataProcessorManager);
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
