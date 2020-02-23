<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Pricelist;
use App\Entity\Caravan;

class PricelistController extends AbstractController
{
    /**
     * @Route("/pricelist/getTotalPriceVat/{caravanId}", name="getTotalPriceVatForPeriod", methods={"POST"})
     */
    public function getTotalPriceVatForPeriod(Request $request, int $caravanId): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $repoPricelist = $em->getRepository(Pricelist::class);
        $json = json_decode($request->getContent(), true);
        $caravan = $em->find(Caravan::class, $caravanId);

        if(!$caravan) throw $this->createNotFoundException("Karavan s id: $caravanId nenalezen.");

        $bookFrom = $json['bookFrom'] ? \DateTime::createFromFormat('d.m.Y', $json['bookFrom']) : null;
        $bookTill = $json['bookTill'] ? \DateTime::createFromFormat('d.m.Y', $json['bookTill']) : null;
        
        if($bookFrom === null || $bookTill === null) {
            return new JsonResponse([
                'status' => 'error',
            ]);
        }
        $totalPrice = $repoPricelist->findPriceVatForPeriod($bookFrom, $bookTill, $caravan);
        
        if(count($totalPrice) === 0) {
            return new JsonResponse([
                'status' => 'error',
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'totalPrice' => $totalPrice,
        ]);
    }
}
