<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Form\CategoryType;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('category/ajout.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/list", name="categoryList")
     */
    public function list(CategoryRepository $repo)
    {
        $list = $repo->findAll();
        return $this->render('category/list.html.twig', [
            'categories' => $list,
        ]);
    }

    /**
     * @Route("/category/add", name="addCategory")
     */
    public function Ajout(Request $request): Response
    {
        $cat = new Category();
        $form = $this->createForm(CategoryType::class, $cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('categoryList');
        }
        return $this->render('category/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/category/edit/{id}", name="editCategory")
     */
    public function update($id, Request $request)
    {
        $cat = new Category();
        $cat = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $form = $this->createForm(CategoryType::class, $cat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cat = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('categoryList');
        }
        return $this->render('category/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cat$cat/delete/{id}", name="deleteCategory")
     */
    public function destroy($id)
    {
        $cat = new Category();
        $entityManager = $this->getDoctrine()->getManager();
        $cat = $entityManager->getRepository(Category::class)->find($id);
        $entityManager->remove($cat);
        $entityManager->flush();
        return $this->redirectToRoute('categoryList');
    }
}