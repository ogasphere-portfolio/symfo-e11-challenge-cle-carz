<?php

namespace App\Controller;

use App\Entity\Brand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/brand", name="admin_brand_")
 */
class BrandController extends AbstractController
{
    
     /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(Request $request): Response
    {
        // on fournit ce formulaire à notre vue
        return $this->render('admin/brand/browse.html.twig', [
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $brand= new Brand();

        // on créé un formulaire vierge (sans données initiales car l'objet fournit est vide)
        $brandForm = $this->createForm(BrandType::class, $brand);

        // Après avoir été affiché le handleRequest nous permettra
        // de faire la différence entre un affichage de formulaire (en GET) 
        // et une soumission de formulaire (en POST)
        // Si un formulaire a été soumis, il rempli l'objet fournit lors de la création
        $brandForm->handleRequest($request);

        // l'objet de formulaire a vérifié si le formulaire a été soumis grace au HandleRequest
        // l'objet de formulaire vérifie si le formulaire est valide (token csrf mais pas que)
        if ($brandForm->isSubmitted() && $brandForm->isValid()) {

            // on ne demande l'entityManager que si on en a besoin
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($brand);
            $entityManager->flush();

            // pour opquast 
            $this->addFlash('success', "La marque `{$brand->getName()}` a bien été ajoutée");

            // redirection
            return $this->redirectToRoute('admin_brand_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('admin/brand/add.html.twig', [
            'brand_form' => $brandForm->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Brand $brand): Response
    {
        $brandForm = $this->createForm(CategoryType::class, $brand);

        $brandForm->handleRequest($request);

        if ($brandForm->isSubmitted() && $brandForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('success', "Le vehicule `{$brand->getName()}` a bien été mise à jour");

            return $this->redirectToRoute('admin_brandForm_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('admin/brandForm/add.html.twig', [
            'category_form' => $brandForm->createView(),
        ]);
    }

}
