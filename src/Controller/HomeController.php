<?php
namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController
{  

    /**
     * @Route("/", name="home")
     * @return response
     */
    public function index(EntityManagerInterface $em, PropertyRepository $repository) :Response
    {
        $properties = $repository->findLatest();

        return $this->render('pages/home.html.twig', compact('properties'));
    }
}
