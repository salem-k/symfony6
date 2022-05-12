<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    #[Route('/videoadd', name: 'videoadd_api')]
    public function videoadd(Request $request): Response
    {


        $myRequest = json_decode($request->getContent());
        print_r($myRequest);
        

        

        

        foreach($request->files as $uploadedFile) {
            $name = 'uploaded-file-name.jpg';
            $uploadedFile->move( $this->getParameter('uploads_dir'), md5(uniqid()) );

        }
        
        //move_uploaded_file($myRequest->videofile,'public/'.$myRequest->pubid);
        

        
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        $request = Request::createFromGlobals();

        $conn = pg_connect("host=localhost port=5431 dbname=mac");
        
        
        $myRequest = json_decode($request->getContent());


        $selectSqlCommand = "SELECT * FROM public.account where email = '".$myRequest->email."' AND pass = '".$myRequest->password."'";
        
        
        $result = pg_query($conn,$selectSqlCommand);
        //echo $selectSqlCommand;
        while ($row = pg_fetch_row($result)) {
            //echo $row;
            $_SESSION["admin"] = true;
            return $this->json([
                'message' => 'connected'
            ]);
            die;
        }
        
        
        $_SESSION["admin"] = false;
        return $this->json([
            'message' => 'not-connected'
        ]);

    }

}
