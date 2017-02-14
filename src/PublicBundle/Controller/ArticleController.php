<?php

namespace PublicBundle\Controller;

use PublicBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use PublicBundle\Form\SearchType;

/**
 * Article controller.
 *
 * @Route("article")
 */
class ArticleController extends Controller
{
  /**
   * Lists all article entities.
   *
   * @Route("/", name="article_index")
   * @Method("GET")
   */
  public function indexAction()
  {
      $em = $this->getDoctrine()->getManager();

      $articles = $em->getRepository('PublicBundle:Article')->findAll();
      return $this->render('article/index.html.twig', array(
          'searchForm' => $searchForm->createView(),
          'articles' => $articles,
      ));
  }

    /**
    * Lists the 5 last articles.
    *
    * @Route("/recent", name="article_recent")
    * @Method({"GET", "POST"})
    */
    public function recentAction(Request $request)
    {

        $searchForm = $this->createForm(SearchType::class);

        if ($request->isMethod('POST')) {
            $searchForm->handleRequest($request);

            $searchedName = $request->request->get('search')['searchName'];
            $searchedTagName = $request->request->get('search')['searchTag'];

            if (($searchedName == null) || ($searchedTagName == null)) {
              if ($searchedName != null) {
                return $this->redirectToRoute('search_name', array(
                  'searchedName' => $searchedName,
                ));
              }

              if ($searchedTagName != null) {
                return $this->redirectToRoute('search_tag', array(
                  'searchedTagName' => $searchedTagName,
                ));
              }
            }

            else {
              return $this->redirectToRoute('search_nametag', array(
                'searchedName' => $searchedName,
                'searchedTagName' => $searchedTagName
              ));
            }

        }

        $em = $this->getDoctrine()->getManager();
        $lastFiveArticles = $em->getRepository('PublicBundle:Article')->getLastFiveArticles();

        return $this->render('article/recent.html.twig', array(
            'searchForm' => $searchForm->createView(),
            'lastFiveArticles' => $lastFiveArticles,
        ));
    }



    /**
    * Display the search by name results
    * @Route("/searchName/{searchedName}", name="search_name")
    */
    public function searchNameAction($searchedName) {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('PublicBundle:Article')
            ->findBy(array('name' => $searchedName))
          ;

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }


    /**
    * Display the search by tag results
    * @Route("/searchTag/{searchedTagName}", name="search_tag")
    */
    public function searchTagAction($searchedTagName) {
        $em = $this->getDoctrine()->getManager();

        $tag = $em->getRepository('PublicBundle:Tag')
            ->findBy(array('name' => $searchedTagName))
            ;

        $articles = $em->getRepository('PublicBundle:Article')->getArticlesByTag($tag);

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }


    /**
    * Display the search by tag results
    * @Route("/searchNameTag/{searchedName}/{searchedTagName}", name="search_nametag")
    */
    public function searchNameAndTagAction($searchedName, $searchedTagName) {
        $em = $this->getDoctrine()->getManager();

        die("TODO : multicriteria research");
        $tag = $em->getRepository('PublicBundle:Tag')
            ->findBy(array('name' => $searchedTagName))
            ;

        $articles = $em->getRepository('PublicBundle:Article')->getArticlesByTag($tag);

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new article entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('PublicBundle\Form\ArticleType', $article);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $article->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush($article);

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     * @Route("/{id}", name="article_show")
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('PublicBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_edit', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush($article);
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
