<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        var_dump($_POST);
        
        /**
        $conn = pg_connect("host=localhost");

        SELECT id, username, firstname, lastname, email, created_on, modify_on FROM public.accounts where email = 'kammoun.salem@gmail.com';

        $result = pg_query($conn, "SELECT datname FROM pg_database");
        while ($row = pg_fetch_row($result)) {
            echo "<p>" . htmlspecialchars($row[0]) . "</p>\n";
        }
         */
 
        return $this->json([
            'message' => '1111Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

}
