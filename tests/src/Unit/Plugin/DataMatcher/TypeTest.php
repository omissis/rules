<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataMatcher\TypeTest.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataMatcher;

use Drupal\rules\Plugin\DataMatcher\Type;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\DataMatcher\Type
 * @group rules
 */
class TypeTest extends DataMatcherTestBase {

  /**
   * The condition to be tested.
   *
   * @var \Drupal\rules\Plugin\DataMatcher\MatcherInterface
   */
  protected $matcher;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->matcher = new Type([], 'foo_bar', [], $this->dataProcessorManager);
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
