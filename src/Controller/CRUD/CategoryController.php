<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class CategoryController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
    ){}

    #[Route('/admin/create/categories', name:'app_admin_create_category', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_read_category');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/read/categories', name:'app_admin_read_category', methods: ['GET'])]
    public function readAction(): Response
    {
        return $this->render('admin/category/list.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
        ]);
    }

    #[Route('/admin/update/categories/{id}', name:'app_admin_update_category', methods: ['GET', 'POST'])]
    public function updateAction(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_read_category');
        }

        return $this->render('admin/category/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/delete/categories/{id}', name:'app_admin_delete_category', methods: ['GET', 'POST'])]
    public function deleteAction(Category $category): RedirectResponse
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_read_category');
    }
}
