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
use Symfony\Component\HttpFoundation\JsonResponse;

class EventoGetController extends AbstractController {

    #[Route('/eventos', name: 'app_eventos_get')]
    public function get(ManagerRegistry $doctrine, Request $request): Response {

        //devuele el mes actual en numero en formato string
        $actual_month = date('m');
        $arrayEventos = $doctrine->getRepository(Evento::class)->findByMonthEvents($actual_month);

        //checkboxes de tipos
        $choices = ['Evento deportivo' => 'deportivo', 'Evento cultural' => 'cultural', 'Tradiciones y fiestas locales' => 'tradiciones'];
        $typesForm = $this->createFormBuilder()
                ->add('tipo', ChoiceType::class, [
                    'mapped' => false,
                    'label' => false,
                    'choices' => $choices,
                    'multiple' => true,
                    'expanded' => true,
                    'choice_attr' => function ($val, $key, $index) {
                        return ['checked' => true];
                    }
                ])
                ->getForm();

        //select de meses
        $months = array('Enero' => '01', 'Febrero' => '02', 'Marzo' => '03', 'Abril' => '04', 'Mayo' => '05', 'Junio' => '06', 'Julio' => '07', 'Agosto' => '08', 'Septiembre' => '09', 'Octubre' => '10', 'Noviembre' => '11', 'Diciembre' => '12');

        $monthForm = $this->createFormBuilder()
                ->add('mes', ChoiceType::class, [
                    'choices' => $months,
                    'label' => false,
                    'data' => $actual_month
                ])
                ->getForm();

        setlocale(LC_ALL, 'es_ES', 'Spanish');
        $dateObj = DateTime::createFromFormat('!m', $actual_month);
        $monthName = strftime('%B', $dateObj->getTimestamp());

        return $this->renderForm('Eventos/evento_get/index.html.twig', [
                    'eventos' => $arrayEventos, 'mesActual' => $monthName, 'formTipos' => $typesForm, 'formMeses' => $monthForm
        ]);
    }

    /**
     * @Route("/eventos/search", name="app_eventos_type_get",options={"expose"=true}, methods={"POST"})
     * @return Response
     */
    public function getAllEventsByTypeAndMonth(ManagerRegistry $doctrine, Request $request): Response {

        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $types = $parametersAsArray['types'];
            $month = $parametersAsArray['month'];
            $eventos = $doctrine->getRepository(Evento::class)->findEventsByMonthAndType($month, $types);
            $html = $this->render( 'Eventos/evento_get/eventos_ajax.html.twig', ['eventos' => $eventos] )->getContent();
            
            setlocale(LC_ALL, 'es_ES', 'Spanish');
            $dateObj = DateTime::createFromFormat('!m', $month);
            $monthName = strftime('%B', $dateObj->getTimestamp());
            
            $response = array("code" => 200, "response" => $html, "mes" => $monthName);
            return new JsonResponse($response);
        }
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

}
