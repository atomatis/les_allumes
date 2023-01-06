<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

use App\Controller\AdminController;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\CategoryType;
use App\Form\CategoryTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @author Alexandre Tomatis <alexandre.tomatis@gmail.com> */
final class CategoryTypeController extends AbstractController
{
    const ROUTE_CREATE = 'app_admin_create_category_type';
    const ROUTE_READ = 'app_admin_read_category_type';
    const ROUTE_UPDATE = 'app_admin_update_category_type';
    const ROUTE_DELETE = 'app_admin_delete_category_type';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ){}

    #[Route('/create/category_types', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $CategoryType = new CategoryType();
        $form = $this->createForm(CategoryTypeType::class, $CategoryType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_READ);
        }

        return $this->render('admin/crud/create.html.twig', [
            'form' => $form,
            'pageTitle' => 'Nouveau type de category',
            'backRouteName' => self::ROUTE_READ,
        ]);
    }

    #[Route('/read/category_types', name: self::ROUTE_READ, methods: ['GET'])]
    public function readAction(): Response
    {
        return $this->render('admin/crud/list.html.twig', [
            'entities' => $this->entityManager->getRepository(CategoryType::class)->findAll(),
            'pageTitle' => 'Types de catégorie',
            'entityName' => CategoryType::getEntityName(),
            'backRouteName' => AdminController::ROUTE_DASHBOARD,
        ]);
    }

    #[Route('/update/category_types/{id}', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function updateAction(Request $request, CategoryType $CategoryType): Response
    {
        $form = $this->createForm(CategoryTypeType::class, $CategoryType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_READ);
        }

        return $this->render('admin/crud/update.html.twig', [
            'form' => $form,
            'pageTitle' => sprintf('Update %s', $CategoryType->getName()),
            'backRouteName' => self::ROUTE_READ,
        ]);
    }

    #[Route('/delete/category_types/{id}', name: self::ROUTE_DELETE, methods: ['GET', 'POST'])]
    public function deleteAction(CategoryType $CategoryType): RedirectResponse
    {
        $this->entityManager->remove($CategoryType);
        $this->entityManager->flush();

        return $this->redirectToRoute(self::ROUTE_READ);
    }
}
