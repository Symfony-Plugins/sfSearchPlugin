<?php

/**
 * Subclass for representing a row from the 'my_model' table.
 *
 * 
 *
 * @package plugins.sfPropelSearchPlugin.test.mock.model.12
 */ 
class MyModel extends BaseMyModel
{
  public $shouldIndex = true;

  public function shouldIndex()
  {
    return $this->shouldIndex;
  }
}
