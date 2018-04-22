<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 22.04.2018
 * Time: 19:18
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Advertising;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AdvertisingController extends Controller
{

    public function placeAction(int $place){
        $entityMenager = $this->getDoctrine()->getManager();
        $adverts = $entityMenager->getRepository(Advertising::class)->getNotExpiredAd($place);
        if(empty($adverts)){
            return new Response();
        }
        $index = rand(0, count($adverts) - 1);
        $advertising = $adverts[$index];

        return $this->render("Advertising/place_$place.html.twig", ["advertising" => $advertising]);
    }
}