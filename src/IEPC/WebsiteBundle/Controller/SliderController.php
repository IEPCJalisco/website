<?php namespace IEPC\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SliderController extends Controller
{
    public function mainSliderAction()
    {
        return $this->render('@IEPCWebsite/_slider/mainSlider.html.twig');
    }
}
