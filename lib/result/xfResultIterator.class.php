<?php
/**
 * The result object that contains multiple results.
 * 
 * This might have too many dependencies.
 *
 * @package sfSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
final class xfResultIterator implements SeekableIterator, Countable
{
  /**
   * The iterator.
   *
   * @var SeekableIterator
   */
  private $iterator;

  /**
   * The service registry.
   *
   * @var xfServiceRegistry
   */
  private $registry;

  /**
   * Constructor to set initial values.
   *
   * @param SeekableIterator $iterator A seekable iterator of xfDocument
   * @param xfServiceRegistry $registry The service registry
   */
  public function __construct(SeekableIterator $iterator, xfServiceRegistry $registry)
  {
    $this->iterator = $iterator;
    $this->registry = $registry;
  }

  /**
   * Returns the current result
   *
   * @returns xfDocumentHit
   */
  public function current()
  {
    $hit = $this->iterator->current();

    // this response is pluggable, we must do error checking
    if (!($hit instanceof xfDocumentHit))
    {
      throw new xfResultException('Iterator for engine must return instances of xfDocumentHit, ' . gettype($hit) . ' given');
    }

    $serviceName = $hit->getDocument()->getField('_service')->getValue();
    $service = $this->registry->getService($serviceName);
    $hit->setRetorts($service->getRetorts());

    return $hit;
  }

  /**
   * Returns the current key
   *
   * @returns int
   */
  public function key()
  {
    return $this->iterator->key();
  }

  /**
   * Advances the pointer.
   */
  public function next()
  {
    $this->iterator->next();
  }

  /**
   * Rewinds the pointer.
   */
  public function rewind()
  {
    $this->iterator->rewind();
  }

  /**
   * Tests to see if pointer is valid.
   */
  public function valid()
  {
    $this->iterator->valid();
  }

  /**
   * Seeks the pointer.
   *
   * @param int $pointer
   */
  public function seek($pointer)
  {
    $this->iterator->seek($pointer);
  }

  /**
   * Counts the total number of documents.
   *
   * @returns int
   */
  public function count()
  {
    return count($this->iterator);
  }
}
