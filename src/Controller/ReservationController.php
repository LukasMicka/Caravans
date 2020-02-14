<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Caravan;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation/create/{caravanId}", name="createReservation", methods={"POST"})
     */
    public function create(Request $request, int $caravanId, ValidatorInterface $validator): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $json = json_decode($request->getContent(), true);

        $firstName = $json['firstName'] ?: null;
        $surname = $json['surname'] ?: null;
        $phone = $json['phone'] ?: null;
        $email = $json['email'] ?: null;
        $bookFrom = $json['bookFrom'] ? \DateTime::createFromFormat('d.m.Y', $json['bookFrom']) : null;
        $bookTill = $json['bookTill'] ? \DateTime::createFromFormat('d.m.Y', $json['bookTill']) : null;
        $customerNote = $json['note'] ?: null;

        $caravan = $em->find(Caravan::class, $caravanId);

        if (!$caravan) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Rezervaci karavanu nebylo možné provést. Zkuste prosím zopakovat akci, popř. nás kontaktujte.',
            ]);
        }

        $reservation = new Reservation();
        $reservation->setCaravan($caravan);
        $reservation->setFirstName($firstName);
        $reservation->setSurname($surname);
        $reservation->setPhone($phone);
        $reservation->setEmail($email);
        $reservation->setReservationFrom($bookFrom);
        $reservation->setReservationTo($bookTill);
        $reservation->setCustomerNote($customerNote);
        
        $errors = $validator->validate($reservation);

        if (count($errors) > 0) {
            $messages = "";
            foreach ($errors as $error) {
                $messages .= "{$error->getMessage()} \n";
            }

            return new JsonResponse([
                'status' => 'error',
                'message' => $messages,
            ]);
        }

        $em->persist($reservation);
        $em->flush();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Rezervace byla úspěšně odeslána. Budeme Vás kontaktovat ohledně jejího potvrzení.',
        ]);
    }
}
