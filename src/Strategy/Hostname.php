<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Http\Request;

class Hostname extends Strategy
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $hostnames;

    /**
     * @param \Illuminate\Http\Request $request
     * @param array|string $hostnames
     */
    public function __construct(Request $request, $hostnames)
    {
        $this->request = $request;
        $this->hostnames = (array)$hostnames;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        $host = $this->request->getHost();

        return in_array($host, $this->hostnames);
    }
}
