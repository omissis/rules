<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Integration\Condition\NodeIsStickyTest.
 */

namespace Drupal\Tests\rules\Integration\Condition;

use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\rules\Plugin\Condition\NodeIsSticky;
use Drupal\Tests\rules\Integration\RulesIntegrationTestCase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Condition\NodeIsSticky
 * @group rules_conditions
 */
class NodeIsStickyTest extends RulesIntegrationTestCase {

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

    $this->condition = $this->conditionManager->createInstance('rules_node_is_sticky');
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('Node is sticky', $this->condition->summary());
  }

  /**
   * Tests evaluating the condition.
   *
   * @covers ::evaluate()
   */
  public function testConditionEvaluation() {
    $node = $this->getMock('Drupal\node\NodeInterface');
    $node->expects($this->at(0))
      ->method('isSticky')
      ->will($this->returnValue(TRUE));

    $node->expects($this->at(1))
      ->method('isSticky')
      ->will($this->returnValue(FALSE));

    // Set the node context value.
    $this->condition->setContextValue('node', $this->getMockTypedData($node));

    // Test evaluation. The first invocation should return TRUE, the second
    // should return FALSE.
    $this->assertTrue($this->condition->evaluate());
    $this->assertFalse($this->condition->evaluate());
  }

}
