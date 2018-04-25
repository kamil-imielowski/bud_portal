<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:40
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CMS;
use AppBundle\Entity\Practice;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PracticeController extends Controller
{
    /**
     * @Route("/praktyka/w-biurze", name="practice_office")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectOfficeAction(){
        $em = $this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $user = $this->getUser();
        if( !is_null($user) && $user->hasRole("ROLE_VIP")){
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'office']);
        }else{
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'office', 'isFree' => true]);
        }

        $description = $em->getRepository(CMS::class)->findOneBy(["place" => "praktyka w biurze projektowym"]);
        return $this->render("practice/projectOffice.html.twig", array(
            'files' => $files,
            'description' => $description,
        ));
    }

    /**
     * @Route("/praktyka/na-budowie", name="practice_onBuild")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onBuildingAction(){
        $em = $this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $user = $this->getUser();
        if( !is_null($user) && $user->hasRole("ROLE_VIP")){
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'build']);
        }else{
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'build', 'isFree' => true]);
        }

        $description = $em->getRepository(CMS::class)->findOneBy(["place" => "praktyka na budowie"]);
        return $this->render("practice/onBuild.html.twig", array(
            'files' => $files,
            'description' => $description,
        ));
    }

    /**
     * @Route("/praktyka/umowy", name="practice_contracts")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contractsAction(){
        $em = $this->getDoctrine()->getManager();

        /**
         * @var User $user
         */
        $user = $this->getUser();
        if( !is_null($user) && $user->hasRole("ROLE_VIP")){
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'contracts']);
        }else{
            $files = $em->getRepository(Practice::class)->findBy(['type' => 'contracts', 'isFree' => true]);
        }

        $description = $em->getRepository(CMS::class)->findOneBy(["place" => "praktyka umowy"]);
        return $this->render("practice/contracts.html.twig", array(
            'files' => $files,
            'description' => $description,
        ));
    }

    /**
     * @Route("/download/{name}", name="download_file")
     * @param $name
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFileAction($name){
        $em = $this->getDoctrine()->getManager();
        $f = $em->getRepository(Practice::class)->findOneBy(['file' => $name]);
        $filePath = $this->getParameter('kernel.project_dir') . '/web' . $this->getParameter('app.practice.files').$name;
        $path_parts = pathinfo($filePath);
        return $this->file($filePath, "{$f->getName()}.{$path_parts['extension']}");
    }
}