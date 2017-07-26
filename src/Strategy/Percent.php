<?php namespace Exolnet\Bento\Strategy;

class Percent extends Strategy
{
    /**
     * @var int
     */
    private $percent;

    /**
     * @param int $percent
     */
    public function __construct($percent)
    {
        $this->percent = $percent;
    }

    /**
     * @return bool
     */
    public function isLaunched()
    {
        $request = request();

        // Generate a unique number for the visitor that will always be the same.
        $visitorId = crc32($request->ip() . $request->header('user-agent'));

        // Limit this value between 1 and 100.
        $percentile = $visitorId % 100 + 1;

        // Based on the calculated percentile, we identify if the user has access to the feature.
        return $percentile <= $this->percent;
    }
}
