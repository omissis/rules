<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\TypeMatcherTest.
 */

namespace Drupal\rules\Tests\Plugin\Matcher;

use Drupal\rules\Tests\RulesUnitTestBase;
use Drupal\rules\Plugin\Matcher\TypeMatcher;

/**
 * @coversDefaultClass \Drupal\rules\Matcher\TypeMatcher
 * @group rules
 */
class TypeMatcherTest extends RulesUnitTestBase {

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
    $this->matcher = new TypeMatcher();
  }

  /**
   * @dataProvider matchesProvider
   */
  public function testMatch($expectedMatchResult, $subject, $object) {
    $this->assertSame($expectedMatchResult, $this->matcher->match($subject, $object));
  }

  public function matchesProvider() {
    return array(
      // integer subject
      array(TRUE, 1, 'integer'),
      array(FALSE, 1, 'string'),

      // string subject
      array(TRUE, '1', 'string'),
      array(FALSE, '1', 'integer'),

      // boolean subject
      array(TRUE, FALSE, 'boolean'),
      array(FALSE, TRUE, 'integer'),

      // array subject
      array(TRUE, array(), 'array'),
      array(FALSE, array('foo'), 'integer'),

      // null subject
      array(TRUE, NULL, 'NULL'),
      array(FALSE, NULL, 'integer'),

      // class subject
      array(TRUE, new \SplQueue(), '\SplQueue'),
      array(FALSE, new \SplQueue(), '\SplStack'),
    );
  }
}
