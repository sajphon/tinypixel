<?php

namespace App\Application\Blog\Controller;

use App\Application\Blog\DTO\BlogPostDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Application\Blog\Form\BlogPostFormType;
use App\Application\Blog\UseCase\Posts\GetBlogPost;
use App\Application\Blog\UseCase\Posts\ListBlogPosts;
use App\Application\Blog\UseCase\Posts\CreateBlogPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    private CreateBlogPost $createBlogPost;
    private ListBlogPosts  $listBlogPosts;
    private GetBlogPost    $getBlogPost;

    public function __construct(
        CreateBlogPost $createBlogPost,
        ListBlogPosts  $listBlogPosts,
        GetBlogPost    $getBlogPost
    )
    {
        $this->createBlogPost = $createBlogPost;
        $this->listBlogPosts  = $listBlogPosts;
        $this->getBlogPost    = $getBlogPost;
    }

    public function list(Request $request): Response
    {
        $page  = $request->query->getInt('page', 1);
        $limit = 5;

        $result = $this->listBlogPosts->execute($page, $limit);

        return $this->render(
            'blog/list.html.twig',
            [
                'blogPosts'   => $result['blogPosts'],
                'currentPage' => $page,
                'totalPages'  => $result['totalPages'],
            ]);
    }

    public function create(Request $request): Response
    {
        $blogPostDTO = new BlogPostDTO();

        $form = $this->createForm(BlogPostFormType::class, $blogPostDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createBlogPost
                ->execute(
                    $blogPostDTO->title,
                    $blogPostDTO->description,
                    $blogPostDTO->content,
                    $blogPostDTO->author->getUuid()
                );

            $this->addFlash('success', 'Blog post created successfully!');
            return $this->redirectToRoute('blog_list');
        }

        return $this->render(
            'blog/create.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

    public function detail(string $blogPostUuid): Response
    {
        $blogPost = $this->getBlogPost->execute($blogPostUuid);

        return $this->render(
            'blog/detail.html.twig',
            [
                'blogPost' => $blogPost,
            ]);
    }


}