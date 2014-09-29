<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\Condition\TextMatches.
 */

namespace Drupal\rules\Plugin\Condition;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Engine\RulesConditionBase;
use Drupal\rules\Matcher\MatcherInterface;
use Drupal\rules\Plugin\RulesDataMatcherPluginManager;

/**
 * Provides a 'Text matches' condition.
 *
 * @Condition(
 *   id = "rules_text_matches",
 *   label = @Translation("Data comparison"),
 *   context = {
 *     "data" = @ContextDefinition("any",
 *       label = @Translation("Value to compare"),
 *       description = @Translation("The text to be matched against a rule, specified by using a data selector, e.g. 'node:uid:entity:name:value'.")
 *     ),
 *     "operator" = @ContextDefinition("string",
 *       label = @Translation("Operator"),
 *       description = @Translation("The match operator."),
 *       required = FALSE
 *     ),
 *     "value" = @ContextDefinition("any",
 *        label = @Translation("Value compared with the subject"),
 *        description = @Translation("The value to match the data with.")
 *     )
 *   }
 * )
 *
 * @todo: DataMatcherPluginManager should be constructor-injected as it's a mandatory dependency.
 */
class TextMatches extends RulesConditionBase implements ContainerFactoryPluginInterface {

  /**
   * The data processor plugin manager used to process context variables.
   *
   * @var \Drupal\rules\Plugin\RulesDataMatcherPluginManager
   */
  protected $dataMatcherManager;


  /**
   * Constructs a PathHasAlias object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\rules\Plugin\RulesDataMatcherPluginManager $data_matcher_manager
   *   The alias manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RulesDataMatcherPluginManager $data_matcher_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dataMatcherManager = $data_matcher_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.rules_data_matcher')
    );
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
    $contextData = $this->getContext('operator')->getContextData();

    if (empty($contextData)) {
      throw new \RuntimeException('Missing "operator" context property.');
    }

    // The expected result of getCastedValue is the data matcher plugin id, e.g: rules_datamatcher_string_equals.
    // Throws PluginNotFoundException if it can't find the plugin
    $matcher = $this->dataMatcherManager->createInstance($contextData->getCastedValue());

    if (!is_object($matcher) || !$matcher instanceof MatcherInterface) {
      throw new \RuntimeException('Matcher is not an instance of MatcherInterface.');
    }

    return $matcher->match($this->getContextValue('data'), $this->getContextValue('value'));
  }

}
