<?php

namespace Drupal\sportelli;

use SoapClient;
use SoapVar;
use SoapHeader;
use SoapFault;
use stdClass;

class SportelliUtils {

  function meta() {
    $this->ws_username = 'ws_user';
    $this->ws_namespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    $this->ws_password = '12345678';
    $this->ws_metaWsPath = 'http://intra.sardegnasuap.it/ws/meta/metaws.wsdl';
    $this->ws_serviceWsPath = '';
    $this->codice_regione = '20';
    return $this->soapConnMetaWs();
  }

  function strutture() {
    // _constru http://suap.staging.sardegnait.it/ws/strutt/strutturews.wsdl
    $this->ws_username = 'ws_user';
    $this->ws_namespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    $this->ws_password = '12345678';
    $this->ws_metaWsPath = 'http://intra.sardegnasuap.it/ws/strutt/strutturews.wsdl';
    $this->ws_serviceWsPath = '';
    $this->codice_regione = '20';
    return  $this->soapConnServiceWs();
  }

  function soapConnMetaWs() {
    $token = new stdClass;
    $token->Username = new SOAPVar($this->ws_username, XSD_STRING, NULL, NULL, NULL, $this->ws_namespace);
    $token->Password = new SOAPVar(md5($this->ws_password), XSD_STRING, NULL, NULL, NULL, $this->ws_namespace);
    $wsec = new stdClass;
    $wsec->UsernameToken = new SoapVar($token, SOAP_ENC_OBJECT, NULL, NULL, NULL, $this->ws_namespace);
    $headers = new SOAPHeader($this->ws_namespace, 'Security', $wsec, TRUE);
    $client = new SoapClient($this->ws_metaWsPath);
    $client->__setSoapHeaders($headers);
    return $client;
  }

  /**
   * Creates the connection
   * return conn client
   */
  function soapConnServiceWs() {
    $token = new stdClass;
    $token->Username = new SOAPVar($this->ws_username, XSD_STRING, NULL, NULL, NULL, $this->ws_namespace);
    $token->Password = new SOAPVar(md5($this->ws_password), XSD_STRING, NULL, NULL, NULL, $this->ws_namespace);
    $wsec = new stdClass;
    $wsec->UsernameToken = new SoapVar($token, SOAP_ENC_OBJECT, NULL, NULL, NULL, $this->ws_namespace);
    $headers = new SOAPHeader($this->ws_namespace, 'Security', $wsec, TRUE);
    $client = new SoapClient($this->ws_metaWsPath);
    $client->__setSoapHeaders($headers);
    return $client;
  }

  // Prende tutti i comuni
  function getComuni() {
    $client = $this->meta();

    $provinces = $this->getProvince();
    $comuni = [];

    foreach ($provinces as $province) {
      try {
        $params = ['getComuneByProvinciaIdRequest ' => ['provincia-id' => $province['prov-id']]];
        $resRaw = $client->__soapCall('getComuneByProvinciaId', $params);
      } catch (SoapFault $ex) {
        print($ex);
      }

      foreach ($resRaw->{'comune-list'}->{'comune'} as $item) {
        $comune = (array) $item;
        $comuni[$comune['comune-id'] . '_' . $comune['prov-id']] = $comune['comune-des'];
      }
    }

    asort($comuni);

    return $comuni;

  }

  function getProvince() {
    $meta = $this->meta();

    try {
      $params = ['getProvinciaByRegioneCodRequest' => ['regione-cod' => $this->codice_regione]];
      $resRaw = $meta->__soapCall('getProvinciaByRegioneCod', $params);
    } catch (SoapFault $ex) {
      print($ex);
    }

    $province = [];

    foreach ($resRaw->{'provincia-list'}->{'provincia'} as $item) {
      $provincia = (array) $item;
      $province[] = $provincia;
    }

    return $province;
  }

  function getSportelli($comune_id, $provincia_id) {
    $strutture = $this->strutture();
    /**
     * Get the sportelli suap list by provincia code
     */
    try {
      $params = ['getSportelliSuapByProvinciaIdRequest' => ['provincia-id' => $provincia_id]];
      $resRaw = $strutture->__soapCall('getSportelliSuapByProvinciaId', $params);
    } catch (SoapFault $ex) {
      return ($ex);
    }

    $sportelli = [];

    if (isset($resRaw->{'anagrafica-sportelli-suap-list'})) {
      $result = $resRaw->{'anagrafica-sportelli-suap-list'}->{'anagrafica-sportello-suap'};
      foreach ($result as $sportello) {
        if ($sportello->{'struttura-comune-id'} == $comune_id) {
          $sportelli[] = $sportello;
        }
      }
    }

    return $this->themeSportelli($sportelli);

  }

  function themeSportelli($sportelli) {
    $html = '<div class="elenco-sportelli">';

    if (empty($sportelli)) {
      $html .= 'Non sono presenti sportelli SUAP nel comune selezionato.';
    } else {
      foreach ($sportelli as $sportello) {
        $html .= '<div class="sportello">';
        $html .= '<div class="dato desc">' . $sportello->{'struttura-des'} . '</div>';
        $html .= '<div class="dato">Identificativo SUAP: ' . $sportello->{'identificativo-suap'} . '</div>';
        $html .= '<div class="dato"><strong>Indirizzo:</strong><br>' . $sportello->{'struttura-indirizzo'} . '<br> ' . $sportello->{'struttura-cap'} . ' ' . $sportello->{'struttura-comune-des'} . '</div>';
        $html .= '<div class="dato"><strong>Contatti:</strong></div>';
        $html .= '<div class="dato">Tel. ' . $sportello->{'struttura-telefono'} . ' - Fax. ' . $sportello->{'struttura-fax'} . '</div>';
        $html .= '<div class="dato">Email: ' . $sportello->{'struttura-email'} . '</div>';
        $html .= '</div>';
      }
    }

    $html .= '</div>';
    return $html;
  }

}