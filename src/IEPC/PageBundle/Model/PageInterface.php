<?php namespace IEPC\PageBundle\Model;

interface PageInterface
{
    public function getTitle();

    public function getContent();

    public function getLayout();

    public function getMetaDescription();

    public function getMetaKeywords();
}