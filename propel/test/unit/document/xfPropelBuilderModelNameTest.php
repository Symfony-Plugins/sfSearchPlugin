<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'document/xfBuilder.interface.php';
require 'document/xfPropelBuilderModelName.class.php';
autoloadPropel(12);

$t = new lime_test(1, new lime_output_color);

$model = new MyModel;
$doc = new xfDocument('guid');

$builder = new xfPropelBuilderModelName;
$builder->build($model, $doc);

$t->is($doc->getField('_propel_model_name')->getValue(), sha1('MyModel'), '->build() adds a non-user searchable field with the model name');
