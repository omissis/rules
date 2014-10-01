<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Integration\Condition\ListCountIsTest.
 */

namespace Drupal\Tests\rules\Integration\Condition;

use Drupal\rules\Plugin\Condition\ListCountIs;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Tests\rules\Integration\RulesIntegrationTestCase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Condition\ListCountIs
 * @group rules_conditions
 */
class ListCountIsTest extends RulesIntegrationTestCase {

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

    $this->condition = $this->conditionManager->createInstance('rules_list_count_is');
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('List count comparison', $this->condition->summary());
  }

  /**
   * Tests evaluating the condition.
   *
   * @covers ::evaluate()
   */
  public function testConditionEvaluation() {
    // Test that the list count is greater than 2.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2,3,4]))
      ->setContextValue('operator', $this->getMockTypedData('>'))
      ->setContextValue('value', $this->getMockTypedData('2'));
    $this->assertTrue($condition->evaluate());

    // Test that the list count is less than 4.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2,3]))
      ->setContextValue('operator', $this->getMockTypedData('<'))
      ->setContextValue('value', $this->getMockTypedData('4'));
    $this->assertTrue($condition->evaluate());

    // Test that the list count is equal to 3.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2,3]))
      ->setContextValue('operator', $this->getMockTypedData('=='))
      ->setContextValue('value', $this->getMockTypedData('3'));
    $this->assertTrue($condition->evaluate());

    // Test that the list count is equal to 0.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([]))
      ->setContextValue('operator', $this->getMockTypedData('=='))
      ->setContextValue('value', $this->getMockTypedData('0'));
    $this->assertTrue($condition->evaluate());

    // Test that the list count is not less than 2.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2]))
      ->setContextValue('operator', $this->getMockTypedData('<'))
      ->setContextValue('value', $this->getMockTypedData('2'));
    $this->assertFalse($condition->evaluate());

    // Test that list count is not greater than 5.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2,3]))
      ->setContextValue('operator', $this->getMockTypedData('>'))
      ->setContextValue('value', $this->getMockTypedData('5'));
    $this->assertFalse($condition->evaluate());

    // Test that the list count is not equal to 0.
    $condition = $this->condition
      ->setContextValue('list', $this->getMockTypedData([1,2,3]))
      ->setContextValue('operator', $this->getMockTypedData('=='))
      ->setContextValue('value', $this->getMockTypedData('0'));
    $this->assertFalse($condition->evaluate());
  }

}
