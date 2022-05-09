<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        $request = Request::createFromGlobals();
        
        $conn = pg_connect("host=localhost port=5431 dbname=mac");

        
        $selectSqlCommand = "SELECT * FROM public.accounts where email = '".$request->query->get('email')."' AND pass = '".$request->query->get('password')."'";
        
        
        $result = pg_query($conn,$selectSqlCommand);
        while ($row = pg_fetch_row($result)) {
            
            $_SESSION["admin"] = true;
            return $this->json([
                'message' => 'connected'
            ]);
            
        }
        
        
        $_SESSION["admin"] = false;
        return $this->json([
            'message' => 'not-connected'
        ]);

    }

}
