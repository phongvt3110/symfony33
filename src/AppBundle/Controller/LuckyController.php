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
//    private $name = ['Phong', 'Hung','Anh','Thanh','Dung','Diep','Truong','Minh','','Huan','Cuong','Bach',
//        'Manh','Loi','Thanh','Phung','Quynh','Lan','Hong','Cuc','Trong','Linh','Trinh','Oanh','Bang','Nam','Dong','Dan'];
//    private $lastname = ['Le','Nguyen','Tran','Ly','Doan','Vu','Phung','Trinh'];
//    private $middlename = ['thi','Ngoc','Huu','Xuan','Ngoc Tung','thi Kim','thi Thu','Thu','van','Ngọc Tam','Tan Hoang','Dai','Tung','thi Linh','Trang'];

    private $name = ['Phong', 'Hung','Anh','Thanh','Dung','Diep','Truong','Minh','','Huan','Cường','Bách',
        'Manh','Lợi','Thành','Phung','Quynh','Lan','Hong','Cuc','Trong','Linh','Trâm','Oanh','Bắc','Nam','Đông'];
    private $lastname = ['Le','Nguyen','Tran','Ly','Doan','Vu','Phung','Trinh','Cù','Vũ'];
    private $middlename = ['thi','Ngoc','Huu','Xuan','Ngoc Tung','thi Kim','thi Thu','Thu','van','Ngọc Tâm','Tân Hoàng','Đại','Tùng','Bách','thi Linh','Trang'];

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
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        print_r($user);
        return new Response('<h1>Create new user Action</h1>');
    }

    /**
     * @Route("/data/create/{n}",requirements={"n": "\d+"})
     */
    public function createusersAction($n = 1){
        for($i = 0; $i < intval($n); $i++){
            $user = new Users();
            $user->setName($this->makeRandomName());
            $user->setMiddleName($this->makeRandomMiddlename());
            $user->setLastName($this->makeRandomLastname());
            $user->setFullName($user->getLastName().' ' . $user->getMiddleName(). ' ' . $user->getName());
            $user->setEmail($this->stripVN($user->getName().$this->stripVN(substr($user->getLastName(),0,1))).'@gmail.com');
            $user->setPhone($this->makeRandomPhone());
            $user->setCreatedAt(new \DateTime('now'));
            $user->setUpdatedAt(new \DateTime('now'));
            $this->getDoctrine()->getEntityManager()->persist($user);
            $this->getDoctrine()->getEntityManager()->flush();
        }
        return new Response("<h1>Create new $n user Action</h1>");
    }

    /**
     * @Route("/data/list")
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(Users::class)->find(1);
        print_r($user);
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
     * @Route("/home")
     */
    public function homeAction(Request $request){
        $data = ['mobile' => 'IphoneX'];
        return $this->render('frontend/homepage.html.twig', [
            'data' => isset($data)? $data: null,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR
        ]);
    }

    private function makeRandomName() {
        return $this->name[intval(rand(0,count($this->name)-1))];
    }
    private function makeRandomLastname() {
        return $this->lastname[intval(rand(0,count($this->lastname)-1))];
    }
    private function makeRandomMiddlename() {
        return $this->middlename[intval(rand(0,count($this->middlename)-1))];
    }
    private function makeRandomPhone() {
        return '09'.strval(rand(10000000,99999999));
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