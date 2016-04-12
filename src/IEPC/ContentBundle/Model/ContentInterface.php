<?php namespace IEPC\ContentBundle\Model;

/**
 * @package IEPC\ContentBundle\Model
 */
interface ContentInterface
{
    /**
     * @return int
     */
    public function getId();

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

    /**
     * Prints the string version of content object
     *
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public static function getEntityName();

    /**
     * @return string
     */
    public static function getEntityNamePlural();
}

