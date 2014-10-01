<?php

/**
 * @file
 * Contains \Drupal\Tests\rules\Unit\Action\CreatePathAliasTest.
 */

namespace Drupal\Tests\rules\Unit\Action;

use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\rules\Plugin\Action\CreatePathAlias;
use Drupal\Tests\rules\Unit\RulesUnitTestCase;

/**
 * @coversDefaultClass \Drupal\rules\Plugin\Action\CreatePathAlias
 * @group rules_action
 */
class CreatePathAliasTest extends RulesUnitTestCase {

  /**
   * The action to be tested.
   *
   * @var \Drupal\rules\Engine\RulesActionInterface
   */
  protected $action;

  /**
   * The mocked alias storage service.
   *
   * @var \PHPUnit_Framework_MockObject_MockObject|\Drupal\Core\Path\AliasStorageInterface
   */
  protected $aliasStorage;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $this->aliasStorage = $this->getMock('Drupal\Core\Path\AliasStorageInterface');

    $this->action = new CreatePathAlias([], '', ['context' => [
      'source' => new ContextDefinition('string'),
      'alias' => new ContextDefinition('string'),
      'language' => new ContextDefinition('language', NULL, FALSE),
    ]], $this->aliasStorage);

    $this->action->setStringTranslation($this->getMockStringTranslation());
    $this->action->setTypedDataManager($this->getMockTypedDataManager());
  }

  /**
   * Tests the summary.
   *
   * @covers ::summary()
   */
  public function testSummary() {
    $this->assertEquals('Create any path alias', $this->action->summary());
  }

  /**
   * Tests the action execution when no language is specified.
   *
   * @covers ::execute()
   */
  public function testActionExecutionWithoutLanguage() {
    $this->aliasStorage->expects($this->once())
      ->method('save')
      ->with('node/1', 'about', LanguageInterface::LANGCODE_NOT_SPECIFIED);

    $this->action->setContextValue('source', $this->getMockTypedData('node/1'))
      ->setContextValue('alias', $this->getMockTypedData('about'));

    $this->action->execute();
  }

  /**
   * Tests the action execution when a language is specified.
   *
   * @covers ::execute()
   */
  public function testActionExecutionWithLanguage() {
    $language = $this->getMock('Drupal\Core\Language\LanguageInterface');
    $language->expects($this->once())
      ->method('getId')
      ->will($this->returnValue('en'));

    $this->aliasStorage->expects($this->once())
      ->method('save')
      ->with('node/1', 'about', 'en');

    $this->action->setContextValue('source', $this->getMockTypedData('node/1'))
      ->setContextValue('alias', $this->getMockTypedData('about'))
      ->setContextValue('language', $this->getMockTypedData($language));

    $this->action->execute();
  }

}
