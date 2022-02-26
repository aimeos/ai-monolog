<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2022
 */


namespace Aimeos\Base\Logger;


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

		$this->object = new \Aimeos\Base\Logger\Monolog( $log );
	}


	protected function tearDown() : void
	{
		@unlink( 'monolog.log' );
	}


	public function testLog()
	{
		$this->assertInstanceOf( \Aimeos\Base\Logger\Iface::class, $this->object->log( 'error' ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: error/', file_get_contents( 'monolog.log' ) );
	}


	public function testLoglevels()
	{
		$this->object->log( 'EMERGENCY', \Aimeos\Base\Logger\Iface::EMERG );
		$this->object->log( 'ALERT', \Aimeos\Base\Logger\Iface::ALERT );
		$this->object->log( 'CRITICAL', \Aimeos\Base\Logger\Iface::CRIT );
		$this->object->log( 'ERROR', \Aimeos\Base\Logger\Iface::ERR );
		$this->object->log( 'WARNING', \Aimeos\Base\Logger\Iface::WARN );
		$this->object->log( 'NOTICE', \Aimeos\Base\Logger\Iface::NOTICE );
		$this->object->log( 'INFO', \Aimeos\Base\Logger\Iface::INFO );
		$this->object->log( 'DEBUG', \Aimeos\Base\Logger\Iface::DEBUG );

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
		$this->assertInstanceOf( \Aimeos\Base\Logger\Iface::class, $this->object->log( array( 'error', 'error2', 2 ) ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: \["error","error2",2\]/', file_get_contents( 'monolog.log' ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'debug', \Aimeos\Base\Logger\Iface::DEBUG );
		$this->assertFalse( file_exists( 'monolog.log' ) );
	}


	public function testBadPriority()
	{
		$this->expectException( '\\Aimeos\\Base\\Logger\\Exception' );
		$this->object->log( 'error', -1 );
	}


	public function testFacility()
	{
		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new \Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new \Aimeos\Base\Logger\Monolog( $log, array( 'test' ) );

		$this->assertInstanceOf( \Aimeos\Base\Logger\Iface::class, $this->object->log( 'error', \Aimeos\Base\Logger\Iface::ERR ) );

		$this->assertFalse( file_exists( 'monolog.log' ) );
	}
}
