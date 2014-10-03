<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Condition\DataComparisonTest.
 */

namespace Drupal\Tests\rules\Integration\Condition;

use Drupal\rules\Plugin\Condition\TestMatcher;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Tests\rules\Integration\RulesIntegrationTestBase;
use Drupal\rules\Plugin\DataMatcher\StringEquals;

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
   * @covers ::evaluate()
   */
  public function testEvaluate($expectedMatchResult, $operator, $subject, $object) {
    $this->condition
      ->setContextValue('data', $subject)
      ->setContextValue('operator', $operator)
      ->setContextValue('value', $object);

    $this->assertSame($expectedMatchResult, $this->condition->evaluate());
  }

  public function matchesProvider() {
    return array(
      array(TRUE, 'rules_data_matcher_levenshtein', 'foo', 'foo'),
      array(FALSE, 'rules_data_matcher_levenshtein', 'foo', 'bar'),

      array(TRUE, 'rules_data_matcher_regexp', 'foo', '/^fo/'),
      array(FALSE, 'rules_data_matcher_regexp', 'foo', '/fu/'),

      array(TRUE, 'rules_data_matcher_string_contains', 'foo', 'fo'),
      array(FALSE, 'rules_data_matcher_string_contains', 'foo', 'ba'),

      array(TRUE, 'rules_data_matcher_string_equals', 'foo', 'foo'),
      array(FALSE, 'rules_data_matcher_string_equals', 'foo', 'bar'),

      array(TRUE, 'rules_data_matcher_type', 'foo', 'string'),
      array(FALSE, 'rules_data_matcher_type', 'foo', 'boolean'),
    );
  }
}
