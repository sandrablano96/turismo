<?php

namespace App\Controller\Eventos;

use App\Entity\Evento;
use DateTime;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EventoGetController extends AbstractController {

    #[Route('/eventos', name: 'app_eventos_get')]
    public function get(ManagerRegistry $doctrine, Request $request): Response {

        
        $actual_month = date('m');
        $arrayEventos = $doctrine->getRepository(Evento::class)->findByMonthEvents($actual_month);
        
        //checkboxes de tipos
        $choices = ['Evento deportivo' => 'deportivo', 'Evento cultural' => 'cultural', 'Tradiciones y fiestas locales' => 'tradicion'];
        $typesForm = $this->createFormBuilder()
                ->add('tipo', ChoiceType::class, [
                    'label' => false,
                    'choices' => $choices,
                    'multiple' => true,
                    'expanded' => true,
                    'data' => array_keys()
                 ])
                ->getForm();

        $typesForm->handleRequest($request);

        if ($typesForm->isSubmitted() && $typesForm->isValid()) {
            $types = $typesForm->getData();
            //redireccionamos al metodo que recupera los datos de la bd y cambiamos la url
            return $this->redirectToRoute("app_eventos_type_get", ['types' => $types]);
        }
        
        //select de meses
        $months = array('Enero' => 1, 'Febrero' => 2, 'Marzo' => 3, 'Abril' => 4, 'Mayo' => 5, 'Junio' => 6, 'Julio' => 7, 'Agosto' => 8, 'Septiembre' => 9, 'Octubre' => 10, 'Noviembre' => 11, 'Diciembre' => 12);

        $monthForm = $this->createFormBuilder()
                ->add('mes', ChoiceType::class, [
                    'choices' => $months,
                    'label' => false
                ])
                ->getForm();

        $monthForm->handleRequest($request);

        if ($monthForm->isSubmitted() && $monthForm->isValid()) {
            $month = $monthForm->getData();
            return $this->redirectToRoute("app_eventos_month_get", ['month' => $month]);
        }
        setlocale(LC_ALL, 'es_ES', 'Spanish');
        $dateObj   = DateTime::createFromFormat('!m', $actual_month);
        $monthName = strftime('%B', $dateObj->getTimestamp());

        return $this->renderForm('Eventos/evento_get/index.html.twig', [
                    'eventos' => $arrayEventos, 'mesActual' => $monthName, 'formTipos' =>$typesForm, 'formMeses' => $monthForm
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
     * @Route("/admin/eventos", name="admin_eventos_get")
     * @return Response
     */
    public function getAllEvents(ManagerRegistry $doctrine, Request $request): Response {
        $eventos = $doctrine->getRepository(Evento::class)->findAll();
        return $this->render('admin/admin_eventos.html.twig', [
                    'eventos' => $eventos
        ]);
    }

    /**
     * @Route("/eventos/{month}", name="app_eventos_month_get")
     * @return Response
     */
    public function getAllEventsByMonth(ManagerRegistry $doctrine, $month): Response {
        
        $month= DateTime::createFromFormat('m', $month);
        $eventos = $doctrine->getRepository(Evento::class)->findByMonthEvents($month);
        return $this->redirectToRoute('app_eventos_get', [
                    'eventos' => $eventos, 'mesEscogido' => $monthName
        ]);
    }

}
