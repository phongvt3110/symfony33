<?php
/**
 * Created by PhpStorm.
 * User: phongvt
 * Date: 10/17/17
 * Time: 11:07 AM
 */

namespace AppBundle\Controller;

use AppBundle\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;


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
     * @Route("/lucky/welcome/{name}")
     */
    public function welcomesAction($name){
        return new Response("<h1>Hello $name </h1>");
    }

    /**
     * @Route("/page/{page}", name="showpage", requirements={"page": "\d+"})
     */
    public function showpageAction($page = 1){   //$page will have default value is 1
        $data = ['mobile' => 'IphoneX',
            'page'  => $page
        ];
        $user = $this->getDoctrine()->getRepository(Users::class)->find(1);
        $data['id'] = $user->getId();
        $data['name'] = $user->getName();
        $data['email'] = $user->getEmail();
        $data['phone'] = $user->getPhone();
        return $this->render('frontend/pages.html.twig', [
            'data' => isset($data)? $data: null,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }

    /**
     * @Route("/lucky/create")
     */
    public function createuserAction(){
        $user = new Users();
        $user->setName("Phongabcghik");
        $user->setEmail("phongdefghik@gmail.com");
        $user->setPhone('0983397580');
        $user->setCreatedAt(new \DateTime('now'));
        $user->setUpdatedAt(new \DateTime('now'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        UsersRepository::findById(1);
        $usr = new UsersRepository();
        return new Response('<h1>Create new user Action</h1>');
    }

    /**
     * @Route(
     *     "/show/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function showAction($_locale, $year, $slug, $_format)
    {
        $data = ['mobile' => 'IphoneX',
            'locale' => $_locale,
            'year'  => $year,
            'slug'  => $slug,
            'format' => $_format
        ];
        return $this->render('frontend/show.html.twig', [
            'data' => isset($data)? $data: null
        ]);
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