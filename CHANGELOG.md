## Changelog

### 1.2.0 (2018-03-07)
* Add option to include content-length in result set

### 1.1.2 (2018-03-07)
* Update Accept header to accept images

### 1.1.1 (2016-11-04)
* Properly handle jpeg's with corrupted Exif tags 

### 1.1.0 (2016-04-30)
* Return message in return array when curl fails

### 1.0.3 (2016-04-9)
* Use external stream package

### 1.0.2 (2015-08-27)
* Fail invalid image exceptions gracefully when using batch requests

### 1.0.1 (2015-05-16)

* Support PHP v5.4+

### 1.0.0 (2015-05-16) [stable release!]

* Support for .PSD
* Support for .ICO + .CUR

### 0.0.7 (2015-05-16)

* Only support PHP v5.5+ for now :/

### 0.0.6 (2015-05-11)

* Add option to set timeout of requests
* Support for EXIF in .jpgs
* Better support for .bmp (including negative height bitmaps)
* Normalized response indexes for all file types

### 0.0.5 (2015-05-09)

* Support for .webp

### 0.0.4 (2015-05-07)

* Support for .tiff
* Start throwing exceptions for unknown file types

### 0.0.3 (2015-05-07)

* Force curl to follow redirects so you get less bad responses

### 0.0.2 (2015-05-06)

* Update curl headers to mimic browser so you get less bad responses

### 0.0.1 (2015-05-06) [alpha release!]

* Support for .jpg
* Support for .bmp
* Support for .gif
* Support for .png
* Support for parallel requests