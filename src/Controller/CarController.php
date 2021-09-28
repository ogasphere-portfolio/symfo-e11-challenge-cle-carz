<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/car", name="admin_car_")
 */
class CarController extends AbstractController
{
    
     /**
     * @Route("/", name="browse", methods={"GET"})
     */
    public function browse(CarRepository $carRepository): Response
    {
        // on fournit ce formulaire à notre vue
        return $this->render('admin/car/browse.html.twig', [
            'car_list' => $carRepository->findAll()
        ]);
    }
    
    /**
    * @Route("/read/{id}", name="read", methods={"GET"}, requirements={"id"="\d+"})
    */
    public function read(Request $request, Car $car): Response
    {
        // on créé un formulaire avec l'objet récupéré
        // on modifie dynamiquement (dans le controleur) les options du formulaire
        // pour désactiver tous les champs
        $carForm = $this->createForm(CarType::class, $car, [
            'disabled' => 'disabled'
        ]);

        
        // on fournit ce formulaire à notre vue
        return $this->render('admin/car/read.html.twig', [
            'car_form' => $carForm->createView(),
            'car' => $car,
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $car= new Car();

        // on créé un formulaire vierge (sans données initiales car l'objet fournit est vide)
        $carForm = $this->createForm(CarType::class, $car);

        // Après avoir été affiché le handleRequest nous permettra
        // de faire la différence entre un affichage de formulaire (en GET) 
        // et une soumission de formulaire (en POST)
        // Si un formulaire a été soumis, il rempli l'objet fournit lors de la création
        $carForm->handleRequest($request);

        // l'objet de formulaire a vérifié si le formulaire a été soumis grace au HandleRequest
        // l'objet de formulaire vérifie si le formulaire est valide (token csrf mais pas que)
        if ($carForm->isSubmitted() && $carForm->isValid()) {

            // on ne demande l'entityManager que si on en a besoin
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($car);
            $entityManager->flush();

            // pour opquast 
            $this->addFlash('success', "Le vehicule `{$car->getModel()}` a bien été ajoutée");

            // redirection
            return $this->redirectToRoute('admin_car_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('admin/car/add.html.twig', [
            'car_form' => $carForm->createView(),
        ]);
    }

     /**
     * @Route("/edit/{id}", name="edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Car $car): Response
    {
        $carForm = $this->createForm(CarType::class, $car);

        $carForm->handleRequest($request);

        if ($carForm->isSubmitted() && $carForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            
            $entityManager->flush();

            $this->addFlash('success', "Category `{$car->getModel()}` udpated successfully");

            return $this->redirectToRoute('admin_car_browse');
        }

        // on fournit ce formulaire à notre vue
        return $this->render('admin/car/add.html.twig', [
            'car_form' => $carForm->createView(),
            'car' => $car,
            'page' => 'edit',
        ]);
    }
    /**
     * @Route("/delete/{id}", name="delete", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function delete(Car $car, EntityManagerInterface $entityManager): Response
    {
        $this->addFlash('success', "Car {$car->getId()} deleted");

        $entityManager->remove($car);
        $entityManager->flush();

        return $this->redirectToRoute('admin_car_browse');
    }
}



   