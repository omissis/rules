<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Condition\DataComparisonTest.
 */

namespace Drupal\rules\Tests\Condition;

use Drupal\rules\Plugin\Condition\TestMatcher;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\rules\Tests\RulesIntegrationTestBase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Condition\DataComparison
 * @group rules_conditions
 */
class TextMatchesTest extends RulesIntegrationTestBase {

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
    $this->condition = $this->conditionManager->createInstance('rules_text_matches');
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('Text matches', $this->condition->summary());
  }

  /**
   * Tests the evaluate.
   *
   * @dataProvider matchesProvider
   *
   * @covers ::summary()
   */
  public function testEvaluate($expectedMatchResult, $text, $operator, $value) {
    $this->condition
      ->setContextValue('text', $text)
      ->setContextValue('operator', $operator)
      ->setContextValue('value', $value);

    $this->assertSame($expectedMatchResult, $this->condition->evaluate());
  }

  public function matchesProvider() {
    return array(
      array(TRUE, 'foo', null, 'foo'),
      array(TRUE, '1', null, 1),

      array(FALSE, 'foo', null, 'bar'),
      array(FALSE, '1', null, 2),
    );
  }
}
