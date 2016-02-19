<?php namespace IEPC\ContentBundle\Model;

/**
 * @author iZam b. <izma@mabkil.com>
 * @package IEPCContentBundle
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

