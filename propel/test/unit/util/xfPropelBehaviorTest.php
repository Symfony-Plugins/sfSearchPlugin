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
require 'util/xfPropelBehavior.class.php';
require 'index/xfIndexManager.class.php';
require 'mock/index/xfMockPropelIndex.class.php';
require 'log/xfLogger.interface.php';
require 'log/xfLoggerBlackhole.class.php';
require 'util/xfPropelVersion.class.php';
require 'util/xfToolkit.class.php';
autoloadPropel(12);
setupPropel('behavior', 12);

function calcguid($model)
{
  return 'p' . sha1('propel-' . get_class($model) . '-' . $model->hashCode());
}

$index = xfIndexManager::get('xfMockPropelIndex');

$t = new lime_test(12, new lime_output_color);

$t->diag('automatic');

xfPropelBehavior::register('MyModel', array('xfMockPropelIndex'));

$model = new MyModel;
$model->setName('carl');
$model->setAge(18);
$model->save();

$t->is($index->getEngine()->count(), 1, '->save() adds the model to the index');
$t->is($index->getEngine()->documents[calcguid($model)]->getField('name')->getValue(), 'carl', '->save() adds the correct information');

$model->setName('qarl');
$model->save();

$t->is($index->getEngine()->count(), 1, '->save() updates the model to the index if it already exists');
$t->is($index->getEngine()->documents[calcguid($model)]->getField('name')->getValue(), 'qarl', '->save() updates the correct information');

xfPropelBehavior::disable();

$model2 = new MyModel;
$model2->setName('karl');
$model2->setAge(42);
$model2->save();

$t->is($index->getEngine()->count(), 1, '->save() does not update the model if behavior is disabled');

$model2->delete();

$t->is($index->getEngine()->count(), 1, '->update() does not delete the model if behavior is disabled');

xfPropelBehavior::enable();

$model->delete();

$t->is($index->getEngine()->count(), 0, '->delete() removes the model from the index');

$t->diag('manual');

$b = new xfPropelBehavior;
$model = new MyModel;
$model->setName('carl');
$model->setAge(18);
$model->save();

$b->preSave($model);
$b->preSave($model);
$b->postSave($model);
$t->is($index->getEngine()->count(), 1, '->preSave() twice, ->postSave() once only indexes once if new');

$model->setName('qarl');
$b->preSave($model);
$b->preSave($model);
$b->postSave($model);
$t->is($index->getEngine()->count(), 1, '->preSave() twice, ->postSave() once only indexes once if modified');

$b->postDelete($model);
$t->is($index->getEngine()->count(), 1, '->postDelete() one with empty queue does nothing');

$b->preDelete($model);
$b->preDelete($model);
$b->postDelete($model);
$t->is($index->getEngine()->count(), 0, '->preDelete() twice, ->postDelete() once only deletes once');

$b->postSave($model);
$t->is($index->getEngine()->count(), 0, '->postSave() with empty queue does nothing');
