<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route("/personne")]
class PersonneController extends AbstractController
{

    #[Route('/alls', name: 'alls.list')]
    public function index(ManagerRegistry $doctrine)
    {

        $repository = $doctrine->getRepository(Personne::class);

        $personnes = $repository->findAll();

        return $this->render('personne/index.html.twig', [
            "personnes" => $personnes
        ]);
    }

    #[Route('/find/{id?1<\d>}', name: 'find.list')]
    public function find(ManagerRegistry $doctrine, $id)
    {

        $repository = $doctrine->getRepository(Personne::class);

        $personne = $repository->find($id);

        if (!$personne) {

            $this->addFlash("danger", "La personne d'id $id n'existe pas dans la base de donnee !");
            return $this->redirectToRoute('alls.list');
        }

        return $this->render('personne/details.html.twig', [
            "personne" => $personne
        ]);
    }


    #[Route('/add', name: 'personne.add')]
    public function add(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {

        $entityRegistry = $doctrine->getManager();

        $personne = new Personne();

        $form = $this->createForm(PersonneType::class, $personne);
        $form->remove("created_at");
        $form->remove("updated_at");

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $brochureFile = $form->get('image')->getData();
            

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('profile_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $personne->setImage($newFilename);
            }

            $entityRegistry->persist($personne);
            $entityRegistry->flush();

            $nom = $form->getData()->getNom();

            $this->addFlash("success", "La personne $nom a bien été ajoutée");
            return $this->redirectToRoute('alls.list');
        } else {
            return $this->render('personne/add.html.twig', [
                "form" => $form->createView()
            ]);
        }
    }



    #[Route('/edit/{id}', name: 'personne.edit')]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {

        $entityRegistry = $doctrine->getManager();

        $getPersonnes = $entityRegistry->getRepository(Personne::class)->find($id);

        if ($getPersonnes) {
            $form = $this->createForm(PersonneType::class, $getPersonnes);
            $form->remove("created_at");
            $form->remove("updated_at");

            $form->handleRequest($request);

            if ($form->isSubmitted()) {

                $entityRegistry->persist($getPersonnes);
                $entityRegistry->flush();

                $nom = $form->getData()->getNom();

                $this->addFlash("success", "La personne $nom a bien été modifiée");
                return $this->redirectToRoute('alls.list');
            } else {
                return $this->render('personne/add.html.twig', [
                    "form" => $form->createView(),
                    "personne" => $getPersonnes
                ]);
            }
        } else {
            $this->addFlash("danger", "La personne d'id $id n'existe pas !");
            return $this->redirectToRoute('alls.list');
        }
    }

    #[Route('/delete/{id}', name: 'personne.delete')]
    public function delete(Personne $personne = null, ManagerRegistry $doctrine): Response
    {

        $entityRegistry = $doctrine->getManager();

        if (!$personne) {
            $this->addFlash("danger", "La personne n'existe pas");
            return $this->redirectToRoute('alls.list');
        } else {
            $this->addFlash("success", "Cette personne a ete supprime avec success");
        }

        $entityRegistry->remove($personne);


        $entityRegistry->flush();

        return $this->redirectToRoute('alls.list');
    }
}
