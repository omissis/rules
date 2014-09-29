<?php

/**
 * @file
 * Contains \Drupal\rules\Plugin\DataMatcher\DataMatcherBase.
 */

namespace Drupal\rules\Plugin\DataMatcher;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Matcher\MatcherInterface;
use Drupal\rules\Plugin\RulesDataProcessorManager;
use Drupal\rules\Engine\RulesDataProcessorInterface;

/**
 * Base class for rules conditions.
 */
abstract class DataMatcherBase extends PluginBase implements ContainerFactoryPluginInterface, MatcherInterface {

  protected $subjectProcessors = array();
  protected $objectProcessors = array();

  /**
   * The alias manager service.
   *
   * @var \Drupal\rules\Plugin\RulesDataProcessorManager
   */
  protected $dataProcessorManager;

  /**
   * Constructs a PathHasAlias object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\rules\Plugin\RulesDataProcessorManager $data_processor_manager
   *   The alias manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RulesDataProcessorManager $data_processor_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dataProcessorManager = $data_processor_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.rules_data_processor')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function match($subject, $object) {
    return $this->doMatch(
      $this->process($subject, $this->subjectProcessors),
      $this->process($object, $this->objectProcessors)
    );
  }

  /**
   * Set the flag for case sensitive.
   *
   * @todo move this to a StringMatcherTrait
   *
   * @param boolean $caseSensitive
   */
  public function setCaseSensitive($caseSensitive) {
    if (TRUE === $caseSensitive) {
      return;
    }

    $processor = $this->dataProcessorManager->createInstance('rules_data_processor_lowercase');

    $this->addSubjectProcessor($processor);
    $this->addObjectProcessor($processor);
  }

  /**
   * Set the flag for trim.
   *
   * @todo move this to a StringMatcherTrait
   *
   * @param boolean $trimmed
   */
  public function setTrimmed($trimmed) {
    if (FALSE === $trimmed) {
      return;
    }

    $processor = $this->dataProcessorManager->createInstance('rules_data_processor_trim');

    $this->addSubjectProcessor($processor);
    $this->addObjectProcessor($processor);
  }

  protected function process($value, array $processors = array()) {
    array_walk($processors, function ($processor) use (&$value) {
      $value = $processor->process($value);
    });

    return $value;
  }

  protected function addSubjectProcessor(RulesDataProcessorInterface $processor) {
    $this->subjectProcessors[] = $processor;
  }

  protected function addObjectProcessor(RulesDataProcessorInterface $processor) {
    $this->objectProcessors[] = $processor;
  }

  /**
   * Perform the actual matching.
   *
   * @param mixed $subject
   * @param mixed $object
   *
   * @return boolean
   */
  abstract protected function doMatch($subject, $object);

}
