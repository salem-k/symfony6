<?php

namespace App\Controller;
use App\Entity\Video;
use App\Entity\Preset;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Persistence\ManagerRegistry;
class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/uploadbackground', name: 'uploadbackground_api')]
    public function uploadbackground(ManagerRegistry $doctrine): Response
    {



        $request = Request::createFromGlobals();

        $myRequest = json_decode($request->getContent());


        $backgroundFileName = md5(uniqid());
        foreach($request->files as $uploadedFile) {
            $uploadedFile->move( $this->getParameter('uploads_dir_background'), $backgroundFileName );
        }


        
        return $this->json([
            'background' => $backgroundFileName
        ]);
    }
    
    #[Route('/savepersets', name: 'savepersets_api')]
    public function savepersets(ManagerRegistry $doctrine): Response
    {

        $request = Request::createFromGlobals();
        $myRequest = json_decode($request->getContent());

        $entityManager = $doctrine->getManager();

        
            $date = new \DateTime();
            $persets = json_decode(json_encode($myRequest->persets), true);
            
            $repository = $doctrine->getRepository(Video::class);

            $video = $repository->findOneById($myRequest->video_id);


        
            foreach ($persets as &$value) {
                $perset = new Preset();
                $perset->setName($value["col1"]);
                $perset->setVideo($video);
                $perset->setData($value["col2"]);
                $perset->setColor($value["col3"]);
                $perset->setForecolor($value["col4"]);
                $perset->setFontsize($value["col5"]);
                if(isset($value["x"])) {
                    $perset->setPosx($value["x"]);
                }
                if(isset($value["y"])) {
                    $perset->setPosy($value["y"]);
                }
                //$perset->setPositionx($value["col6"]);
                //$perset->setPositiony($value["col7"]);
                $entityManager->persist($perset);
                $entityManager->flush();
            }

        return $this->json([
            'success' => 1,
        ]);
    }
    #[Route('/videoadd', name: 'videoadd_api')]
    public function videoadd(ManagerRegistry $doctrine): Response
    {

        $request = Request::createFromGlobals();

        $myRequest = json_decode($request->getContent());

        

        $videoFilename = md5(uniqid());
        foreach($request->files as $uploadedFile) {
            $uploadedFile->move( $this->getParameter('uploads_dir'), $videoFilename );
        }
        

        $entityManager = $doctrine->getManager();

        $date = new \DateTime();
        $video = new Video();
        $video->setTitle($myRequest->nomduprojet);
        $video->setDuration('300');
        $video->setPath($videoFilename);
        $video->getCreatedOn($date->getTimestamp());
        $video->getModifyOn($date->getTimestamp());
        $video->setIdu($myRequest->user_id);
        //sss
        $entityManager->persist($video);
        $entityManager->flush();
        
        return $this->json([
            'video' => $videoFilename,
            'id' => $video->getId()
        ]);

/*
        $selectSqlCommand = "SELECT id, title, duration, path, created_on, modify_on FROM public.video ORDER BY id DESC limit 1";
        $result = pg_query($conn,$selectSqlCommand);
        $row = pg_fetch_row($result);
        
        if (!$row) 
            $row[0] = 0;
        
        

        $insertSqlCommand = "INSERT INTO public.video(id, title, duration, path, created_on, modify_on) VALUES ($row[0]+1, '".$request->request->all()["nomduprojet"]."', 100, '".$videoFilename."', current_timestamp, current_timestamp);";

        $result = pg_query($conn,$insertSqlCommand);
*/        
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        $request = Request::createFromGlobals();
        $conn = pg_connect("host=localhost port=5431 dbname=mac7");
        $myRequest = json_decode($request->getContent());
        $selectSqlCommand = "SELECT * FROM account where email = '".$myRequest->email."' AND pass = '".$myRequest->password."'";
        
        
        $result = pg_query($conn,$selectSqlCommand);
        //echo $selectSqlCommand;
        while ($row = pg_fetch_row($result)) {
            //echo $row;
            $_SESSION["admin"] = $row;
            return $this->json([
                
                "id"=>$row[0],
                "username"=>$row[1],
                "firstname"=> $row[2],
                "lastname"=>$row[3],
                "email"=>$row[4]
            ]);
            
        }
        
        
        $_SESSION["admin"] = false;
        return $this->json([
            'message' => 'not-connected'
        ]);

    }

}
