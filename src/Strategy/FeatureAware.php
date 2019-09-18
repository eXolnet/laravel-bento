<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

interface FeatureAware
{
    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): Feature;
}
