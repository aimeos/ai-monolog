<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2016
 */


namespace Aimeos\MW\Logger;


/**
 * Test class for \Aimeos\MW\Logger\Monolog.
 */
class MonologTest extends \PHPUnit_Framework_TestCase
{
	private $object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		if( class_exists( '\\Monolog\\Logger' ) === false ) {
			$this->markTestSkipped( 'Class \\Monolog\\Logger not found' );
		}

		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new \Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new \Aimeos\MW\Logger\Monolog( $log );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		@unlink( 'monolog.log' );
	}


	public function testLog()
	{
		$this->object->log( 'error' );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: error/', file_get_contents( 'monolog.log' ) );
	}


	public function testLoglevels()
	{
		$this->object->log( 'EMERG', \Aimeos\MW\Logger\Base::EMERG );
		$this->object->log( 'ALERT', \Aimeos\MW\Logger\Base::ALERT );
		$this->object->log( 'CRITICAL', \Aimeos\MW\Logger\Base::CRIT );
		$this->object->log( 'ERROR', \Aimeos\MW\Logger\Base::ERR );
		$this->object->log( 'WARNING', \Aimeos\MW\Logger\Base::WARN );
		$this->object->log( 'NOTICE', \Aimeos\MW\Logger\Base::NOTICE );
		$this->object->log( 'INFO', \Aimeos\MW\Logger\Base::INFO );
		$this->object->log( 'DEBUG', \Aimeos\MW\Logger\Base::DEBUG );
	}


	public function testNonScalarLog()
	{
		$this->object->log( array( 'error', 'error2', 2 ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: \["error","error2",2\]/', file_get_contents( 'monolog.log' ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'debug', \Aimeos\MW\Logger\Base::DEBUG );
		$this->assertFalse( file_exists( 'monolog.log' ) );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( '\\Aimeos\\MW\\Logger\\Exception' );
		$this->object->log( 'error', -1 );
	}


	public function testFacility()
	{
		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new \Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new \Aimeos\MW\Logger\Monolog( $log, array( 'test' ) );

		$this->object->log( 'error', \Aimeos\MW\Logger\Base::ERR );

		$this->assertFalse( file_exists( 'monolog.log' ) );
	}
}
