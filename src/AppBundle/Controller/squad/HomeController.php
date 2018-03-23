<?php
namespace AppBundle\Controller\squad;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="squadhomepage")
     */
    public function indexAction() {
        $data = [];
        return $this->render('Squad/index.html.twig', [
            'data' => isset($data) ? $data : null
        ]);
    }
}