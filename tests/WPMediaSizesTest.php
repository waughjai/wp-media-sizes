<?php

declare( strict_types = 1 );

require_once( 'MockWordPress.php' );
use PHPUnit\Framework\TestCase;
use WaughJ\WPMediaSizes\WPMediaSizes;

class WPMediaSizesTest extends TestCase
{
	public function testWordPressMock() : void
	{
		$this->assertEquals( [ "thumbnail", "medium", "medium_large", "large" ], get_intermediate_image_sizes() );
	}

	public function testAddedMediaSizes() : void
	{
		$this->assertEquals( 150, intval( get_option( "thumbnail_size_w" ) ) );
		$this->assertEquals( 150, intval( get_option( "thumbnail_size_h" ) ) );
		$this->assertEquals( true, boolval( get_option( "thumbnail_crop" ) ) );
		WPMediaSizes::add
		(
			[
				[
					'name' => 'small',
					'width' => 800,
					'height' => 1000
				],
				[
					'name' => 'huge',
					'width' => 2000,
					'height' => 1000
				]
			]
		);
		$this->assertEquals( [ "thumbnail", "medium", "medium_large", "large", "small", "huge" ], get_intermediate_image_sizes() );
		WPMediaSizes::add
		(
			[
				[
					'name' => 'tiny',
					'width' => 1,
					'height' => 1
				],
				[
					'name' => 'small',
					'width' => 200,
					'height' => 200
				],
				[
					'name' => 'gigantic',
					'width' => 5000,
					'height' => 2000
				],
				[
					'name' => 'thumbnail',
					'width' => 9999,
					'height' => 9999
				]
			]
		);
		$this->assertEquals( [ "thumbnail", "medium", "medium_large", "large", "small", "huge", "tiny", "gigantic" ], get_intermediate_image_sizes() );

		global $_wp_additional_image_sizes;
		$this->assertEquals( 2000, $_wp_additional_image_sizes[ 'huge' ][ 'width' ] );
		$this->assertEquals( 1, $_wp_additional_image_sizes[ 'tiny' ][ 'height' ] );
		$this->assertEquals( 200, $_wp_additional_image_sizes[ 'small' ][ 'width' ] );
		$this->assertEquals( 200, $_wp_additional_image_sizes[ 'small' ][ 'height' ] );
		$this->assertEquals( 9999, intval( get_option( "thumbnail_size_w" ) ) );
		$this->assertEquals( 9999, intval( get_option( "thumbnail_size_h" ) ) );
		$this->assertEquals( false, boolval( get_option( "thumbnail_crop" ) ) );
	}

	public function testSetMediaSizes() : void
	{
		WPMediaSizes::set
		(
			[
				[
					'name' => 'small',
					'width' => 800,
					'height' => 1000
				],
				[
					'name' => 'huge',
					'width' => 2000,
					'height' => 1000
				]
			]
		);
		WPMediaSizes::set
		(
			[
				[
					'name' => 'tiny',
					'width' => 1,
					'height' => 1
				],
				[
					'name' => 'gigantic',
					'width' => 5000,
					'height' => 2000
				]
			]
		);
		$this->assertEquals( [ "thumbnail", "medium", "medium_large", "large", "tiny", "gigantic" ], get_intermediate_image_sizes() );

		global $_wp_additional_image_sizes;
		$this->assertTrue( !array_key_exists( 'small', $_wp_additional_image_sizes ) );
		$this->assertTrue( !array_key_exists( 'huge', $_wp_additional_image_sizes ) );
		$this->assertEquals( 1, $_wp_additional_image_sizes[ 'tiny' ][ 'height' ] );
	}

	public function testClearMediaSizes() : void
	{
		WPMediaSizes::set
		(
			[
				[
					'name' => 'small',
					'width' => 800,
					'height' => 1000
				],
				[
					'name' => 'huge',
					'width' => 2000,
					'height' => 1000
				]
			]
		);
		WPMediaSizes::set
		(
			[
				[
					'name' => 'tiny',
					'width' => 1,
					'height' => 1
				],
				[
					'name' => 'gigantic',
					'width' => 5000,
					'height' => 2000
				],
				[
					'name' => 'medium',
					'width' => 948321
				]
			]
		);
		$this->assertEquals( 948321, intval( get_option( "medium_size_w" ) ) );
		WPMediaSizes::clear();
		$this->assertEquals( [ "thumbnail", "medium", "medium_large", "large" ], get_intermediate_image_sizes() );
		$this->assertEquals( 300, intval( get_option( "medium_size_w" ) ) );
	}
}
