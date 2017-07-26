<?php namespace Exolnet\Bento\Strategy;

class Hostname extends Strategy
{
	/**
	 * @var array
	 */
	protected $hostnames;

	/**
	 * @param array|string $hostnames
	 */
	public function __construct($hostnames)
	{
		$this->hostnames = (array)$hostnames;
	}

	/**
	 * @return bool
	 */
	public function isLaunched()
	{
		$request = request();

		return in_array($request->getHost(), $this->hostnames);
	}
}
