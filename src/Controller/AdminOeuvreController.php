<?php

namespace App\Controller;

use App\Entity\Oeuvres;
use App\Entity\Commentaire;
use App\Entity\OeuvreMatieres;
use App\Entity\Matiere;
use App\Form\Oeuvres2Type;
use App\Repository\MatiereRepository;
use App\Repository\OeuvresRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/admin/oeuvre")
 */
class AdminOeuvreController extends AbstractController
{

    /**
     * @Route("/", name="app_admin_oeuvre_index", methods={"GET"})
     */
    public function index(OeuvresRepository $oeuvresRepository): Response
    {
        return $this->render('admin_oeuvre/index.html.twig', [
            'oeuvres' => $oeuvresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_oeuvre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $oeuvre = new Oeuvres();
        $form = $this->createForm(Oeuvres2Type::class, $oeuvre, [
            'ajouter' => true
        ]);

        $form->handleRequest($request);
     
        if ($form->isSubmitted() && $form->isValid()) {

            $oeuvre->setDateAt(new \DateTimeImmutable('now'));

          

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter("imageOeuvre"),
                    $nomImage
                );
                $oeuvre->setImage($nomImage);
            }

        

            $manager->persist($oeuvre);
            $manager->flush();
            $this->addFlash("success", "Le produit N°" .  $oeuvre->getId()  .  " a bien été ajouté");
            return $this->redirectToRoute('app_admin_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_oeuvre/new.html.twig', [
            'oeuvre' => $oeuvre,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_admin_oeuvre_show", methods={"GET"})
     */
    public function show(Oeuvres $oeuvre): Response
    {
        return $this->render('admin_oeuvre/show.html.twig', [
            'oeuvre' => $oeuvre,
        
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_oeuvre_edit")
     */
    public function edit(Request $request, Oeuvres $oeuvre,EntityManagerInterface $manager): Response
    {


        $form = $this->createForm(Oeuvres2Type::class, $oeuvre, [
            'modifier' => true,
        ]);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
        

        

            $imageFile = $form->get('imageUpdate')->getData();
            if ($imageFile) {
                $nomImage = date("YmdHis") . "-" . uniqid() . "." . $imageFile->getClientOriginalExtension();

                $imageFile->move(
                    $this->getParameter("imageOeuvre"),
                    $nomImage
                );
                if ($oeuvre->getImage()) {

                    unlink($this->getParameter("imageOeuvre") . "/" . $oeuvre->getImage());
                }
                $oeuvre->setImage($nomImage);
            }




            $manager->persist($oeuvre);
            $manager->flush();
            $this->addFlash("success", "Le produit N°" . $oeuvre->getId() . " a bien été modifié");
            return $this->redirectToRoute('app_admin_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_oeuvre/edit.html.twig', [
            'oeuvre' => $oeuvre,
            'formEdit' => $form,

        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_oeuvre_delete")
     */
    public function delete(Request $request, Oeuvres $oeuvre, OeuvresRepository $oeuvresRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $oeuvre->getId(), $request->request->get('_token'))) {
            $entityManager->getConnection()->beginTransaction();
            try {
              


                // Supprimer les commentaires associés
                $entityManager->createQueryBuilder()
                    ->delete(Commentaire::class, 'c')
                    ->where('c.oeuvre = :oeuvre')
                    ->setParameter('oeuvre', $oeuvre)
                    ->getQuery()
                    ->execute();
                // Supprimer l'oeuvre elle-même
                $oeuvresRepository->remove($oeuvre, true);

                // Supprimer l'image associée si elle existe
                if ($oeuvre->getImage() && file_exists($this->getParameter('imageOeuvre') . "/" . $oeuvre->getImage())) {
                    unlink($this->getParameter('imageOeuvre') . "/" . $oeuvre->getImage());
                }

                $entityManager->getConnection()->commit();
            } catch (\Exception $e) {
                $entityManager->getConnection()->rollBack();
                throw $e;
            }
        }
        return $this->redirectToRoute('app_admin_oeuvre_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/sup", name="oeuvre_image_supprimer")
     */
    public function oeuvre_image_supprimer(Oeuvres $oeuvre, EntityManagerInterface $manager)
    {     
        $imagePath=$this->getParameter('imageOeuvre') . "/" . $oeuvre->getImage();
        if(file_exists($imagePath)){
              unlink($imagePath);
        }

        $oeuvre->setImage(NULL);
      
        $manager->persist($oeuvre);
        $manager->flush();
        // $this->addFlash("success", "L'image du produit N°" . $oeuvre->getId() . " a bien été supprimée");
        return $this->redirectToRoute("app_admin_oeuvre_edit", ["id" => $oeuvre->getId()]);
    }
}
