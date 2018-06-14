
# pluritech-image-php

# Image Upload for PHP from Base 64 (v1)

This repository contains the open source PHP that allows image upload from your PHP app with pre-configured size.


## Installation

The Library can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require pluritech-image-php/image-php
```

## Usage

Simple use example.

```php
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

use ImagePhp\GeneratorImageSDK as GeneratorImageSDK;
use \Exception;
use ImagePhp\Exception\ImageException;

$url_path = //web path where the picture will be uploaded
$dir =  //path where the picture will be uploaded

$config['url']      = $url_path;
$config['dir']           = $dir;
$config['width']         = 650;//pre-configured width to be set on image
$config['height']        = 310;//pre-configured height to be set on image
$config['thumb']         = true;// boolean type - specific if that image has thumb copy image as well
$config['thumb_width']   = 25;//pre-configured width to be set on thumb image
$config['thumb_height']  = 15;//pre-configured height to be set on thumb image
$config['water_mark']    = false;//boolean type - specific if that image will have water mark. If true, the water mark path must be send as second parameter.
$config['transparency']  = false;
$config['square']        = true;// boolean type - specific if that image has square copy image as well
$config['square_width']  = 200;//pre-configured width to be set on square image
$config['square_height'] = 200;//pre-configured height to be set on square image
    
generatorSDK = new GeneratorImageSDK($config);

try{
	$base64 = 'base 64 here' // on this site you can get 64 base from a image - https://www.base64-image.de/
	$photo = getGenerateImageSDK()->generatePhoto($base64);
	getGenerateImageSDK()->setPicture($photo);         
	$photo = getGenerateImageSDK()->automaticResize();
	getGenerateImageSDK()->setPicture($photo);
	$photo = getGenerateImageSDK()->createImages();


} catch (ImageException $e) {
    $photo['error'] = array(
        "code"        => 'F'.sprintf("%02d", $e->getCode()),
        "status"      => $e->getStatus(),
        "description" => $e->getMessage()
    );

    echo $photo;            
}
catch (Exception $e) {
    $photo['error'] = array(
        "code"        => 'F'.sprintf("%02d", $e->getCode()),
        "status"      => 'PictureError',
        "description" => $e->getMessage()
    );
    echo $photo;            
}
echo $photo;
}




```

## Documentation

In progress.


## Tests

In progress.


## Contributing

Feel free to make your pull request, chip in to suggestion or report issues.


## License

MIT © [Guilherme Valentim e Natália Gonçalves Machado](mailto:nathygmachado@gmail.com)





