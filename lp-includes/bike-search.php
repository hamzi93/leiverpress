<?php


add_shortcode('search-bike', 'show_search_bike');

add_action('rest_api_init', 'create_rest_endpoint');

function show_search_bike()
{
  ob_start();
  include MY_PLUGIN_PATH . 'lp-templates/bike-search.php';
  return ob_get_clean();
  //Mit ob_start und ob_get_clean würde die theme reihnfolge gehalten sonst wird es ganz oben im theme angezeigt
  //ohne ob_start müsste man ein return machen und kein include benutzen!

  //Hier ladet nun unser HTML
  /*return '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <div class="container border bg-primary-subtle rounded-2">
    <form class="row mb-2 mt-2 justify-content-center">
      <div class="col-md-3">
          <div class="mb-1 mt-1">
              <input type="date" class="form-control" name="abholdatum" placeholder="Hier kommt Text">
          </div>
      </div>
      <div class="col-md-3">
          <div class="mb-1 mt-1">
              <input type="date" class="form-control" name="rueckgabedatum" placeholder="Hier kommt Text">
          </div>
      </div>
      <div class="col-md-3 mb-1 mt-1">
          <select class="form-select" name="marke">
              <option>Alle Marken</option>
              <option>BMW</option>
              <option>KTM</option>
              <option>Kawasaki</option>
              <option>Ducati</option>
          </select>
      </div>
      <div class="col-md-auto mt-1">
          <button class="btn btn-primary" type="submit">Suchen</button>
      </div>
    </form>
  </div>
  <img src="\images\bikes\BMW_F900_XR.jpg" alt="">'; */
}



function create_rest_endpoint()
{
  register_rest_route('v1/bike-search', 'submit', array(
    'methods' => 'POST',
    'callback' => 'handle_enquiry'
  ));
}

function handle_enquiry()
{
  global $wpdb;
  $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}options WHERE option_id = 1", OBJECT);
  return $results;
}