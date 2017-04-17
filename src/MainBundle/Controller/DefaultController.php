<?php

namespace MainBundle\Controller;


use MainBundle\Entity\Skyscanner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $sky = new Skyscanner("http://partners.api.skyscanner.net/apiservices", "ca648373878536744215063892044569");

        // es-ES
        // $response = $sky->getLocales();
        // EUR
        // $response = $sky->get('/reference/v1.0/currencies');

        // ES / MX
        // $response = $sky->get('/reference/v1.0/countries/es-ES');

        // BCN = BARC
        // MX = MEXA
        // $response = $sky->get('/geo/v1.0');

        $info = array(
            'country' => 'ES',
            'currency' => 'EUR',
            'locale' => 'es-ES',
            'originPlace' => 'BARC',
            'destinationPlace' => 'MXA',
            'outboundDate' => '2017-05-15',
            'inboundDate' => '2017-06-15',
            'cabinClass' => 'economy',
            'adults' => '1',
            'apiKey' => 'ca648373878536744215063892044569'
        );
        $response = $sky->post('/pricing/v1.0',$info);

        $data = json_encode($response);
        return new Response($data);
    }


}


