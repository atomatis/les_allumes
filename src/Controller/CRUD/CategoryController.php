<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\AdminController;
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
#[Route('/admin')]
final class CategoryController extends AbstractController
{
    const ROUTE_CREATE = 'app_admin_create_category';
    const ROUTE_READ = 'app_admin_read_category';
    const ROUTE_UPDATE = 'app_admin_update_category';
    const ROUTE_DELETE = 'app_admin_delete_category';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CategoryRepository $categoryRepository,
    ){}

    #[Route('/create/categories', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute( self::ROUTE_READ);
        }

        return $this->render('admin/crud/create.html.twig', [
            'form' => $form,
            'pageTitle' => 'Nouvelle Categorie',
            'backRouteName' => self::ROUTE_READ,
        ]);
    }

    #[Route('/read/categories', name: self::ROUTE_READ, methods: ['GET'])]
    public function readAction(): Response
    {
        return $this->render('admin/crud/list.html.twig', [
            'entities' => $this->categoryRepository->findAll(),
            'pageTitle' => 'Categories',
            'entityName' => Category::getEntityName(),
            'backRouteName' => AdminController::ROUTE_DASHBOARD,
        ]);
    }

    #[Route('/update/categories/{id}', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function updateAction(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_READ);
        }

        return $this->render('admin/crud/update.html.twig', [
            'form' => $form,
            'pageTitle' => sprintf('Update %s', $category->getName()),
            'backRouteName' => self::ROUTE_READ,
        ]);
    }

    #[Route('/delete/categories/{id}', name: self::ROUTE_DELETE, methods: ['GET', 'POST'])]
    public function deleteAction(Category $category): RedirectResponse
    {
        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->redirectToRoute(self::ROUTE_READ);
    }
}
