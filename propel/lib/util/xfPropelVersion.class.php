<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides a quick way to detect the Propel version.
 *
 * @package sfPropelSearch
 * @subpackage Utilities
 * @author Carl Vondrick
 */
final class xfPropelVersion
{
  /**
   * Version flag for 1.2
   */
  const V12 = '1.2';

  /** 
   * Version flag for 1.3
   */
  const V13 = '1.3';

  /**
   * The version detected
   *
   * @var float
   */
  static private $version = null;

  /**
   * Detects the Propel version.
   *
   * @returns float The version number
   */
  static public function get()
  {
    if (!self::$version)
    {
      if (class_exists('PropelPDO', true))
      {
        self::$version = self::V13;
      }
      else
      {
        self::$version = self::V12;
      }
    }

    return self::$version;
  }

  /**
   * Sets a pretend version.
   *
   * @param float $version 
   */
  static public function set($version)
  {
    self::$version = $version;
  }

  /**
   * Clears the version to make it auto-detect again
   */
  static public function clear()
  {
    self::$version = null;
  }
}
