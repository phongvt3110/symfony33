<?php
/**
 * Created by PhpStorm.
 * User: phongvt
 * Date: 10/17/17
 * Time: 11:07 AM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/welcome")
     */
    public function welcomeAction(){
        return new Response('<h1>Welcome from the welcome Action</h1>');
    }
    /**
     * @Route("/home")
     */
    public function homeAction(Request $request){
        $data = ['mobile' => 'IphoneX'];
        return $this->render('frontend/homepage.html.twig', [
            'data' => isset($data)? $data: null,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }
}