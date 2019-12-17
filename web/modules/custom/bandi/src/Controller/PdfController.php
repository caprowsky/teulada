<?php

namespace Drupal\bandi\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\node\Controller\NodeViewController;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defines a controller to render a single node.
 */
class PdfController extends NodeViewController {

  public function view(EntityInterface $node, $view_mode = 'pdf', $langcode = NULL) {
    $build = [
      '#theme' => 'bandipdf',
      '#title' => parent::title($node),
      '#content' => parent::view($node, $view_mode, $langcode),
      '#cache' => ['max-age' => 0,],
    ];

    $output = render($build);

    $schema = \Drupal::request()->getSchemeAndHttpHost();
    $ras = '<img src="' . $schema . '/themes/si8/images/pdf/ras.png" />';
    $eu = '<img src="' . $schema . '/themes/si8/images/pdf/ue.png" />';

    // If you want the test HTML output, uncomment this:
    //return new Response($output, 200, []);

    $config = [
      'tempDir' => DRUPAL_ROOT . '/sites/default/files/entity_pdf',
    ];
    $mpdf = new \Mpdf\Mpdf($config);
    $mpdf->SetBasePath(\Drupal::request()->getSchemeAndHttpHost());
    $mpdf->SetTitle($this->title($node));
    $mpdf->SetTopMargin('30');
    $mpdf->SetHTMLHeader('<table style="margin-bottom: 20px;" width="100%"><tr><td align="left" width="50%">' . $ras . '</td><td align="right" width="50%">' . $eu . '</td></tr></table>');
    $mpdf->SetHTMLFooter('<div class="footer">www.sardegnaimpresa.eu</div>');

    $mpdf->WriteHTML($output);
    $content = $mpdf->Output($this->title($node) . '.pdf', Destination::DOWNLOAD);

    $headers = [
      'Content-Type: application/pdf',
      'Content-disposition: inline; filename="' . $this->title($node) . '.pdf"',
    ];

    return new Response($content, 200, $headers);
  }

  /**
   * @inheritdoc
   */
  public function title(EntityInterface $node) {
    return parent::title($node);
  }
}
