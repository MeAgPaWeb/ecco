<?php
namespace AppBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/*
 * Manejador de envios de emails
 */
class UploadDataHandler extends Controller{

    protected $container;
    protected $param;

    public function __construct($container) {
        $this->container = $container;
        $this->param = array();
    }

    public function getParam($indice=null){
      if ($indice) {
        if (isset($this->param[$indice])) {
          return $this->param[$indice];
        }else {
          return false;
        }
      }else {
        return false;
      }
    }
    public function addParam($key, $value){
      $this->param[$key]=$value;
      return $this->param;
    }

    public function loadFile(Request $request, array $args = array()) {
        $this->setParams($args);

        $file=$request->files->get($this->param['input_name']);
        if ($file && $file->isValid()) {
          $pathFile = $file->getRealPath();
          $this->loadData($pathFile);
          $this->addFlash('success', "se cargo correctamente el archivo:  ".$this->getParam('input_name'));
          return true;
        }else {
          $this->addFlash('danger', "no se recibio archivo en ".$this->getParam('input_name')." o  no es valido");
          return false;
        }
    }

    private function setParams($args){
      // $controller = array(
      //   'input_name'=>'file',
      //   'type' => "controller",
      //   '_controller' => "App\Controller\OtherController",
      //   '_action' => "index",
      // );
      // $entity = array(
      //   'input_name'=>'file',
      //   'type' => "entity",
      //   '_name' => "\AppBundle\Entity\OneEntity",
      // );
      $this->param=array();
      if(isset($args['type'])){
          switch ($args['type']) {
            case 'controller':
              $this->addParam('_call', "callController");
              if(!isset($args['_controller']) && !isset($args['_action'])){
                echo 'necesita pasar los atributos:(importante, el controlador debe retornar una entidad a persistir o un array de entidades)';
                return $args['_controller'];
              }else {
                $this->addParam('_controller', $args['_controller']);
                $this->addParam('_action', $args['_action']);
              }
              break;
            case 'service':
              $this->addParam('_call', "callService");
              // code...
              break;
            case 'entity':
              $this->addParam('_call', "callConstruct");
              if(!isset($args['_name'])){
                return 'error entity name';
              }else {
                $this->addParam('_name', $args['_name']);
              }
              break;
            default:
              break;
          }
      }
      //inyect EntityManager
      if(isset($args['em'])){
          if ($args['em']) {
            $this->addParam('em', $this->getDoctrine()->getManager());
          }
      }
      if(isset($args['input_name'])){
          $this->addParam('input_name', $args['input_name']);
      }else{
        $this->addParam('input_name', "file");
      }

      return $this->getParam();

    }


    private function loadData($file){
      $readerCsv  = $this->get('phpoffice.spreadsheet')->createReader('Csv');
      $readerCsv->setDelimiter(",");
      $readerCsv->setSheetIndex(0);
      $file = $readerCsv->load($file);
      $data  = $file->getActiveSheet()->toArray();
      $datos  = array_slice($data,1);
      $em = $this->getDoctrine()->getManager();
      $batchSize = 30;

      foreach ($datos as $key => $data) {

        $entity = $this->proccessRow($data);
        if (is_array($entity)) {
          foreach ($entity as $en) {
            $em->persist($en);
          }
        }else {
          $em->persist($entity);
        }
        if (($key % $batchSize) === 0) {
            // $em->flush(); // Executes all updates.
        }
      }

      // $em->flush();
      return true;
    }


    private function proccessRow($data){
      $function = $this->getParam('_call');
      return $this->$function($data);
    }


    private function callController($data){
        $response = $this->forward($this->getParam('_controller')."::".$this->getParam('_action'), $data);
        return $response;
    }

    private function callConstruct($data){
        $entityClass = $this->getParam('_name');
        if ($this->getParam('em')) {
          $entity = new $entityClass($data, $this->getParam('em'));
        }else {
          $entity = new $entityClass($data);
        }
        return $entity;
    }

}
