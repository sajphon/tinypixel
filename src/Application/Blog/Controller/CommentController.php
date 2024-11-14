<?php

namespace App\Application\Blog\Controller;

use RuntimeException;
use App\Application\Blog\DTO\CommentDTO;
use Symfony\Component\HttpFoundation\Request;
use App\Application\Blog\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Blog\UseCase\Comments\AddComment;
use App\Application\Blog\UseCase\Comments\DeleteComment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    private AddComment    $addComment;
    private DeleteComment $deleteComment;

    public function __construct(AddComment $addComment, DeleteComment $deleteComment)
    {
        $this->addComment    = $addComment;
        $this->deleteComment = $deleteComment;
    }

    public function create(string $blogPostUuid, Request $request): Response
    {
        $commentDTO = new CommentDTO();
        $form       = $this->createForm(CommentFormType::class, $commentDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addComment->execute(
                $blogPostUuid,
                $commentDTO->content,
                $commentDTO->authorName,
                $commentDTO->authorEmail
            );

            $this->addFlash('success', 'Comment added successfully!');
            return $this->redirectToRoute('blog_detail', ['blogPostUuid' => $blogPostUuid]);
        }

        return $this->render(
            'comment/form.html.twig',
            [
                'form'         => $form->createView(),
                'blogPostUuid' => $blogPostUuid,
            ]);
    }

    public function delete(string $commentUuid, string $blogPostUuid): Response
    {
        try {
            $this->deleteComment->execute($commentUuid);
        } catch (RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
            return $this->redirectToRoute('blog_detail', ['blogPostUuid' => $blogPostUuid]);
        }
        $this->addFlash('success', 'Comment deleted successfully!');
        return $this->redirectToRoute('blog_detail', ['blogPostUuid' => $blogPostUuid]);
    }
}
