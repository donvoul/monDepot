<?php

namespace DWM\CatalogueBundle\Controller;

use Doctrine\DBAL\Types\TextType;
use DWM\CatalogueBundle\DWMCatalogueBundle;
use DWM\CatalogueBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use DWM\CatalogueBundle\Entity\Produit;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;





class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DWMCatalogueBundle:Default:index.html.twig');
    }

    /**
     * @param $nom
     * @param $prix
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function ajoutAction($nom, $prix)
    {
        $p = new Produit();
        $p->setnom($nom);
        $p->setprix($prix);
        $em = $this->getDoctrine()->getManager();
        $em->persist($p);
        $em->flush();

        //return array("produit"=> $p);
        return $this->render('DWMCatalogueBundle:Default:ajouter.html.twig', array("produit" => $p));
    }

    public function listeAction()
    {
        $produits = $this->getDoctrine()->getRepository("DWMCatalogueBundle:Produit")->findAll();


        return $this->render('DWMCatalogueBundle:Default:lister.html.twig', array("produits" => $produits));
    }


    public function formproduitAction(Request $request)
    {
        $p = new Produit();
        $form = $this->createFormBuilder($p)
            ->add('nom')
            ->add('prix')
            //->add("categorie",class_alias(Categorie::class), array("class"=>"DWMCatalogueBundle::classe/Categorie","property"=>"nomCat"))
            ->add('Ajouter', SubmitType::class)
            ->getForm();

       /* $form->handleRequest($request);
        if ($form->isValide()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
            return $this->redirect($this->generateUrl(dwm_catalogue_liste));*/


            // return $this->render('DWMCatalogueBundle:Default:formproduit.html.twig' ,array("produit"=>$p));
            return $this->render('DWMCatalogueBundle:Default:formproduit.html.twig', array("f" => $form->createView()));
            // return array("f"=> $form->createView());
        }
    }
