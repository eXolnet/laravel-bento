<?php namespace Exolnet\Bento\Strategy;

class Hostname extends Strategy
{
	/**
	 * @var array
	 */
	protected $hostames;

	public function __construct($hostnames)
	{
		$this->hostames = (array)$hostnames;
	}

	/**
	 * @return bool
	 */
	public function isLaunched()
	{
		$request = request();

		return in_array($request->getHost(), $this->hostames);
	}
}
