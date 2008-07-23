<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriterion.interface.php';
require 'criteria/xfCriterionWildcard.class.php';

$t = new lime_test(2, new lime_output_color);
$c = new xfCriterionWildcard('f?o b*r');

$t->is($c->toString(), 'WILDCARD {f?o b*r}', '->toString() works');
$t->todo('->translate()');
