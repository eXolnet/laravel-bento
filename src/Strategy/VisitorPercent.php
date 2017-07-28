<?php namespace Exolnet\Bento\Strategy;

class VisitorPercent extends Percent
{
    /**
     * @return int
     */
    public function getUniqueId()
    {
        $request = request();

        // Generate a unique number for the visitor that will always be the same.
        return crc32($request->ip() . $request->header('user-agent'));
    }
}
