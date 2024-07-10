<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Form\WalletType;
use App\Service\CoffeeMachine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CoffeeMachineController extends AbstractController
{
    /** @var Environment $twig */
    private Environment $twig;

    private FormFactoryInterface $formFactory;

    private CoffeeMachine $coffeeMachine;

    private EntityManagerInterface $manager;

    /**
     * @param Environment $twig
     */
    public function __construct(
        Environment $twig,
        FormFactoryInterface $formFactory,
        CoffeeMachine $coffeeMachine,
        EntityManagerInterface $manager
    )
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->coffeeMachine = $coffeeMachine;
        $this->manager = $manager;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    #[Route('/coffee-machine', name: 'coffee-machine', methods: ['GET', 'POST'])]
    public function coffeeMachine(Request $request): Response
    {
        $formWallet = $this->formFactory->create(WalletType::class)->handleRequest($request);
        $formOrder = $this->formFactory->create(OrderType::class)->handleRequest($request);

        if ($formWallet->isSubmitted() && $formWallet->isValid()) {
            $this->coffeeMachine->addWallet($formWallet->getData()->getWallet());
            $this->addFlash('success', 'Votre solde a bien été mis à jour');
            return $this->redirectToRoute('coffee-machine');
        }

        if ($formOrder->isSubmitted() && $formOrder->isValid()) {
            $this->coffeeMachine->newOrder($formOrder->getData());
            return $this->redirectToRoute('coffee-machine');
        }

        return new Response($this->twig->render("index.html.twig", [
            'form_wallet' => $formWallet->createView(),
            'form_order' => $formOrder->createView(),
            'coffee_machine' => $this->coffeeMachine->getCoffeeMachine(),
        ]));
    }

    #[Route('/coffee-machine-reset-wallet', name: 'coffee-machine-reset-wallet', methods: ['GET'])]
    public function coffeeMachineResetWallet(): Response
    {
        $this->coffeeMachine->resetWallet();
        $this->addFlash('success', 'Votre solde a bien été recupéré');

        return $this->redirectToRoute('coffee-machine');
    }
}