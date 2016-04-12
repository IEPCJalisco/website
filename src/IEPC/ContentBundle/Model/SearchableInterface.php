<?php namespace IEPC\ContentBundle\Model;

/**
 * @package IEPC\ContentBundle\Model
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

