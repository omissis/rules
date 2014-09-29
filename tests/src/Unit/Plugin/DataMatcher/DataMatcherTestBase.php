<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Plugin\DataMatcher\DataMatcherTestBase.
 */

namespace Drupal\Tests\rules\Unit\Plugin\DataMatcher;

use Drupal\Tests\rules\Unit\RulesUnitTestBase;
use Drupal\rules\Plugin\RulesDataProcessor\Lowercase;
use Drupal\rules\Plugin\RulesDataProcessor\Trim;

/**
 * @group rules
 */
abstract class DataMatcherTestBase extends RulesUnitTestBase {

  public function setUp() {
    parent::setUp();

    $this->dataProcessorManager = $this->getMockBuilder('Drupal\\rules\\Plugin\\RulesDataProcessorManager')
      ->disableOriginalConstructor()
      ->getMock();

    $inputs = array('rules_data_processor_lowercase', 'rules_data_processor_trim');
    $outputs = array(new Lowercase([], 'foo', []), new Trim([], 'bar', []));

    $expectation = $this->dataProcessorManager->expects($this->any())->method('createInstance');

    $this->setMultipleMatching($expectation, $inputs, $outputs);
  }

  public function tearDown() {
    $this->dataProcessorManager = NULL;

    parent::tearDown();
  }
}
