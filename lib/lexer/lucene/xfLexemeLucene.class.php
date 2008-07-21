<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A Lexeme that follows Lucene rules.
 *
 * @package sfSearch
 * @subpackage Lexer
 * @author Carl Vondrick
 */
class xfLexemeLucene extends xfLexeme
{
  const PHRASE = 3;
  const NUMBER = 4;
  const FIELD = 5;

  /**
   * @see xfLexeme
   */
  public function setType($type)
  {
    parent::setType($type);
  }
}
