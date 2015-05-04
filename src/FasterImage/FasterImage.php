<?php namespace FasterImage;

use FasterImage\Exception\StreamBufferTooSmallException;

/**
 * FasterImage - Because sometimes you just want the size, and you want them in parallel!
 *
 * Based on the PHP stream implementation by Tom Moor (http://tommoor.com)
 * which was based on the original Ruby Implementation by Steven Sykes (https://github.com/sdsykes/fastimage)
 *
 * MIT Licensed
 * @version 0.01
 */
class FasterImage
{
    /**
     * Get the size of each of the urls in a list
     *
     * @param array $urls
     *
     * @return array
     * @throws \Exception
     */
    public function batch(array $urls) {

        $multi = curl_multi_init();
        $results = array();

        foreach ( $urls as $uri ) {

            $results[$uri] =[];

            $code = curl_multi_add_handle($multi, $this->handle($uri, $results[$uri]));

            if ( $code != CURLM_OK ) {
                throw new \Exception("Curl handle for $uri could not be added");
            }
        }

        do {
            while ( ($mrc = curl_multi_exec($multi, $active)) == CURLM_CALL_MULTI_PERFORM ) ;
            if ( $mrc != CURLM_OK && $mrc != CURLM_CALL_MULTI_PERFORM ) {
                throw new \Exception("Curl error code: $mrc");
            }

            if ( $active && curl_multi_select($multi) === -1 ) {
                // Perform a usleep if a select returns -1.
                // See: https://bugs.php.net/bug.php?id=61141
                usleep(250);
            }
        } while ( $active );

        return $results;

    }


    /**
     * Create the handle for the curl request
     *
     * @param $url
     * @param $result
     *
     * @return resource
     */
    private function handle($url, & $result)
    {
        $stream           = new StreamParser();
        $result['rounds'] = 0;
        $result['bytes']  = 0;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $str) use (& $result, & $stream) {

            $result['rounds']++;
            $result['bytes'] += strlen($str);

            $stream->append($str);

            // store the type in the result array by looking at the bits
            $result['type'] = $stream->parseType();

            try {
                /*
                 * We try here to parse the buffer of characters we already have
                 * for the size.
                 */
                $result['size'] = $stream->parseSize();
            }
            catch (StreamBufferTooSmallException $e) {
                /*
                 * If this exception is thrown, we don't have enough of the stream buffered
                 * so in order to tell curl to keep streaming we need to return the number
                 * of bytes we have already handled
                 *
                 * We set the 'size' to 'failed' in the case that we've done
                 * the entire image and we couldn't figure it out. Otherwise
                 * it'll get overwritten with the next round.
                 */
                $result['size'] = 'failed';

                return strlen($str);
            }

            /*
             * We return -1 to abort the transfer when we have enough buffered
             * to find the size
             */
            //
            // hey curl! this is an error. But really we just are stopping cause
            // we already have what we wwant
            return -1;
        });

        return $ch;
    }
}
