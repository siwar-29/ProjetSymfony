<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Form\ProduitType;
use App\Entity\SearchByCategory;
use App\Form\SearchCategoryType;
use App\Repository\ProduitRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(): Response
    {
        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
        ]);
    }

    /**
     * @Route("/produit/add", name="produitAdd")
     */
    public function store(): Response
    {
        $produit = new Produit();
        $entityManager = $this->getDoctrine()->getManager();
        $produit->setNom('produit1');
        $produit->setPrix(10);
        $produit->setDescription('description1');
        $entityManager->persist($produit);
        $entityManager->flush();
        return new Response('produit ajouté');
    }

    /**
     * @Route("/produit/list", name="produitList")
     */
    public function list(ProduitRepository $repo, CategoryRepository $cat)
    {
        $list = $repo->findAll();
        $cats = $cat-> findAll();
        return $this->render('produit/list.html.twig', [
            'products' => $list,
            'cats' => $cats
        ]);

    }

    /**
     * @Route("/produit/ajout", name="produitAjout")
     */
    public function Ajout(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            //Recuperation de l'image
            $imageFile= $form->get("image")->getData();
            //Recuperer le nom de l'image
            $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            //le nomunique + extension
            $fileName=$originalFileName."-".uniqid().".".$imageFile->guessExtension();
            //deplacer l'image sous le dossier de telechargement
            $imageFile->move($this->getParameter('image_directory'),$fileName);
            //Enregistrer le nouveau nom dans la bd
            $produit->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('produitList');
        }
        return $this->render('produit/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/produit/edit/{id}", name="produitEdit")
     */
    public function update($id, Request $request)
    {
        $produit = new Produit();
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $produit = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();
            return $this->redirectToRoute('produitList');
        }
        return $this->render('produit/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/delete/{id}", name="produitDelete")
     */
    public function destroy($id)
    {
        $produit = new Produit();
        $entityManager = $this->getDoctrine()->getManager();
        $produit = $entityManager->getRepository(Produit::class)->find($id);
        $entityManager->remove($produit);
        $entityManager->flush();
        return $this->redirectToRoute('produitList');
    }

        /**
    * @Route("/Produit_cat/", name="produit_par_cat")
    * Method({"GET", "POST"})
    */
    public function articlesParCategorie(Request $request) {
        $categorySearch = new SearchByCategory();
        $form = $this->createForm(SearchCategoryType::class,$categorySearch);
        $form->handleRequest($request);
        $produits= [];
        if($form->isSubmitted() && $form->isValid()) {
        $category = $categorySearch->getCategory();
        if ($category!="")
        $produits= $category->getProduct();
        else
        $produits= $this->getDoctrine()->getRepository(Produit::class)->findAll();
        }
        return $this->render('produit/produitParCategorie.html.twig',['form'
        => $form->createView(),'produits' => $produits]);
        }
}