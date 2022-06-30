<?php
namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="property.index")
     */
    public function index(EntityManagerInterface $em, PropertyRepository $repository): Response
    {        
        
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
        ]);
    }
}