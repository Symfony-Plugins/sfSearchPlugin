<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../bootstrap/unit.php';

autoloadPropel();
setupPropel('identifier', 12);

Propel::getConnection('propel')->prepareStatement('DELETE FROM my_model;')->executeQuery();

echo "Erased identifier table.\n\n";

$colors = array('Blue', 'Red', 'Green');
$names = array('Carl', 'Fabien');

for ($x = 0; $x < 1000; $x++)
{
  $model = new MyModel;
  $model->setName($names[$x % 2]);
  $model->setEyeColor($colors[$x % 3]);
  $model->save();

  echo ".";
}

echo "\n\n";

echo "Count: " . MyModelPeer::doCount(new Criteria) . "\n";

setupPropel('behavior', 12);
Propel::getConnection('propel')->prepareStatement('DELETE FROM my_model;')->executeQuery();

echo "Erased behavior table.\n\n";
