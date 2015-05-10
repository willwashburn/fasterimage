<?php namespace FasterImage;

use FasterImage\Exception\StreamBufferTooSmallException;

/**
 * Class Stream
 *
 * @package FasterImage
 */
class Stream implements StreamableInterface
{
    /**
     * The string that we have downloaded so far
     */
    protected $stream_string = '';

    /**
     * The pointer in the string
     *
     * @var int
     */
    protected $strpos = 0;

    /**
     * Append to the stream string
     *
     * @param $string
     */
    public function write($string)
    {
        $this->stream_string .= $string;
    }

    /**
     * Get Characters from the string
     *
     * @param $characters
     *
     * @return string
     * @throws \FasterImage\Exception\StreamBufferTooSmallException
     */
    public function read($characters)
    {
        if ( strlen($this->stream_string) < $this->strpos + $characters ) {
            throw new StreamBufferTooSmallException('Not enough of the stream available.');
        }

        $result = substr($this->stream_string, $this->strpos, $characters);

        $this->strpos += $characters;

        return $result;
    }

    /**
     * Resets the pointer to the 0 position
     *
     * @return mixed
     */
    public function resetPointer()
    {
        $this->strpos = 0;
    }
}