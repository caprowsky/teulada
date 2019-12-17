<?php

namespace Drupal\sportelli\Controller;

use Drupal\sportelli;
use SoapClient;
use SoapVar;
use SoapHeader;
use SoapFault;
use stdClass;


class MainSportelli {

  public function __construct() {
    $this->ws_username = 'ws_user';
    $this->ws_namespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    $this->ws_password = '12345678';
    $this->ws_metaWsPath = 'http://intra.sardegnasuap.it/ws/meta/metaws.wsdl';
    $this->ws_serviceWsPath = '';
    $this->codice_regione = '20';
    $this->client = $this->soapConnMetaWs();
  }

  /**
   * Render team page
   * @return array
   */
  public function main()  {

    $form = \Drupal::formBuilder()->getForm('Drupal\sportelli\Form\RicercaSportelli');
    $output['form'] = $form;

    return array(
      '#title' => t('Where is it'),
      '#theme' => 'sportelli',
      '#output' => $output,
    );
  }

  /**
   * Creates the connection
   * return conn client
   */
  function soapConnMetaWs() {
    $token = new stdClass;
    $token->Username = new SOAPVar($this->ws_username, XSD_STRING, null, null, null, $this->ws_namespace);
    $token->Password = new SOAPVar(md5($this->ws_password), XSD_STRING, null, null, null, $this->ws_namespace);
    $wsec = new stdClass;
    $wsec->UsernameToken = new SoapVar($token, SOAP_ENC_OBJECT, null, null, null, $this->ws_namespace);
    $headers = new SOAPHeader($this->ws_namespace, 'Security', $wsec, true);
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
    $token->Username = new SOAPVar($this->ws_username, XSD_STRING, null, null, null, $this->ws_namespace);
    $token->Password = new SOAPVar(md5($this->ws_password), XSD_STRING, null, null, null, $this->ws_namespace);
    $wsec = new stdClass;
    $wsec->UsernameToken = new SoapVar($token, SOAP_ENC_OBJECT, null, null, null, $this->ws_namespace);
    $headers = new SOAPHeader($this->ws_namespace, 'Security', $wsec, true);
    $client = new SoapClient($this->ws_metaWsPath);
    $client->__setSoapHeaders($headers);
    return $client;
  }

}



