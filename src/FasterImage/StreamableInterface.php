<?php namespace FasterImage;

/**
 * Interface StreamableInterface
 *
 * @package FasterImage
 */
interface StreamableInterface {

    /**
     * Append to the stream string
     *
     * @param $string
     */
    public function write($string);

    /**
     * Get Characters from the string
     *
     * @param $characters
     */
    public function read($characters);


    /**
     * Resets the pointer to the 0 position
     * @return mixed
     */
    public function resetPointer();

}