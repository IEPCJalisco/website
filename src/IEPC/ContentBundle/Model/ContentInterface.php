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
     * Prints the string version of content object
     *
     * @return string
     */
    public function __toString();
}

