<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Condition\DataIsEmptyTest.
 */

namespace Drupal\Tests\rules\Unit\Condition;

use Drupal\rules\Plugin\Condition\DataIsEmpty;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Tests\rules\Unit\RulesUnitTestBase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Condition\DataIsEmpty
 * @group rules_conditions
 */
class DataIsEmptyTest extends RulesUnitTestBase {

  /**
   * The condition to be tested.
   *
   * @var \Drupal\rules\Engine\RulesConditionInterface
   */
  protected $condition;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->condition = new DataIsEmpty([], '', ['context' => [
      'data' => new ContextDefinition(),
    ]]);
    $this->condition->setStringTranslation($this->getMockStringTranslation());
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('Data value is empty', $this->condition->summary());
  }

  /**
   * Tests evaluating the condition.
   *
   * @covers ::evaluate()
   */
  public function testConditionEvaluation() {
    $node = $this->getMock('Drupal\node\NodeInterface');
    $node->expects($this->at(0))
      ->method('isEmpty')
      ->will($this->returnValue(TRUE));

    $node->expects($this->at(1))
      ->method('isEmpty')
      ->will($this->returnValue(FALSE));

    // Test a ComplexDataInterface object.
    $this->condition->setContextValue('data', $this->getMockTypedData($node));
    $this->assertTrue($this->condition->evaluate());
    $this->assertFalse($this->condition->evaluate());

    // These should all return FALSE.
    // A non-empty array.
    $this->condition->setContextValue('data', $this->getMockTypedData([1,2,3]));
    $this->assertFalse($this->condition->evaluate());

    // An array containing an empty list.
    $this->condition->setContextValue('data', $this->getMockTypedData([[]]));
    $this->assertFalse($this->condition->evaluate());

    // An array with a zero-value element.
    $this->condition->setContextValue('data', $this->getMockTypedData([0]));
    $this->assertFalse($this->condition->evaluate());

    // A scalar value.
    $this->condition->setContextValue('data', $this->getMockTypedData(1));
    $this->assertFalse($this->condition->evaluate());

    $this->condition->setContextValue('data', $this->getMockTypedData('short string'));
    $this->assertFalse($this->condition->evaluate());

    // These should all return TRUE.
    // An empty array.
    $this->condition->setContextValue('data', $this->getMockTypedData([]));
    $this->assertTrue($this->condition->evaluate());

    // The false/zero/NULL values.
    $this->condition->setContextValue('data', $this->getMockTypedData(FALSE));
    $this->assertTrue($this->condition->evaluate());

    $this->condition->setContextValue('data', $this->getMockTypedData(0));
    $this->assertTrue($this->condition->evaluate());

    $this->condition->setContextValue('data', $this->getMockTypedData(NULL));
    $this->assertTrue($this->condition->evaluate());

    // An empty string.
    $this->condition->setContextValue('data', $this->getMockTypedData(''));
    $this->assertTrue($this->condition->evaluate());
  }

}
