<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MortCalcController extends Controller
{
  //Get Books Method
  public function index() {
      return view('index');
  }

//Get invoke method
  #public function __invoke() {
  #    return view('index');
  #}

  /**
  * GET
  * /search
  */
  public function search(Request $request) {
      # ======== Temporary code to explore $request ==========

      # See all the properties and methods available in the $request object
      #dump($request);

      # See just the form data from the $request object
      #dump($request->all());

      # See just the form data for a specific input, in this case a text input
      #dump($request->input('loan'));

      # See what the form data looks like for a checkbox
      #dump($request->input('interestRate'));


      # Boolean to see if the request contains data for a particular field
      #dump($request->has('searchTerm')) # Should be true
      #dump($request->has('publishedYear')) # There's no publishedYear input, so this should be false

      # You can get more information about a request than just the data of the form, for example...
      #dump($request->fullUrl());
      #dump($request->method());
      #dump($request->isMethod('post'));

      # ======== End exploration of $request ==========

      # Return the view with some placeholder data we'll flesh out in a later step

      $loan = $request->input('loan', null);
      $interestRate = $request->input('interestRate', null);

      return view('index')->with([
          'loan'=> $loan]);
  }

}
