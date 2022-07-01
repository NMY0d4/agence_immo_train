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

    #[Route('/biens/{slug}-{id}', name: 'property.show', methods: 'GET', requirements: ['slug' => "[a-z0-9\-]*"])]
    public function show(Property $property, string $slug): Response
    {        

        if ($property->getSlug() != $slug)
        {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property
        ]);
    }
}