WP Media Sizes
=========================

Class that simplifies setting WordPress media sizes.

## Usage

    use WaughJ\WPMediaSizes\WPMediaSizes;

    WPMediaSizes::add
    ([
		[ 'name' => 'thumbnail',    'width' =>  300, 'height' => 300, 'crop' => true ],
		[ 'name' => 'small',        'width' =>  800, 'height' => 600                 ],
		[ 'name' => 'small_medium', 'width' => 1200, 'height' => 600                 ],
		[ 'name' => 'medium',       'width' => 1440, 'height' => 900                 ],
		[ 'name' => 'medium_large', 'width' => 1600, 'height' => 900                 ],
		[ 'name' => 'large',        'width' => 1920, 'height' => 1200                ],
		[ 'name' => 'huge',         'width' => 2560, 'height' => 1440                ]
    ]);

## Changelog

### 0.2.0
* Separate clear and reset functions

### 0.1.0
* Initial release