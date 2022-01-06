<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2022
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
class Monolog implements Iface
{
	use Traits;


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
	 * @param int $priority Priority of the message for filtering
	 * @param string $facility Facility for logging different types of messages (e.g. message, auth, user, changelog)
	 * @return \Aimeos\MW\Logger\Iface Logger object for method chaining
	 * @throws \Aimeos\MW\Logger\Exception If an error occurs
	 * @see \Aimeos\MW\Logger\Iface for available log level constants
	 */
	public function log( $message, int $priority = Iface::ERR, string $facility = 'message' ) : Iface
	{
		try
		{
			if( $this->facilities === null || in_array( $facility, $this->facilities ) )
			{
				if( !is_scalar( $message ) ) {
					$message = json_encode( $message );
				}

				$this->logger->log( $this->getLogLevel( $priority ), $message );
			}
		}
		catch( \Exception $e ) {
			throw new Exception( $e->getMessage(), $e->getCode(), $e );
		}

		return $this;
	}


	/**
	 * Checks if the given log constant is valid
	 *
	 * @param int $level Log constant
	 * @return mixed Log level
	 * @throws \Aimeos\MW\Logger\Exception If log constant is unknown
	 */
	protected function getLogLevel( int $level )
	{
		switch( $level )
		{
			case \Aimeos\MW\Logger\Iface::EMERG: return \Monolog\Logger::EMERGENCY;
			case \Aimeos\MW\Logger\Iface::ALERT: return \Monolog\Logger::ALERT;
			case \Aimeos\MW\Logger\Iface::CRIT: return \Monolog\Logger::CRITICAL;
			case \Aimeos\MW\Logger\Iface::ERR: return \Monolog\Logger::ERROR;
			case \Aimeos\MW\Logger\Iface::WARN: return \Monolog\Logger::WARNING;
			case \Aimeos\MW\Logger\Iface::NOTICE: return \Monolog\Logger::NOTICE;
			case \Aimeos\MW\Logger\Iface::INFO: return \Monolog\Logger::INFO;
			case \Aimeos\MW\Logger\Iface::DEBUG: return \Monolog\Logger::DEBUG;
		}

		throw new \Aimeos\MW\Logger\Exception( 'Invalid log level' );
	}
}
