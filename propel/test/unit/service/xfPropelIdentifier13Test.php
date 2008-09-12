<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfException.class.php';
require 'service/xfIdentifier.interface.php';
require 'service/xfPropelIdentifier.class.php';
require 'util/xfPropelPDOIterator.class.php';
require 'util/xfPropelVersion.class.php';

autoloadPropel(13);
setupPropel('iterator', 13);

$t = new lime_test(1, new lime_output_color);

$id = new xfPropelIdentifier('MyModel');
$t->isa_ok($id->discover(0), 'xfPropelPDOIterator', '->discover() returns a xfPropelPDOIterator');
