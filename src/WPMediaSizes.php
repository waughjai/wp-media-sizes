<?php

declare( strict_types = 1 );
namespace WaughJ\WPMediaSizes;

use WaughJ\TestHashItem\TestHashItem;

class WPMediaSizes
{
	public static function add( array $sizes ) : void
	{
        add_action
        (
            'init',
            function() use ( $sizes )
            {
                foreach ( $sizes as $size )
                {
                    if ( TestHashItem::isString( $size, 'name' ) )
                    {
						$width = $size[ 'width' ] ?? 0;
						$height = $size[ 'height' ] ?? 0;
						$crop = $size[ 'crop' ] ?? false;
						if ( in_array( $size[ 'name' ], self::DEFAULT_SIZE_NAMES ) )
						{
							update_option( $size[ 'name' ] . "_size_w", $width );
							update_option( $size[ 'name' ] . "_size_h", $height );
							update_option( $size[ 'name' ] . "_crop", $crop );
						}
						else
						{
	                        add_image_size( $size[ 'name' ], $width, $height, $crop );
						}
                    }
                }
            },
            11
        );
	}

	public static function set( array $sizes ) : void
	{
		self::clear();
		self::add( $sizes );
	}

	public static function clear() : void
	{
		$current_sizes = get_intermediate_image_sizes();
		foreach ( $current_sizes as $size )
		{
			remove_image_size( $size );
		}
	}

	public static function reset() : void
	{
		self::removeAll();
		self::add( self::DEFAULT_SIZES );
	}

	private const DEFAULT_SIZE_NAMES =
	[
		"thumbnail",
		"medium",
		"medium_large",
		"large"
	];

	private const DEFAULT_SIZES =
	[
		[
			'name' => 'thumbnail',
			'width' => 150,
			'height' => 150,
			'crop' => true
		],
		[
			'name' => 'medium',
			'width' => 300,
			'height' => 300,
			'crop' => false
		],
		[
			'name' => 'medium_large',
			'width' => 768,
			'height' => 768,
			'crop' => false
		],
		[
			'name' => 'large',
			'width' => 1024,
			'height' => 1024,
			'crop' => false
		]
	];
}
