<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'index/xfIndex.interface.php';
require_once 'index/xfIndexCommon.class.php';
require_once 'index/xfIndexSingle.class.php';
require_once 'service/xfServiceRegistry.class.php';
require_once 'service/xfService.class.php';
require_once 'service/xfIdentifier.interface.php';
require_once 'service/xfPropelIdentifier.class.php';
require_once 'mock/engine/xfMockEngine.class.php';
require_once 'document/xfDocument.class.php';
require_once 'document/xfField.class.php';
require_once 'document/xfFieldValue.class.php';
require_once 'document/xfBuilder.interface.php';
require_once 'document/xfPropelBuilder.class.php';

class xfMockPropelIndex extends xfIndexSingle
{
  protected function configure()
  {
    $this->setEngine(new xfMockEngine);

    $service = new xfService(new xfPropelIdentifier('MyModel'));
    $service->addBuilder(new xfPropelBuilder(array(
                                                    new xfField('name', xfField::KEYWORD),
                                                    new xfField('age', xfField::KEYWORD)
    )));

    $this->getServiceRegistry()->register($service);
  }
}
