<?php

namespace Drupal\sportelli;

use SoapClient;
use SoapVar;
use SoapHeader;
use stdClass;

class getSportelliSuapByBacinoIdRequest {
  public $bacino-struttura-id; // integer
}

class getSportelliSuapByBacinoIdResponse {
  public $sportelli-suap-list; // sportelli-suap-list
}

class sportelli-suap-list {
  public $sportello-suap; // sportello-suap
}

class sportello-suap {
  public $struttura-id; // integer
  public $struttura-orig-id; // integer
  public $struttura-des; // NCName
  public $struttura-comune-id; // integer
}

class getStrutturaViewByIdRequest {
  public $struttura-id; // integer
}

class getStrutturaViewByIdResponse {
  public $struttura-view; // struttura-view
}

class struttura-view {
  public $struttura-comune-des; // NCName
  public $struttura-fax; // NCName
  public $codice-amministrazione; // NCName
  public $meta-ente-des; // NCName
  public $struttura-indirizzo; // NCName
  public $struttura-suap-comune-id; // integer
  public $struttura-tipo-des; // NCName
  public $struttura-localizzazione-comune-id; // integer
  public $struttura-pubbl-web; // boolean
  public $identificatico-suap; // NCName
  public $prov-des; // NCName
  public $prov-id; // integer
  public $struttura-cap; // NCName
  public $meta-ufficio-des; // NCName
  public $struttura-telefono; // NCName
  public $struttura-email; // NCName
  public $struttura-status-des; // NCName
  public $struttura-orari; // NCName
  public $comune-des; // NCName
  public $struttura-sitoweb; // NCName
  public $codice-aoo; // NCName
  public $struttura-comune-id; // integer
  public $struttura-des; // NCName
  public $struttura-prov-id; // integer
  public $struttura-orig-id; // integer
  public $struttura-abbr; // NCName
  public $struttura-tipo-id; // integer
  public $struttura-status-id; // integer
  public $meta-ufficio-id; // integer
  public $struttura-id; // integer
  public $meta-ente-id; // integer
}

class getSportelliSuapByProvinciaIdRequest {
  public $provincia-id; // integer
}

class getSportelliSuapByProvinciaIdResponse {
  public $anagrafica-sportelli-suap-list; // anagrafica-sportelli-suap-list
}

class anagrafica-sportelli-suap-list {
  public $anagrafica-sportello-suap; // anagrafica-sportello-suap
}

class anagrafica-sportello-suap {
  public $struttura-id; // integer
  public $struttura-abbr; // NCName
  public $struttura-des; // NCName
  public $struttura-tipo-id; // integer
  public $struttura-indirizzo; // NCName
  public $struttura-cap; // NCName
  public $struttura-comune-id; // integer
  public $struttura-comune-des; // NCName
  public $struttura-prov-id; // integer
  public $struttura-telefono; // NCName
  public $struttura-fax; // NCName
  public $struttura-email; // NCName
  public $struttura-sito-web; // NCName
  public $struttura-orari; // boolean
  public $struttura-pubbl-web; // NCName
  public $identificativo-suap; // NCName
  public $codice-amministrazione; // NCName
  public $codice-aoo; // NCName
  public $file-id; // integer
  public $filename; // NCName
  public $sys-filename; // NCName
  public $filetype; // NCName
  public $allegato-type; // integer
}


/**
 * struttureportService class
 * 
 *  
 * 
 * @author    {author}
 * @copyright {copyright}
 * @package   {package}
 */
class struttureportService extends SoapClient {

  private static $classmap = array(
                                    'getSportelliSuapByBacinoIdRequest' => 'getSportelliSuapByBacinoIdRequest',
                                    'getSportelliSuapByBacinoIdResponse' => 'getSportelliSuapByBacinoIdResponse',
                                    'sportelli-suap-list' => 'sportelli-suap-list',
                                    'sportello-suap' => 'sportello-suap',
                                    'getStrutturaViewByIdRequest' => 'getStrutturaViewByIdRequest',
                                    'getStrutturaViewByIdResponse' => 'getStrutturaViewByIdResponse',
                                    'struttura-view' => 'struttura-view',
                                    'getSportelliSuapByProvinciaIdRequest' => 'getSportelliSuapByProvinciaIdRequest',
                                    'getSportelliSuapByProvinciaIdResponse' => 'getSportelliSuapByProvinciaIdResponse',
                                    'anagrafica-sportelli-suap-list' => 'anagrafica-sportelli-suap-list',
                                    'anagrafica-sportello-suap' => 'anagrafica-sportello-suap',
                                   );

  public function struttureportService($wsdl = "http://172.30.253.137:8085/suapcalabria//ws/strutt/strutturews.wsdl", $options = array()) {
    foreach(self::$classmap as $key => $value) {
      if(!isset($options['classmap'][$key])) {
        $options['classmap'][$key] = $value;
      }
    }
    parent::__construct($wsdl, $options);
  }

  /**
   *  
   *
   * @param getStrutturaViewByIdRequest $getStrutturaViewByIdRequest
   * @return getStrutturaViewByIdResponse
   */
  public function getStrutturaViewById(getStrutturaViewByIdRequest $getStrutturaViewByIdRequest) {
    return $this->__soapCall('getStrutturaViewById', array($getStrutturaViewByIdRequest),       array(
            'uri' => 'http://www.calabriasuap.it/schema',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param getSportelliSuapByProvinciaIdRequest $getSportelliSuapByProvinciaIdRequest
   * @return getSportelliSuapByProvinciaIdResponse
   */
  public function getSportelliSuapByProvinciaId(getSportelliSuapByProvinciaIdRequest $getSportelliSuapByProvinciaIdRequest) {
    return $this->__soapCall('getSportelliSuapByProvinciaId', array($getSportelliSuapByProvinciaIdRequest),       array(
            'uri' => 'http://www.calabriasuap.it/schema',
            'soapaction' => ''
           )
      );
  }

  /**
   *  
   *
   * @param getSportelliSuapByBacinoIdRequest $getSportelliSuapByBacinoIdRequest
   * @return getSportelliSuapByBacinoIdResponse
   */
  public function getSportelliSuapByBacinoId(getSportelliSuapByBacinoIdRequest $getSportelliSuapByBacinoIdRequest) {
    return $this->__soapCall('getSportelliSuapByBacinoId', array($getSportelliSuapByBacinoIdRequest),       array(
            'uri' => 'http://www.calabriasuap.it/schema',
            'soapaction' => ''
           )
      );
  }

}

?>
