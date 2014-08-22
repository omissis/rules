<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\TextMatches.
 */

namespace Drupal\rules\Plugin\Condition;

use Drupal\rules\Engine\RulesConditionBase;
use Drupal\rules\Plugin\Matcher\MatcherInterface;

/**
 * Provides a 'Text matches' condition.
 *
 * @Condition(
 *   id = "rules_text_matches",
 *   label = @Translation("Data comparison"),
 *   context = {
 *     "text" = @ContextDefinition("any",
 *       label = @Translation("Data to compare"),
 *       description = @Translation("The text to be matched against a rule, specified by using a ???.")
 *     ),
 *     "operator" = @ContextDefinition("string",
 *       label = @Translation("Operator"),
 *       description = @Translation("The match operator."),
 *       required = FALSE
 *     ),
 *     "value" = @ContextDefinition("any",
 *        label = @Translation("Data value"),
 *        description = @Translation("The value to match the data with.")
 *     )
 *   }
 * )
 *
 * @todo: DataMatcherPluginManager should be constructor-injected as it's a mandatory dependency.
 */
class TextMatches extends RulesConditionBase {

  const OPERATOR_DEFAULT = 'rules_matcher_string_equals';

  /**
   * The data processor plugin manager used to process context variables.
   *
   * @var \Drupal\rules\Plugin\RulesDataMatcherPluginManager
   */
  protected $dataMatcherManager;

  /**
   * @param RulesDataMatcherPluginManager $dataMatcherManager
   *
   * @return TextMatches
   */
  public function setDataMatcherManager(RulesDataMatcherPluginManager $dataMatcherManager) {
    $this->dataMatcherManager = $dataMatcherManager;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function summary() {
    return $this->t('Text matches');
  }

  /**
   * {@inheritdoc}
   */
  public function evaluate() {
    $operator = $this->getContext('operator')->getContextData()->getCastedValue() ?: self::OPERATOR_DEFAULT;

    $matcher = $this->matcherManager ? $this->matcherManager->getInstance($operator) : NULL;

    if (!is_object($matcher) || !$matcher instanceof MatcherInterface) {
      throw new \RuntimeException('Matcher is not an instance of MatcherInterface.');
    }

    return $matcher->matches($this->getContextValue('text'), $this->getContextValue('value'));
  }

}
