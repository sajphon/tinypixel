<?php

namespace App\Application\User\Controller;

use Exception;
use App\Application\User\DTO\AuthorDTO;
use App\Application\User\UseCase\GetAuthor;
use App\Application\User\Form\AuthorFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Application\User\UseCase\ListAuthors;
use App\Application\User\UseCase\DeleteAuthor;
use Symfony\Component\HttpFoundation\Response;
use App\Application\User\UseCase\CreateAuthor;
use App\Domain\Blog\Repository\BlogPostRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    private CreateAuthor                $createAuthor;
    private DeleteAuthor                $deleteAuthor;
    private GetAuthor                   $getAuthor;
    private ListAuthors                 $listAuthors;
    private BlogPostRepositoryInterface $blogPostRepository;

    public function __construct(
        CreateAuthor                $createAuthor,
        DeleteAuthor                $deleteAuthor,
        GetAuthor                   $getAuthor,
        ListAuthors                 $listAuthors,
        BlogPostRepositoryInterface $blogPostRepository
    )
    {
        $this->createAuthor       = $createAuthor;
        $this->deleteAuthor       = $deleteAuthor;
        $this->getAuthor          = $getAuthor;
        $this->listAuthors        = $listAuthors;
        $this->blogPostRepository = $blogPostRepository;
    }

    public function list(Request $request): Response
    {
        $page  = $request->query->getInt('page', 1);
        $limit = 10;

        $result = $this->listAuthors->execute($page, $limit);

        return $this->render(
            'author/list.html.twig',
            [
                'authors'     => $result['authors'],
                'currentPage' => $page,
                'totalPages'  => $result['totalPages'],
            ]);
    }

    public function create(Request $request): Response
    {
        $authorDTO = new AuthorDTO();
        $form      = $this->createForm(AuthorFormType::class, $authorDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createAuthor->execute($authorDTO->name, $authorDTO->email);

            $this->addFlash('success', 'Author created successfully!');
            return $this->redirectToRoute('author_list');
        }

        return $this->render(
            'author/create.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    public function detail(string $authorUuid, Request $request): Response
    {
        $author = $this->getAuthor->execute($authorUuid);

        $page  = $request->query->getInt('page', 1);
        $limit = 10;

        $blogPosts  = $this->blogPostRepository->findAllByAuthorPaginated($author->getId(), $page, $limit);
        $totalPosts = $this->blogPostRepository->countByAuthor($author->getId());
        $totalPages = (int)ceil($totalPosts / $limit);

        return $this->render(
            'author/detail.html.twig',
            [
                'author'      => $author,
                'blogPosts'   => $blogPosts,
                'currentPage' => $page,
                'totalPages'  => $totalPages,
            ]);
    }

    public function delete(string $authorUuid): Response
    {
        try {
            $this->deleteAuthor->execute($authorUuid);
        } catch (Exception $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('author_list');
        }

        $this->addFlash('success', 'Author deleted successfully!');
        return $this->redirectToRoute('author_list');
    }
}
