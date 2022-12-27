<?php

declare(strict_types=1);

namespace App\Controller\CRUD;

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
    public function __construct(
        private EntityManagerInterface $entityManager,
    ){}

    #[Route('/admin/create/category_types', name:'app_admin_create_category_type', methods: ['GET', 'POST'])]
    public function createAction(Request $request): Response
    {
        $CategoryType = new CategoryType();
        $form = $this->createForm(CategoryTypeType::class, $CategoryType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_read_category_type');
        }

        return $this->render('admin/category_type/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/read/category_types', name:'app_admin_read_category_type', methods: ['GET'])]
    public function readAction(): Response
    {
        return $this->render('admin/category_type/list.html.twig', [
            'category_types' => $this->entityManager->getRepository(CategoryType::class)->findAll(),
        ]);
    }

    #[Route('/admin/update/category_types/{id}', name:'app_admin_update_category_type', methods: ['GET', 'POST'])]
    public function updateAction(Request $request, CategoryType $CategoryType): Response
    {
        $form = $this->createForm(CategoryTypeType::class, $CategoryType);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_read_category_type');
        }

        return $this->render('admin/category_type/update.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/delete/category_types/{id}', name:'app_admin_delete_category_type', methods: ['GET', 'POST'])]
    public function deleteAction(CategoryType $CategoryType): RedirectResponse
    {
        $this->entityManager->remove($CategoryType);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_read_category_type');
    }
}
