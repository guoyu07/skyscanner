<?php

namespace MainBundle\Controller;


use MainBundle\Entity\Skyscanner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $sky = new Skyscanner("http://partners.api.skyscanner.net/apiservices","ca648373878536744215063892044569");
         // es-ES
        //$response = $sky->getLocales();
        $respone = $sky->get('/reference/v1.0/currencies');
        return $this->render('MainBundle::index.html.twig');
    }


}


