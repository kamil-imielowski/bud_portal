<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 09.04.2018
 * Time: 14:30
 */

namespace AppBundle\Controller;


use AppBundle\Entity\PaymentTransaction;
use AppBundle\Entity\Settings;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountUpgradeController extends Controller
{
    /**
     * @Route("/czlonkostwo", name="memberPlans")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function choosePlanAction(){
        $em = $this->getDoctrine()->getManager();
        $pricing = array();
        $pricing['one_month'] = $em->getRepository(Settings::class)->findOneBy(['valueKey' => 'one_month_subscription_price']);
        $pricing['three_month'] = $em->getRepository(Settings::class)->findOneBy(['valueKey' => 'three_month_subscription_price']);
        $pricing['six_month'] = $em->getRepository(Settings::class)->findOneBy(['valueKey' => 'six_month_subscription_price']);
        $pricing['one_year'] = $em->getRepository(Settings::class)->findOneBy(['valueKey' => 'one_year_subscription_price']);
        return $this->render("accountUpgrade/choosePlan.html.twig", array('pricing' => $pricing));
    }

    /**
     * @Route("/getPaymentStatus", name="getPaymentStatus", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function getPaymentStatusAction(Request $request){
        $operation_status = $request->get('operation_status');
        $control = $request->get('control');
        if($operation_status === 'completed'){
            $em = $this->getDoctrine()->getManager();
            $pt = $em->getRepository(PaymentTransaction::class)->findOneBy(['control' => $control]);
            $pt->setOperationNumber($request->get('operation_number'));
            $pt->setStatus(1);
            $em->persist($pt);
            $em->flush();
            $user = $pt->getUser();

            //dodanie roli o ile istnieje
            if(in_array('ROLE_VIP', $user->getRoles())){
                $to =  clone $user->getVipTo();
            }else{
                $user->addRole('ROLE_VIP');
                $to = new \DateTime();
            }
            $to->add(\DateInterval::createfromdatestring("+{$this->getTimeofPlan($pt->getPlan())} month"));
            $user->setVipTo($to);
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

        }
        return new Response("OK");
    }

    private function getTimeofPlan($plan){
        switch($plan){
            case 'one_month_subscription_price':
                return 1;
                break;

            case 'three_month_subscription_price':
                return 3;
                break;

            case 'six_month_subscription_price':
                return 6;
                break;

            case 'one_year_subscription_price':
                return 12;
                break;

            default:
                return 0;
        }
    }

    /**
     * @Route("/initTransaction", name="initTransaction", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function initTransaction(Request $request){
        $plan = $request->get('plan');
        $control = uniqid();
        $em = $this->getDoctrine()->getManager();
        $settingPlan = $em->getRepository(Settings::class)->findOneBy(['valueKey' => $plan]);

        $data = array();
        $data['control'] = $control;
        $data['dotpay_acc_id'] = "728828";
        $data['plan'] = $plan;
        $data['price'] = $settingPlan->getValue();

        //iniclizacja platnosci
        $pt = new PaymentTransaction();
        $pt->setControl($control);
        $pt->setStatus(0);
        $pt->setUser($this->getUser());
        $pt->setPlan($plan);
        $pt->setPrice($data['price']);
        $pt->setOperationNumber("");

        //zapis platnosci do bazy
        $em->persist($pt);
        $em->flush();

        //dane do przelewu w odp
        return new JsonResponse(array(
            'data' => $data,
            "success" => true
        ));
    }

    /**
     * @Route("/checkExpiredVIPs", name="checkExpiredVIPs")
     * @return Response
     */
    public function checkExpiredVIPs(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $now = new \DateTime();
        foreach ($users as $user){
            if($user->getVipTo() != null && $now >= $user->getVipTo()){
                $user->removeRole('ROLE_VIP');
                $user->setVipTo(null);
                $userManager = $this->get('fos_user.user_manager');
                $userManager->updateUser($user);
            }
        }
        return new Response("OK");
    }
}