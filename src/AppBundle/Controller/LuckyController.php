<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Users;


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
     * @Route("/data/createuser")
     */
    public function createuserAction(){
        $user = new Users();
        $user->setName("Phong");
        $user->setMiddleName("Tung");
        $user->setLastName("Vu");
        $user->setFullName($user->getLastName().' '.$user->getMiddleName().' '.$user->getName());
        $user->setEmail("phongvt6510@gmail.com");
        $user->setPhone('0983397580');
        $user->setCreatedAt(new \DateTime('now'));
        $user->setUpdatedAt(new \DateTime('now'));
        $u = $this->getDoctrine()->getRepository(Users::class)->add($user);
        print_r($u);
        return new Response('<h1>Create new user Action</h1>');
    }

    /**
     * @Route("/data/find/{name}")
     */
    public function findusersAction($name = 'phong'){
        $users = $this->getDoctrine()->getRepository(Users::class)->findByName($name);
        print_r($users[0]);
        return new Response("<h1>Find user Action</h1>");
    }

    /**
     * @Route("/data/list")
     */
    public function listAction(){
        $users = $this->getDoctrine()->getRepository(Users::class)->findByName('Hung');
        print_r($users);
        return new Response("<h1> User info</h1><br>");
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
     * @Route("/luckyhome")
     */
    public function homeAction(Request $request){
        $data = ['mobile' => 'IphoneX'];
        return $this->render('frontend/homepage.html.twig', [
            'data' => isset($data)? $data: null,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }

    private function stripVN($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        return $str;
    }
}