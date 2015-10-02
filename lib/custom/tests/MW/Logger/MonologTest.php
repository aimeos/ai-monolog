<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Test class for MW_Logger_Monolog.
 */
class MW_Logger_MonologTest extends MW_Unittest_Testcase
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
		if( class_exists( '\Monolog\Logger' ) === false ) {
			$this->markTestSkipped( 'Class Monolog\Logger not found' );
		}

		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new MW_Logger_Monolog( $log );
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
		$this->object->log( 'EMERG', MW_Logger_Abstract::EMERG );
		$this->object->log( 'ALERT', MW_Logger_Abstract::ALERT );
		$this->object->log( 'CRITICAL', MW_Logger_Abstract::CRIT );
		$this->object->log( 'ERROR', MW_Logger_Abstract::ERR );
		$this->object->log( 'WARNING', MW_Logger_Abstract::WARN );
		$this->object->log( 'NOTICE', MW_Logger_Abstract::NOTICE );
		$this->object->log( 'INFO', MW_Logger_Abstract::INFO );
		$this->object->log( 'DEBUG', MW_Logger_Abstract::DEBUG );
	}


	public function testNonScalarLog()
	{
		$this->object->log( array( 'error', 'error2', 2 ) );
		$this->assertRegExp( '/^\[[^\]]+\] test.ERROR: \["error","error2",2\]/', file_get_contents( 'monolog.log' ) );
	}


	public function testLogDebug()
	{
		$this->object->log( 'debug', MW_Logger_Abstract::DEBUG );
		$this->assertFalse( file_exists( 'monolog.log' ) );
	}


	public function testBadPriority()
	{
		$this->setExpectedException( 'MW_Logger_Exception' );
		$this->object->log( 'error', -1 );
	}


	public function testFacility()
	{
		$log = new \Monolog\Logger( 'test' );
		$log->pushHandler( new Monolog\Handler\StreamHandler( 'monolog.log', \Monolog\Logger::INFO ) );

		$this->object = new MW_Logger_Monolog( $log, array( 'test' ) );

		$this->object->log( 'error', MW_Logger_Abstract::ERR );

		$this->assertFalse( file_exists( 'monolog.log' ) );
	}
}
