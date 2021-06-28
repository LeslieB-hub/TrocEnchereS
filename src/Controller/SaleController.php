<?php

namespace App\Controller;

use App\Entity\Sale;
use App\Entity\State;
use App\Entity\Withdrawal;
use App\Form\SaleType;
use App\Repository\CategoryRepository;
use App\Repository\StateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class SaleController extends AbstractController
{

    private $security;
    private $em;

    /**
     * Constructeur pour récupérer le user
     */
    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * @Route("/sale/add", name="sale_add")
     */
    public function add(Request $request, UserRepository $userRepo, CategoryRepository $categoryRepo, StateRepository $stateRepo): Response
    {
        //récupérer le user et son adresse
        $user = $userRepo->findOneBy(['username' => $this->security->getUser()->getUsername()]);
        //var_dump($user);
        //dump($user);
        $withdrawalPlace = new Withdrawal();
        $withdrawalPlace->setPostcode($user->getPostcode());
        $withdrawalPlace->setCity($user->getCity());
        $withdrawalPlace->setStreet($user->getStreet());

        $sale = new Sale();
        $sale->setSeller($user);
        dump($sale);
        dump($sale->getSeller());
        $sale->setWithdrawalPlace($withdrawalPlace);


        $saleForm = $this->createForm(SaleType::class, $sale, array('withdrawalPlace' => $withdrawalPlace));
        $saleForm->handleRequest($request);
        if ($saleForm->isSubmitted() && $saleForm->isValid()){
            $state = $stateRepo->findOneBy(['name'=>'Créée']);
            $sale->setState($state);

            $this->em->persist($sale);
            $this->em->flush();
            $this->addFlash('success', 'The sale has been saved!');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sale/sale.html.twig', [
            'saleForm' => $saleForm->createView(),
        ]);
    }

    /**
     * @Route("/sales", name="sale_list")
     */
    public function list(): Response
    {
        return $this->render('sale.html.twig', [
            'controller_name' => 'SaleController',
        ]);
    }

    /**
     * @Route("/sale/{id}", name="sale_detail",
     *     requirements={"id": "\d+"}, methods={"GET"})
     * si proprio de la vente qui visualise pas de proposition
     */
    public function detail(): Response
    {
        return $this->render('sale.html.twig', [
            'controller_name' => 'SaleController',
        ]);
    }

    /**
     * @Route("/sale/modify/{id}", name="sale_modify",
     *       requirements={"id": "\d+"}, methods={"GET", "Post"})
     */
    public function modify(): Response
    {
        return $this->render('sale.html.twig', [
            'controller_name' => 'SaleController',
        ]);
    }

    /**
     * @Route("/sale/cancel/", name="sale_cancel",
     *     requirements={"id": "\d+"}, methods={"GET", "Post"})
     */
    public function cancel(): Response
    {
        return $this->render('sale.html.twig', [
            'controller_name' => 'SaleController',
        ]);
    }

}
