<?php

namespace Drupal\si8_utils\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controlla redirect per 404.
 */
class ContenutiRedirect implements EventSubscriberInterface {

  public $args;
  public $event;
  public $main_arg;
  public $status;

  /**
   * Redirect per nodi e termini mancanti nella migrazione
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
   *   The event to process.
   *
   * @return object
   */
  public function on404(GetResponseForExceptionEvent $event) {
    //\Drupal::logger('si8_utils')->notice('Entro nel 404');
    
    $current_path = $event->getRequest()->getRequestUri();
    $this->args = explode('/', $current_path);
    $this->main_arg = $this->args[1];
    $this->status = '301';
    $query = \Drupal::request()->query;

    // Check notizie ed eventi
    $paths = ['notizie', 'eventi'];
    if (isset($this->args) && isset($this->args[2]) && in_array($this->args[2], $paths)) {
      $new_url = '/' . $this->args[1] . '/news/' . $this->args[3];
      $this->setRedirect($event, $new_url);
      return $this->event;
    }
    
    if (isset($this->args[2])) {
      if (substr($this->args[2], 0, 13) == 'aggiornamento') {
        $new_url = '/' . $this->args[1] . '/news/' . $this->args[2];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'albero-di-navigazione') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'approfondimenti') {
        $new_url = '/' . $this->args[1] . '/approfondimenti';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'area-riservata') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'articoli') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'calendar-node-field-data-evento') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if (substr($this->args[2], 0, 7) == 'eventi?' && !isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'file') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'glossario' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1] . '/glossario';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'news' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1] . '/news';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'node' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'print' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'printpdf' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if (substr($this->args[2], 0, 18) == 'risultati_ricerca?') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'servizi' && isset($this->args[3]) && $this->args[3] == 'finanzia-impresa') {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'servizi' && isset($this->args[3]) && $this->args[3] == 'investire-sardegna') {
        $new_url = '/' . $this->args[1] . '/investire-sardegna';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'strutture-territoriali' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1] . '/sportello-unico';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
  
      if ($this->args[2] == 'suap' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1] . '/sportello-unico';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'tabelle' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1] . '/sportello-unico';
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'tags' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
  
      if ($this->args[2] == 'taxonomy' && isset($this->args[3])) {
        $new_url = '/' . $this->args[1];
        $this->setRedirect($event, $new_url);
        return $this->event;
      }
    }

    return $event;
  }

  /**
   * Set redirect
   * @param \Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
   * @return mixed
   */
  private function setRedirect($event, $new_url) {
    $event->setResponse(new RedirectResponse($new_url, $this->status));
    return;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::EXCEPTION][] = ['on404', 50];
    return $events;
  }

}
