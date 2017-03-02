<?php

/**
 * @file
 * Contains \Drupal\explore\Controller\ExploreAPIController.
 */

namespace Drupal\explore\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Controller routines for test_api routes.
 */
class ExploreAPIController extends ControllerBase {

  /**
   * Callback for `my-api/get.json` API method.
   */
  public function get_example( Request $request ) {

    $response['data'] = 'Some test data to return';
    $response['method'] = 'GET';

    return new JsonResponse( $response );
  }

  /**
   * Callback for `my-api/put.json` API method.
   */
  public function put_example( Request $request ) {

    $response['data'] = 'Some test data to return';
    $response['method'] = 'PUT';

    return new JsonResponse( $response );
  }

  /**
   * Callback for `my-api/post.json` API method.
   */
  public function post_example( Request $request ) {

    // This condition checks the `Content-type` and makes sure to 
    // decode JSON string from the request body into array.
    if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'applicatjsonion/json' ) ) {
      $data = json_decode( $request->getContent(), TRUE );
      $request->request->replace( is_array( $data ) ? $data : [] );
    }

    \Drupal::logger('explore_module')->notice(print_r($data, TRUE));
    $response['data'] = $data . 'dbsad a';
    $response['method'] = 'POST';

    return new JsonResponse( $response );
  }

  /**
   * Callback for `my-api/delete.json` API method.
   */
  public function delete_example( Request $request ) {

    $response['data'] = 'Some test data to return';
    $response['method'] = 'DELETE';

    return new JsonResponse( $response );
  }

}

