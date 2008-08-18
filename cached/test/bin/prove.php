<?php
/**
 * This file is part of the sfCachedSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../../sfSearchPlugin/test/bin/suite.php';

$t = new lime_search(dirname(__FILE__) . '/../../', new lime_output_color);
$t->prove();
