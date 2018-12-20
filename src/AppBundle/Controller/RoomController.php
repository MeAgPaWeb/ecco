<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Room;
use AppBundle\Entity\DataLogger;
use AppBundle\Entity\Library;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Room controller.
 *
 * @Route("sala")
 */
class RoomController extends Controller
{
    /**
     * Lists all room entities.
     *
     * @Route("/{library}", name="room_index")
     * @Method("GET")
     */
    public function indexAction(Request $request, Library $library)
    {
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository('AppBundle:Room')->findByLibrary($library);

        return $this->render('room/index.html.twig', array(
            'rooms' => $rooms,
            'library' => $library
        ));
    }
    /**
     * get  all library entities.
     *
     * @Route("/api/listado", name="api_library_list")
     * @Method("GET")
     */
    public function apiListAction(Request $request)
    {
        if ($request->request->get('library')) {
          $em = $this->getDoctrine()->getManager();
          $library = $em->getRepository('AppBundle:Library')->findOneById($request->request->get('library'));
          $rooms = $em->getRepository('AppBundle:Room')->findByLibrary($library);
          $data=array();
          foreach ($rooms as $room) {
            $data[$room->getId()] = $room->getName();
          }
          $response = new Response();
          $response->setContent(json_encode($data));
          $response->headers->set('Content-Type', 'application/json');
        }else {
          $response = false;
        }
        return $response;
    }
    /**
     * Creates a new room entity.
     *
     * @Route("/{library}/crear", name="room_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Library $library)
    {
        $route=$request->request->get('route');
        $room = new Room();
        $form = $this->createForm('AppBundle\Form\RoomType', $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $room->setLibrary($library);
            $em->persist($room);
            $library->addRoom($room);
            $em->persist($library);
            $em->flush();
            $this->loadDataAction($request, $room);

            return $this->redirectToRoute($route, array('request' => $request, 'library' => $library->getId()));
        }

        return $this->render('room/new.html.twig', array(
            'room' => $room,
            'form' => $form->createView(),

        ));
    }

    /**
     * Finds and displays a room entity.
     *
     * @Route("/{id}", name="room_show")
     * @Method("GET")
     */
    public function showAction(Room $room)
    {
        $deleteForm = $this->createDeleteForm($room);

        return $this->render('room/show.html.twig', array(
            'room' => $room,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing room entity.
     *
     * @Route("/{id}/editar", name="room_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Room $room)
    {
        $deleteForm = $this->createDeleteForm($room);
        $editForm = $this->createForm('AppBundle\Form\RoomType', $room);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            //$this->loadDataAction($request, $room);

            return $this->redirectToRoute('library_edit', array('id' => $room->getLibrary()->getId()));
        }

        return $this->render('room/edit.html.twig', array(
            'room' => $room,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a room entity.
     *
     * @Route("/{id}", name="room_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Room $room)
    {
        $form = $this->createDeleteForm($room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($room);
            $em->flush();
        }

        return $this->redirectToRoute('room_index');
    }

    /**
     * Creates a form to delete a room entity.
     *
     * @param Room $room The room entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Room $room)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('room_delete', array('id' => $room->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Displays a form to edit an existing room entity.
     *
     * @Route("/{id}/cargar", name="room_load")
     * @Method({"GET", "POST"})
     */
    public function loadDataAction(Request $request, Room $room){
      $file = $request->files->get('upload');
      if($file){
        $name = $file->getFilename();
        $url =  $file->getRealPath();
        $em = $this->getDoctrine()->getManager();
        $isLoad= $em->getRepository('AppBundle:DataLogger')->getArrayLoads($room);
        $dataloggerLoads=array();
        foreach ($isLoad as $key => $unique) {
          $dataloggerLoads[]=$unique['uniqueAttr'];
        }

        if ($file->isValid()) {
          $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($url);
          $phpExcelObject->setActiveSheetIndex(0);
          $activesheet = $phpExcelObject->getActiveSheet()->toArray();
          $j=2;
          $nuevos=0;
          $repetidos=0;
          $batchSize = 30;
          while (isset($activesheet[$j][4])) {
              $date= \DateTime::createFromFormat( "d/m/y H:i:s", $activesheet[$j][1]." ".$activesheet[$j][2]);
              $data = new DataLogger($date,$room);
              if (!in_array($data->getUniqueAttr(), $dataloggerLoads) ) {
                $data->setNumber($activesheet[$j][0]);
                $data->setTemperature($activesheet[$j][3]);
                $data->setRh($activesheet[$j][4]);
                $data->setDewpt($activesheet[$j][5]);
                $em->persist($data);
                $room->addDataLogger($data);
                $em->persist($room);
                $nuevos++;
              }else {
                $repetidos++;
              }
              if (($j % $batchSize) === 0) {
                try {
                  $em->flush(); // Executes all updates.
                  $em = $this->getDoctrine()->getManager();
                }catch(\Doctrine\DBAL\DBALException $e) {
                  if (!$em->isOpen()) {
                    $em = $em->create(
                        $em->getConnection(),
                        $em->getConfiguration()
                    );
                  }
                }
              }
              $j++;
          }
          $em->flush();
          $data = array(
              'status' => true,
              'nuevos' => $nuevos,
              "repetidos" => $repetidos
           );
        }else {
          $data = array(
              'status' => false
           );
        }
      }else{
        $data = array(
            'status' => false
         );
      }
      if ($data['status']) {
        if ($this->calcDataAction($request, $room)) {
          $this->calcpersentilAction($request, $room);
          $this->calcLimitAction($request, $room);
        }
      }
      return new Response(json_encode($data));
    }

    /**
     * Displays a form to edit an existing room entity.
     *
     * @Route("/{id}/calcular", name="room_calc")
     * @Method({"GET", "POST"})
     */
    public function calcDataAction(Request $request, Room $room){
      $em = $this->getDoctrine()->getManager();
      $min= $em->getRepository('AppBundle:DataLogger')->getFirstDate($room);
      $max= $em->getRepository('AppBundle:DataLogger')->getLastDate($room);
      if (isset($min['date'])) {
        $dataloggers = $em->getRepository('AppBundle:DataLogger')->getDataLoggersValid($room, $min['date']->add(new \DateInterval('P15D')), $max['date']->sub(new \DateInterval('P15D')));
        foreach ($dataloggers as $datalogger) {
          if (!$datalogger->getEnabled()) {
            $dateMin = clone $datalogger->getDate();
            $dateMax = clone $datalogger->getDate();
            $dateMin->sub(new \DateInterval('P15D'));
            $dateMax->add(new \DateInterval('P15D'));
            $promedio = $em->getRepository('AppBundle:DataLogger')->getAvgHT($room, $dateMin, $dateMax);
            $datalogger->setMeanAvH($promedio[0]['meanAvH']);
            $datalogger->setMeanAvT($promedio[0]['meanAvT']);
            $datalogger->setEnabled(true);
            $datalogger->setRegMeanAvH($datalogger->getRh()-$promedio[0]['meanAvH']);
            $datalogger->setRegMeanAvT($datalogger->getTemperature()-$promedio[0]['meanAvT']);
            $em->persist($datalogger);
          }
        }
        $em->flush();
        return true;
      }else {
        return false;
      }
    }

    /**
     * Displays a form to edit an existing room entity.
     *
     * @Route("/{id}/calcularlimites", name="room_limit")
     * @Method({"GET", "POST"})
     */
    public function calcLimitAction(Request $request, Room $room){
      $em = $this->getDoctrine()->getManager();
      if ($room->getPerc7H()) {
        $registros= $em->getRepository('AppBundle:DataLogger')->findBy(array('room'=>$room, 'enabled'=>true));
        foreach ($registros as $reg) {
          $bottomH=$room->getPerc7H()+$reg->getMeanAvH();
          if ($bottomH > 70) {
            $bottomH = 69;
          }elseif ($bottomH < 45) {
            $bottomH = 45;
          }
          $topH=$room->getPerc93H()+$reg->getMeanAvH();
          if ($topH > 70) {
            $topH = 70;
          }
          $bottomT=$room->getPerc7T()+$reg->getMeanAvT();

          $topT=$room->getPerc93T()+$reg->getMeanAvT();
          if ($topT > 30) {
            $topT = 30;
          }
          $reg->setTopLimitT($topT);
          $reg->setBottonLimitT($bottomT);

          $reg->setTopLimitH($topH);
          $reg->setBottonLimitH($bottomH);

          $em->persist($reg);
        }
        $em->flush();
      }else {
        //necesario calcular los percentiles antes
        return false;
      }
      return true;

    }

    /**
     * Displays a form to edit an existing room entity.
     *
     * @Route("/{id}/percentil", name="room_persentil")
     * @Method({"GET", "POST"})
     */
    public function calcpersentilAction(Request $request, Room $room){
      $em = $this->getDoctrine()->getManager();
      $regMeanAvH= $em->getRepository('AppBundle:DataLogger')->getDataPersentil($room, "regMeanAvH");
      $regMeanAvT= $em->getRepository('AppBundle:DataLogger')->getDataPersentil($room, "regMeanAvT");
      $valuesH = array();
      $valuesT = array();
      foreach ($regMeanAvH as $datalogger) {
        $valuesH[]=$datalogger["regMeanAvH"];
      }
      foreach ($regMeanAvT as $datalogger) {
        $valuesT[]=$datalogger["regMeanAvT"];
      }
      $room->setPerc7H($this->getPercentile(7, $valuesH));
      $room->setPerc93H($this->getPercentile(93, $valuesH));
      $room->setPerc7T($this->getPercentile(7, $valuesT));
      $room->setPerc93T($this->getPercentile(93, $valuesT));
      $em->persist($room);
      $em->flush();
      return true;

    }

    private function getPercentile($percentile, $array) {
        sort($array);
        $index = ($percentile/100) * count($array);
        if (floor($index) == $index) {
             $result = ($array[$index-1] + $array[$index])/2;
        }
        else {
            $result = $array[floor($index)];
        }
        return $result;
    }

}
