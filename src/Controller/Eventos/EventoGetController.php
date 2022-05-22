<?php

namespace App\Controller\Eventos;

use App\Entity\Evento;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventoGetController extends AbstractController {

    #[Route('/eventos', name: 'app_evento_get')]
    public function get(ManagerRegistry $doctrine, Request $request): Response {
        $actual_month = (new DateTime())->format("F");
        $arrayEventos = $doctrine->getRepository(Evento::class)->findByMonthEvents($actual_month);
        
        //checkboxes de tipos
        $typesForm = $this->createFormBuilder()
                ->add('tipo', ChoiceType::class, [
                    'choices' => [
                        'Evento deportivo' => 'deportivo', 
                        'Evento cultural' => 'cultural', 
                        'Tradiciones y fiestas locales' => 'tradicion'],
                    'multiple' => false,
                    'expanded' => true,
                ])
                ->getForm();

        $typesForm->handleRequest($request);

        if ($typesForm->isSubmitted() && $typesForm->isValid()) {
            $types = $typesForm->getData();
            //redireccionamos al metodo que recupera los datos de la bd y cambiamos la url
            return $this->redirectToRoute("app_eventos_type_get", ['types' => $types]);
        }
        
        //select de meses
        $nextMonths = array();
        $actual_month = (new DateTime())->format("F");
        for ($i = $actual_month; $i <= 12; $i++) {
            $dateObj = DateTime::createFromFormat('!m', $i);
            array_push($nextMonths, $dateObj);
        }

        $monthForm = $this->createFormBuilder()
                ->add('mes', ChoiceType::class, [
                    'choices' => $nextMonths,
                ])
                ->getForm();

        $monthForm->handleRequest($request);

        if ($monthForm->isSubmitted() && $monthForm->isValid()) {
            $month = $monthForm->getData();
            return $this->redirectToRoute("app_eventos_type_get", ['month' => $month]);
        }
        
        return $this->render('Eventos/eventos_get/index.html.twig', [
                    'eventos' => $arrayEventos, 'mesActual' => $actual_month, 'formTipos' =>$typesForm, 'formMeses' => $monthForm
        ]);
    }

    /**
     * @Route("/eventos/search", name="app_eventos_type_get")
     * @return Response
     */
    public function getAllEventsByType(ManagerRegistry $doctrine, Request $request): Response {
        $types = $request->request->get('types');
        $eventos = $doctrine->getRepository(Evento::class)->findByTypeAndMonthEvents($types);
        return $this->redirectToRoute('app_eventos_get', [
                    'eventos' => $eventos, 'tipos' => $types
        ]);
    }

    /**
     * @Route("/eventos/{month}", name="app_eventos_month_get")
     * @return Response
     */
    public function getAllEventsByMonth(ManagerRegistry $doctrine, $month): Response {
        
        $eventos = $doctrine->getRepository(Evento::class)->findByMonthEvents($month);
        return $this->redirectToRoute('app_eventos_get', [
                    'eventos' => $eventos, 'mesEscogido' => $month
        ]);
    }

}
