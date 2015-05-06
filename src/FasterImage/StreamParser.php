<?php namespace FasterImage;

use FasterImage\Exception\StreamBufferTooSmallException;

/**
 * Parses the stream of the image and determines the size and type of the image
 *
 * @package FasterImage
 */
class StreamParser
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
     * The type of image we've determined this is
     *
     * @var string
     */
    protected $type;

    /**
     * Append to the stream
     *
     * @param $string
     */
    public function append($string)
    {
        $this->stream_string .= $string;
    }

    /**
     * Reads and returns the type of the image
     *
     * @return bool|string
     */
    public function parseType()
    {
        if ( ! $this->type ) {
            $this->resetPointer();

            switch ( $this->getChars(2) ) {
                case "BM":
                    return $this->type = 'bmp';
                case "GI":
                    return $this->type = 'gif';
                case chr(0xFF) . chr(0xd8):
                    return $this->type = 'jpeg';
                case chr(0x89) . 'P':
                    return $this->type = 'png';
                case "RI":
                    if ( substr($this->getChars(10), 6, 4) == 'WEBP' ) {
                        return $this->type = 'webp';
                    }
                    return false;
                default:
                    return false;
            }
        }

        return $this->type;
    }


    /**
     * @return array|bool|null
     */
    public function parseSize()
    {
        $this->resetPointer();

        switch ( $this->type ) {
            case 'png':
                return $this->parseSizeForPNG();
            case 'gif':
                return $this->parseSizeForGIF();
            case 'bmp':
                return $this->parseSizeForBMP();
            case 'jpeg':
                return $this->parseSizeForJPEG();
            case 'webp':
                return $this->parseSizeForWebp();
        }

        return null;
    }


    /**
     * @return array|bool
     */
    private function parseSizeForJPEG()
    {
        $state = null;

        while ( true ) {
            switch ( $state ) {
                default:
                    $this->getChars(2);
                    $state = 'started';
                    break;

                case 'started':
                    $b = $this->getByte();
                    if ( $b === false ) return false;

                    $state = $b == 0xFF ? 'sof' : 'started';
                    break;

                case 'sof':
                    $b = $this->getByte();
                    if ( in_array($b, range(0xe0, 0xef)) ) {
                        $state = 'skipframe';
                    } elseif ( in_array($b, array_merge(range(0xC0, 0xC3), range(0xC5, 0xC7), range(0xC9, 0xCB), range(0xCD, 0xCF))) ) {
                        $state = 'readsize';
                    } elseif ( $b == 0xFF ) {
                        $state = 'sof';
                    } else {
                        $state = 'skipframe';
                    }
                    break;

                case 'skipframe':
                    $skip  = $this->readInt($this->getChars(2)) - 2;
                    $state = 'doskip';
                    break;

                case 'doskip':
                    $this->getChars($skip);
                    $state = 'started';
                    break;

                case 'readsize':
                    $c = $this->getChars(7);

                    return array($this->readInt(substr($c, 5, 2)), $this->readInt(substr($c, 3, 2)));
            }
        }

        return false;
    }


    /**
     * Reset the pointer to the 0 position
     */
    protected function resetPointer()
    {
        $this->strpos = 0;
    }


    /**
     * @param $characters
     *
     * @return bool|string
     * @throws \FasterImage\Exception\StreamBufferTooSmallException
     */
    protected function getChars($characters)
    {

        if ( ! is_numeric($characters) ) {
            throw new \InvalidArgumentException('"getChars" expects a number');
        }

        if ( strlen($this->stream_string) < $this->strpos + $characters ) {
            throw new StreamBufferTooSmallException('Not enough of the stream available.');
        }

        $result = substr($this->stream_string, $this->strpos, $characters);

        $this->strpos += $characters;

        return $result;
    }


    /**
     * @return mixed
     */
    private function getByte()
    {
        $c = $this->getChars(1);
        $b = unpack("C", $c);

        return reset($b);
    }

    /**
     * @param $str
     *
     * @return int
     */
    private function readInt($str)
    {
        $size = unpack("C*", $str);

        return ($size[1] << 8) + $size[2];
    }

    /**
     * @return array
     */
    private function parseSizeForPNG()
    {
        $chars = $this->getChars(25);

        return unpack("N*", substr($chars, 16, 8));
    }

    /**
     * @return array
     */
    private function parseSizeForGIF()
    {
        $chars = $this->getChars(11);

        return unpack("S*", substr($chars, 6, 4));
    }

    /**
     * @return array
     */
    private function parseSizeForBMP()
    {
        $chars = $this->getChars(29);
        $chars = substr($chars, 14, 14);
        $type  = unpack('C', $chars);

        return (reset($type) == 40) ? unpack('L*', substr($chars, 4)) : unpack('L*', substr($chars, 4, 8));
    }


}