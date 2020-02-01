<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2020
 */


namespace Aimeos\MW\Logger;


class MonologTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		if( class_exists( '\\Monolog\\Logger' ) === false ) {
			$this->markTestSkipped( 'Class \\Monolog\\Logger not found' );
		}

		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new \Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new \Aimeos\MW\Logger\Monolog( $log );
	}


	protected function tearDown() : void
	{
		@unlink( 'monolog.log' );
	}


	public function testLog()
	{
		$this->assertInstanceOf( \Aimeos\MW\Logger\Iface::class, $this->object->log( 'error' ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: error/', file_get_contents( 'monolog.log' ) );
	}


	public function testLoglevels()
	{
		$this->object->log( 'EMERGENCY', \Aimeos\MW\Logger\Base::EMERG );
		$this->object->log( 'ALERT', \Aimeos\MW\Logger\Base::ALERT );
		$this->object->log( 'CRITICAL', \Aimeos\MW\Logger\Base::CRIT );
		$this->object->log( 'ERROR', \Aimeos\MW\Logger\Base::ERR );
		$this->object->log( 'WARNING', \Aimeos\MW\Logger\Base::WARN );
		$this->object->log( 'NOTICE', \Aimeos\MW\Logger\Base::NOTICE );
		$this->object->log( 'INFO', \Aimeos\MW\Logger\Base::INFO );
		$this->object->log( 'DEBUG', \Aimeos\MW\Logger\Base::DEBUG );

		$content = file_get_contents( 'monolog.log' );

		$this->assertStringContainsString( 'test.EMERGENCY: EMERGENCY', $content );
		$this->assertStringContainsString( 'test.ALERT: ALERT', $content );
		$this->assertStringContainsString( 'test.CRITICAL: CRITICAL', $content );
		$this->assertStringContainsString( 'test.ERROR: ERROR', $content );
		$this->assertStringContainsString( 'test.WARNING: WARNING', $content );
		$this->assertStringContainsString( 'test.NOTICE: NOTICE', $content );
		$this->assertStringContainsString( 'test.INFO: INFO', $content );
		$this->assertStringNotContainsString( 'test.DEBUG: DEBUG', $content );
	}


	public function testNonScalarLog()
	{
		$this->assertInstanceOf( \Aimeos\MW\Logger\Iface::class, $this->object->log( array( 'error', 'error2', 2 ) ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: \["error","error2",2\]/', file_get_contents( 'monolog.log' ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'debug', \Aimeos\MW\Logger\Base::DEBUG );
		$this->assertFalse( file_exists( 'monolog.log' ) );
	}


	public function testBadPriority()
	{
		$this->expectException( '\\Aimeos\\MW\\Logger\\Exception' );
		$this->object->log( 'error', -1 );
	}


	public function testFacility()
	{
		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new \Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new \Aimeos\MW\Logger\Monolog( $log, array( 'test' ) );

		$this->assertInstanceOf( \Aimeos\MW\Logger\Iface::class, $this->object->log( 'error', \Aimeos\MW\Logger\Base::ERR ) );

		$this->assertFalse( file_exists( 'monolog.log' ) );
	}
}
