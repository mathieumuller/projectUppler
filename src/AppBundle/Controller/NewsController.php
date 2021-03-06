<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Uppler\NewsBundle\Form\Type\NewsType;
use Uppler\CommentBundle\Form\Type\CommentType;
use Uppler\NewsBundle\Model\NewsInterface;
use AppBundle\Entity\News;
use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class NewsController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render(
            'news/index.html.twig',
            [
                'news' => $this->getRepository('AppBundle:News')->findBy([], ['publicationDate' => 'desc']),
            ]
        );
    }

    /**
     * @Route("/news/edit/{id}", name="edit_news", defaults={"id" = null})
     * @ParamConverter("news", class="AppBundle:News", isOptional="true")
     */
    public function editNewsAction(Request $request, NewsInterface $news = null)
    {
        $fileUploader = $this->get('app.file_uploader');
        $factory = $this->getEntityFactory('AppBundle:News');
        if (is_null($news)) {
            $news = $factory->createFromArray(
                ['author' => $this->getUsername()]
            );
        } else {
            $this->denyAccessUnlessGranted('EDIT_NEWS', $news);
        }

        $form = $this->createForm(NewsType::class, $news, []);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($file = $news->getImageFile()) {
                list($filename, $orientation) = $fileUploader->upload($file);
                $news->setImage($filename)
                    ->setOrientation($orientation)
                ;
            }

            $factory->save($news);

            $this->addFlash('success', $this->get('translator')->trans('app.news.publication_success', []));

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'news/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/news/{id}/comments", name="news_comments")
     * @ParamConverter("news", class="AppBundle:News", isOptional="true")
     */
    public function commentsAction(Request $request, NewsInterface $news)
    {
        $factory = $this->getEntityFactory('AppBundle:Comment');
        $newComment = $factory->createFromArray(
            ['author' => $this->getUsername()]
        );

        $commentType = $this->createForm(CommentType::class, $newComment, []);
        $commentType->handleRequest($request);

        if ($commentType->isSubmitted() && $valid = $commentType->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $newComment->setNews($news);
            $factory->save($newComment);

            return $this->redirectToRoute('homepage', ['news' => $news->getId()]);
        }

        return $this->render(
            'news/comments.inc.html.twig',
            [
                'commentType' => $commentType->createView(),
                'post' => $news,
            ]
        );
    }
}
