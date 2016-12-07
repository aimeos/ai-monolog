<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2016
 * @package MW
 * @subpackage Logger
 */


namespace Aimeos\MW\Logger;


/**
 * Log messages using Monolog.
 *
 * @package MW
 * @subpackage Logger
 */
class Monolog
	extends \Aimeos\MW\Logger\Base
	implements \Aimeos\MW\Logger\Iface
{
	private $logger;
	private $facilities;


	/**
	 * Initializes the logger object.
	 *
	 * @param Monolog\Logger $logger Monolog logger object
	 * @param array|null $facilities Facilities for which messages should be logged
	 */
	public function __construct( \Monolog\Logger $logger, array $facilities = null )
	{
		$this->logger = $logger;
		$this->facilities = $facilities;
	}


	/**
	 * Writes a message to the configured log facility.
	 *
	 * @param string|array|object $message Message text that should be written to the log facility
	 * @param integer $priority Priority of the message for filtering
	 * @param string $facility Facility for logging different types of messages (e.g. message, auth, user, changelog)
	 * @throws \Aimeos\MW\Logger\Exception If an error occurs in Zend_Log
	 * @see \Aimeos\MW\Logger\Base for available log level constants
	 */
	public function log( $message, $priority = \Aimeos\MW\Logger\Base::ERR, $facility = 'message' )
	{
		try
		{
			if( $this->facilities === null || in_array( $facility, $this->facilities ) )
			{
				if( !is_scalar( $message ) ) {
					$message = json_encode( $message );
				}

				$this->logger->log( $this->translatePriority( $priority ), $message );
			}
		}
		catch( \Exception $e )	{
			throw new \Aimeos\MW\Logger\Exception( $e->getMessage(), $e->getCode(), $e );
		}
	}


	/**
	 * Translates the log priority to the log levels of Monolog.
	 *
	 * @param integer $priority Log level from \Aimeos\MW\Logger\Base
	 * @return integer Log level from Monolog\Logger
	 * @throws \Aimeos\MW\Logger\Exception If log level is unknown
	 */
	protected function translatePriority( $priority )
	{
		switch( $priority )
		{
			case \Aimeos\MW\Logger\Base::EMERG:
				return \Monolog\Logger::EMERGENCY;
			case \Aimeos\MW\Logger\Base::ALERT:
				return \Monolog\Logger::ALERT;
			case \Aimeos\MW\Logger\Base::CRIT:
				return \Monolog\Logger::CRITICAL;
			case \Aimeos\MW\Logger\Base::ERR:
				return \Monolog\Logger::ERROR;
			case \Aimeos\MW\Logger\Base::WARN:
				return \Monolog\Logger::WARNING;
			case \Aimeos\MW\Logger\Base::NOTICE:
				return \Monolog\Logger::NOTICE;
			case \Aimeos\MW\Logger\Base::INFO:
				return \Monolog\Logger::INFO;
			case \Aimeos\MW\Logger\Base::DEBUG:
				return \Monolog\Logger::DEBUG;
			default:
				throw new \Aimeos\MW\Logger\Exception( 'Invalid log level' );
		}
	}
}