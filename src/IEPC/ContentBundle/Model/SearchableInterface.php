<?php namespace IEPC\ContentBundle\Model;

/**
 * @author iZam b. <izma@mabkil.com>
 * @package IEPCContentBundle
 */
interface SearchableInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getKeywords();
}

