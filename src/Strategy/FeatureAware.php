<?php namespace Exolnet\Bento\Strategy;

interface FeatureAware
{
    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature();
}
