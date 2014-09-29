<?php

/**
 * @file
 * Contains \Drupal\rules\Tests\Condition\DataComparisonTest.
 */

namespace Drupal\Tests\rules\Unit\Condition;

use Drupal\rules\Plugin\Condition\TestMatcher;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\Tests\rules\Unit\RulesIntegrationTestBase;
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
  public function testEvaluate($expectedMatchResult, $matcherClass, $subject, $object) {
    $dataMatcherManager = $this->getMockBuilder('Drupal\\rules\\Plugin\\RulesDataMatcherPluginManager')
      ->disableOriginalConstructor()
      ->getMock();

    $dataMatcherManager
      ->expects($this->once())
      ->method('getInstance')
      ->will($this->returnValue(new $matcherClass()));

    $this->condition
      ->setDataMatcherManager($dataMatcherManager)
      ->setContextValue('data', $subject)
      ->setContextValue('operator', 'foo')
      ->setContextValue('value', $object);

    $this->assertSame($expectedMatchResult, $this->condition->evaluate());
  }


  /**
   * Tests the evaluate function when it receives bad values.
   *
   * @dataProvider invalidArgumentsMatchesProvider
   * @expectedException InvalidArgumentException
   *
   * @covers ::evaluate()
   */
  public function testEvaluateWithErrors($matcherClass, $subject, $object) {
    $dataMatcherManager = $this->getMockBuilder('Drupal\\rules\\Plugin\\RulesDataMatcherPluginManager')
      ->disableOriginalConstructor()
      ->getMock();

    $dataMatcherManager
      ->expects($this->once())
      ->method('getInstance')
      ->will($this->returnValue(new $matcherClass()));

    $this->condition
      ->setDataMatcherManager($dataMatcherManager)
      ->setContextValue('data', $subject)
      ->setContextValue('operator', 'foo')
      ->setContextValue('value', $object);

    $this->condition->evaluate();
  }

  public function matchesProvider() {
    return array(
      array(TRUE, 'Drupal\\rules\\Plugin\\DataMatcher\\Levenshtein', 'foo', 'foo'),
      array(FALSE, 'Drupal\\rules\\Plugin\\DataMatcher\\Levenshtein', 'foo', 'bar'),

      array(TRUE, 'Drupal\\rules\\Plugin\\DataMatcher\\Regexp', 'foo', '/^fo/'),
      array(FALSE, 'Drupal\\rules\\Plugin\\DataMatcher\\Regexp', 'foo', '/fu/'),

      array(TRUE, 'Drupal\\rules\\Plugin\\DataMatcher\\StringContains', 'foo', 'fo'),
      array(FALSE, 'Drupal\\rules\\Plugin\\DataMatcher\\StringContains', 'foo', 'ba'),

      array(TRUE, 'Drupal\\rules\\Plugin\\DataMatcher\\StringEquals', 'foo', 'foo'),
      array(FALSE, 'Drupal\\rules\\Plugin\\DataMatcher\\StringEquals', 'foo', 'bar'),

      array(TRUE, 'Drupal\\rules\\Plugin\\DataMatcher\\Type', 'foo', 'string'),
      array(FALSE, 'Drupal\\rules\\Plugin\\DataMatcher\\Type', 'foo', 'boolean'),
    );
  }

  public function invalidArgumentsMatchesProvider () {
    return array(
      array('Drupal\\rules\\Plugin\\DataMatcher\\Levenshtein', '1', 1),
      array('Drupal\\rules\\Plugin\\DataMatcher\\Levenshtein', 2, '2'),

      array('Drupal\\rules\\Plugin\\DataMatcher\\Regexp', 1, '1'),
      array('Drupal\\rules\\Plugin\\DataMatcher\\Regexp', '2', 2),

      array('Drupal\\rules\Plugin\\DataMatcher\\StringContains', 1, '1'),
      array('Drupal\\rules\\Plugin\\DataMatcher\\StringContains', '2', 2),

      array('Drupal\\rules\\Plugin\\DataMatcher\\StringEquals', 1, '1'),
      array('Drupal\\rules\\Plugin\\DataMatcher\\StringEquals', '2', 2),
    );
  }
}
