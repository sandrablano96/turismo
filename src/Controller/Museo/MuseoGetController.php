<?php
namespace App\Controller\Museo;
use App\Entity\Museo;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MuseoGetController extends AbstractController
{
    #[Route('/museos', name: 'app_museos_get')]
    public function getAllMuseos(ManagerRegistry $doctrine): Response
    {
        $arrayMuseos = $doctrine->getRepository(Museo::class)->findAll();
        $orderForm = $this->createFormBuilder()
                ->add('order', ChoiceType::class, [
                    'choices' => ['Ascendente' => 'asc', 'Descendente' => 'desc'],
                    'label' => false,
                    'data' => 'asc'
                ])
                ->getForm();
        return $this->renderForm('Museo/museo_get/index.html.twig', [
            'museos' => $arrayMuseos, 'formOrder' => $orderForm
        ]);
    }

    /**
     * @Route("/museos/search", name="app_museos_ordered_get",options={"expose"=true}, methods={"POST"})
     * @return Response
     */
    public function getAllMuseosOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $order = $parametersAsArray['orden'];
            if($order == 'asc'){
                $museos = $doctrine->getRepository(Museo::class)->findAllAsc();
            }else{
                $museos = $doctrine->getRepository(Museo::class)->findAllDesc();
            }
            
            $html = $this->render( 'Museo/museo_get/museos_ajax.html.twig', ['museos' => $museos] )->getContent();
            
            $response = array("code" => 200, "response" => $html);
            return new JsonResponse($response);
        }
    }
    
    /**
     * @Route("/museo/{uid}", name="app_museo_get")
     * @return Response
     */
    public function getMuseo(Museo $museo): Response
    {
        return $this->render('Museo/museo_get/museo.html.twig', [
            'museo' => $museo
        ]);
    }
    /**
     * @Route("admin/museo/{uid}", name="admin_museo_get")
     * @return Response
     */
    public function getMuseoData(Museo $museo): Response
    {
        return $this->render('admin/admin_museo.html.twig', [
            'museo' => $museo
        ]);
    }
    
    /**
     * @Route("admin/museos", name="admin_museos_get")
     */
    public function getAll(ManagerRegistry $doctrine): Response
    {
        $arrayMuseos = $doctrine->getRepository(Museo::class)->findAll();
        return $this->render('admin/admin_museos.html.twig', [
            'museos' => $arrayMuseos
        ]);
    }

}
