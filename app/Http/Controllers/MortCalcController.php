<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

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
  public function process (Request $request) {
      # ======== Temporary code to explore $request ==========
      #dd($request);
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
      #$interestRate = $request->input('interestRate', null);
      #{{ dd(get_defined_vars()) }};
      #$errors=0;
      #if($_GET) {


      $this->validate($request,[
        'loan' => 'required|numeric|min:1|max:100000000',
        'interestRate' => 'required|numeric|min:1|max:25',
        'interestType' => 'required|present',
        'loanDuration' => 'required|not_in:0|min:1|max:30'
      ]);
      #eturn redirect('/');
      #$old = session()->getOldInput();

      #$request->flash();
      #return redirect()->back();

      # return redirect()->route('process')->withInput();
      #return redirect('/');
      #return redirect()->back();
      #return redirect(\URL::previous());
      #if($this->fails())
      #return redirect('/')->withErrors($this)->withInput(old('loan'));
      #              ->withErrors($errors, $this->errorBag());
      #}


      #if(count($errors)>0) {
      #  return redirect('/');
      #}
      #else {

      #dump($request->old('interestType'));

      #get loan data from the form using request and format/calculate for display
      $loan=$request->input('loan', null);
      $interestRate=Round($request->input('interestRate', null),3);
      $interestRateMonthly = Round($interestRate/12,3);
      $interestType=$request->Input('interestType');
      $loanDuration=$request->input('loanDuration');
      $loanMonths=$loanDuration*12;

      #Logic: Formulae & Calculations used to determine mortage payments
      if($interestRate>0 && $loanDuration>0 && $loan>0) {
      		#$interestRateMonthly = ($interestRate/100)/12;
      		#$timePeriodMonths = $timePeriodYears*12;
      		#$monthlyPayment = $loan*((($interestRate/100)/12)*(1 + (($interestRate/100)/12))**$loanMonths)/(((1 + (($interestRate/100)/12))**$loanMonths) - 1);
          $monthlyPayment = $loan*(($interestRate/100/12)*Pow((1+($interestRate/100/12)),$loanMonths))/(Pow((1+($interestRate/100/12)),$loanMonths)-1);
          $monthlyPayment = number_format($monthlyPayment, 2, '.', ',');
          $loan=number_format($loan, 2, '.', ',');
          #Reference: Learned and leveraged arithematic functions used at this website: http://php.net/manual/en/language.operators.arithmetic.php
          #Reference: Obatined Mortage Loan Payment formualae from this website: https://www.mtgprofessor.com/formulas.htm
          #Mortage Payment Formula: P = L[c(1 + c)^n]/[(1 + c)^n - 1]
      		#Where: L = Loan amount, c=monthly interest rate=Annual Interest Rate/12, P = Monthly payment, n = Month when the balance is paid in full, B = Remaining Balance
      	}
      else {
          $monthlyPayment=0;
        }

      return view('index')->with([
          'loanDisplay'=>$loan,
          'interestRateDisplay'=>$interestRate,
          'interestRateMonthlyDisplay'=>$interestRateMonthly,
          'interestTypeDisplay'=>$interestType,
          'loanDurationDisplay'=>$loanDuration,
          'loanMonths'=>$loanMonths,
          'monthlyPaymentDisplay'=>$monthlyPayment
        ]);
      #}

  }

}
