<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;

interface FeatureAwareStrategy
{
    /**
     * Set the current feature.
     *
     * @param  \Exolnet\Bento\Feature $feature
     * @return void
     */
    public function setFeature(Feature $feature): void;
}
