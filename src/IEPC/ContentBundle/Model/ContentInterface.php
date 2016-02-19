<?php namespace IEPC\ContentBundle\Model;

/**
 * @author iZam b. <izma@mabkil.com>
 * @package IEPCContentBundle
 */
interface ContentInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * Renders the html representantion of content
     *
     * @return string
     */
    public function renderHtml();

    /**
     * Renders the json object representing the object
     *
     * @return string
     */
    public function renderJson();
}

