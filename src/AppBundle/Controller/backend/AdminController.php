<?php
/**
 * Created by PhpStorm.
 * User: phongvt
 * Date: 3/23/18
 * Time: 4:55 PM
 */
namespace AppBundle\Controller\backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="adminhomepage")
     */
    public function indexAction() {
        $data = [];
        return $this->render('AdminLTE/index.html.twig', [
            'data' => isset($data) ? $data : null
        ]);
    }
}