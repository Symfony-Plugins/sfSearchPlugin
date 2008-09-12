<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../../core/test/bootstrap/unit.php';

define('PROPEL_12', SF_LIB_DIR . '/plugins/sfPropelPlugin/lib');
define('PROPEL_13', realpath(dirname(__FILE__) . '/../../../../sf/plugins/sfPropelPlugin/lib'));

set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../../lib');
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../../test');
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../../test/mock/model');
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../../../..');
set_include_path(get_include_path() . PATH_SEPARATOR . SF_LIB_DIR);

function autoloadPropel($v)
{
  require_once 'util/sfFinder.class.php';
  require_once 'autoload/sfSimpleAutoload.class.php';

  $a = sfSimpleAutoload::getInstance();

  if ($v == 12)
  {
    $a->addDirectory(PROPEL_12);
    $a->addDirectory(dirname(__FILE__) . '/../mock/model/12');

    set_include_path(get_include_path() . PATH_SEPARATOR . PROPEL_12 . '/vendor');
  }
  else
  {
    $a->addDirectory(PROPEL_13);
    $a->addDirectory(dirname(__FILE__) . '/../mock/model/13');

    set_include_path(get_include_path() . PATH_SEPARATOR . PROPEL_13 . '/vendor');
  }

  sfSimpleAutoload::register();
}

function setupPropel($db, $v)
{
  if ($v == 12)
  {
    $config = array(
        'propel' => array(
          'datasources' => array(
            'propel' => array(
              'adapter' => 'sqlite',
              'connection' => array(
                'phptype' => 'sqlite',
                'database' => dirname(__FILE__) . '/../sandbox/' . $v . '/' . $db . '.db'
                )
              )
            )
          )
        );
  }
  else
  {
    $config = array(
      'propel' => array(
        'datasources' => array(
          'propel' => array(
            'adapter' => 'sqlite',
            'connection' => array(
              'phptype' => 'sqlite',
              'classname' => 'PropelPDO',
              'dsn' => 'sqlite2:' . realpath(dirname(__FILE__) . '/../sandbox/' . $v. '/' . $db . '.db')
              )
            )
          )
        )
      );
  }

  Propel::setConfiguration($config);
  Propel::initialize();
  Propel::getConnection('propel');
}
