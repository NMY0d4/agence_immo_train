<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
   
    #[Route('/admin', name: 'admin.property.index', methods: 'GET')]    
    public function index(PropertyRepository $repository) : Response
    {
        $properties = $repository->findAll();

        return $this->render('admin/property/index.html.twig', compact('properties'));

    }

    #[Route('/admin/property/create', name: 'admin.property.new', methods: ['GET', 'POST'])]        
    public function new (EntityManagerInterface $em, Request $request) : Response
    {
        $property = new Property;
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', 'Annonce créée avec succès.');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);

    }

    #[Route('/admin/property/edit/{id}', name: 'admin.property.edit', methods: ['GET', 'POST'], requirements: ['id' => "[0-9\-]*"])]
    public function edit(EntityManagerInterface $em,Property $property,Request $request) : Response
    {  
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Annonce modifié avec succès.');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);

    }

    #[Route('/admin/property/delete/{id}', name: 'admin.property.delete', methods: ['GET', 'DELETE'], requirements: ['id' => "[0-9\-]*"])]
    public function delete(EntityManagerInterface $em,Property $property,Request $request) : Response
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            
            // $em->remove($property);
            // $em->flush();
            $this->addFlash('success', 'Annonce supprimé avec succès.');            
            return new Response('Suppression');
            
        }

        return $this->redirectToRoute('admin.property.index');
    }

}