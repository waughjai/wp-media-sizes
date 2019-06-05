<?php

declare( strict_types = 1 );

use PHPUnit\Framework\TestCase;
use WaughJ\WPMediaSizes\WPMediaSizes;

class WPMediaSizesTest extends TestCase
{
	public function testObjectWorks() : void
	{
		$object = new WPMediaSizes();
		$this->assertTrue( is_object( $object ) );
	}
}
