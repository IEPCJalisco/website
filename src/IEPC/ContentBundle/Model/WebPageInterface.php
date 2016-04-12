<?php namespace IEPC\ContentBundle\Model;

/**
 * @package IEPC\ContentBundle\Model
 */
interface WebPageInterface
{
    /**
     * Return the full path for URL
     *
     * @return string
     */
    public function getPagePath();

    public function getPageTitle();

    public function getPageDescription();

    public function getPageKeywords();

    public function getPageLayout();

    public function getPageContent();
}

