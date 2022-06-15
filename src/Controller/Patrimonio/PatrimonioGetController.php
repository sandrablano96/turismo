<?php

namespace App\Controller\Patrimonio;
use App\Entity\Patrimonio;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PatrimonioGetController extends AbstractController
{
    /**
     * @Route("/listado_patrimonio/{type}", name="app_patrimonio_tipo_get")
     * @return Response
     * 
     */
    public function getAllByType(ManagerRegistry $doctrine, Request $request, $type): Response
    {
        $typeId = $type === 'cultural' ? 2 : 1;
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findHeritageElements($typeId);
        $orderForm = $this->createFormBuilder()
                ->add('order', ChoiceType::class, [
                    'choices' => ['Ascendente' => 'asc', 'Descendente' => 'desc'],
                    'label' => false,
                    'data' => 'asc'
                ])
                ->getForm();
        return $this->renderForm('Patrimonio/patrimonio_get/index.html.twig', [
            'arrayPatrimonio' => $arrayPatrimonio, 'tipo' => $type, 'tipoId' => $typeId, 'formOrder' => $orderForm
        ]);
    }

    /**
     * @Route("/patrimonio/search", name="app_patrimonio_ordered_get", options={"expose"=true}, methods={"POST"})
     * @return Response
     * 
     */
    public function getAllHeritageOrdered(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $parametersAsArray = [];
            if ($content = $request->getContent()) {
                $parametersAsArray = json_decode($content, true);
            }
            $order = $parametersAsArray['orden'];
            $type = $parametersAsArray['type'];
            if($order == 'asc'){
                $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findAllAsc($type);
            }else{
                $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findAllDesc($type);
            }
            
            $html = $this->render( 'Patrimonio/patrimonio_get/patrimonio_ajax.html.twig', ['arrayPatrimonio' => $arrayPatrimonio] )->getContent();
            
            $response = array("code" => 200, "response" => $html);
            return new JsonResponse($response);
        }
    }

    /**
     * @Route("/patrimonio/ficha/{uid}", name="app_patrimonio_get")
     * @return Response
     * 
     */
    public function getPatrimonio(Patrimonio $patrimonio): Response
    {
        return $this->render('Patrimonio/patrimonio_get/patrimonio.html.twig', [
            'patrimonio' => $patrimonio
        ]);
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/patrimonio/{type}", name="admin_patrimonio_tipo_get")
     * @return Response
     * 
     */
    public function getAll(ManagerRegistry $doctrine, Request $request, $type): Response
    {
        $typeId = $type === 'cultural' ? 2 : 1;
        $arrayPatrimonio = $doctrine->getRepository(Patrimonio::class)->findHeritageElements($typeId);

        return $this->render('admin/admin_patrimonio.html.twig', [
            'patrimonio' => $arrayPatrimonio, 'tipo' => $type
        ]);
    }

    
}
