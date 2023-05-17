<?php

namespace App\Controller;

use App\Entity\ChThread;
use App\Entity\ChPost;
use App\Form\ChThreadType;
use App\Form\ChPostType;
use App\Repository\ChThreadRepository;
use App\Repository\ChPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InquiryController extends AbstractController
{
    /**
     * @Route("/inquiry", name="app_inquiry", methods={"GET", "POST"})
     */
    public function index(Request $request, ChThreadRepository $chThreadRepository): Response
    {
        $new_thread = new ChThread();

        $form = $this->createForm(ChThreadType::class, $new_thread);
        $form->handleRequest($request);

        $new_thread->setParentId(null);
        $new_thread->setCreateDate(new \DateTime());
        $new_thread->setUpdateDate(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {
            $chThreadRepository->add($new_thread, true);

            return $this->redirectToRoute('app_inquiry_thread', ['id' => $new_thread->getId()], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('inquiry/index.html.twig', [
            'controller_name' => 'InquiryController',
            'ch_threads' => $chThreadRepository->findAll(),
            'form' => $form,
        ]);
    }
    /**
     * @Route("/inquiry/{id}/post", name="app_inquiry_thread", methods={"GET","POST"})
     */
    public function post(Request $request, $id, ChThreadRepository $chThreadRepository, ChPostRepository $chPostRepository): Response
    {
        $ch_thread = $chThreadRepository->find($id);
        $ch_posts = $chPostRepository->findBy(['thread_id' => $id], ['no' => 'ASC']);
        $newpost = new ChPost();

        $newpost->setThreadId($id);
        
        $endpost = end($ch_posts);
        if ($endpost == null) {
            $newpost->setNo(1);
        } else {
            $newpost->setNo($endpost->getNo()+1);
        }
        $newpost->setDate(new \DateTime());

        $form = $this->createForm(ChPostType::class, $newpost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chPostRepository->add($newpost, true);

            return $this->redirectToRoute('app_inquiry_thread', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inquiry/post.html.twig', [
            'ch_thread' => $ch_thread,
            'ch_posts' => $ch_posts,
            'newpost' => $newpost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/inquiry/{id}/delete", name="app_inquiry_post_delete", methods={"POST"})
     */
    public function delete(Request $request, ChPost $chPost, ChPostRepository $chPostRepository): Response
    {
        $chPost->setPostData("削除されました");
        if ($this->isCsrfTokenValid('delete'.$chPost->getId(), $request->request->get('_token'))) {
            $chPostRepository->add($chPost, true);
        }
        return $this->redirectToRoute('app_inquiry_thread', ['id' => $chPost->getThreadId()], Response::HTTP_SEE_OTHER);
    }

}
