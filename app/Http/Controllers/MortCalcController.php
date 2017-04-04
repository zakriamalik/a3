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

      #access the request using this and apply laravel validation rules on inputs
      $this->validate($request,[
        'loan' => 'required|numeric|min:1|max:100000000',
        'interestRate' => 'required|numeric|min:1|max:25',
        'interestType' => 'required|present',
        'loanDuration' => 'required|not_in:0|min:1|max:30'
      ]);

      #get loan data from the form using request and format/calculate for display
      $loan=$request->input('loan', null);
      $interestRate=$request->input('interestRate', null);
      $interestRateMonthly = $interestRate/12;
      $interestType=$request->Input('interestType');
      $loanDuration=$request->input('loanDuration');
      $loanMonths=$loanDuration*12;

      #Logic: Formulae & Calculations used to determine mortage payments
      if($interestRate>0 && $loanDuration>0 && $loan>0) {
          $monthlyPayment = $loan*(($interestRate/100/12)*Pow((1+($interestRate/100/12)),$loanMonths))/(Pow((1+($interestRate/100/12)),$loanMonths)-1);
          #Reference: Learned and leveraged arithematic functions used at this website: http://php.net/manual/en/language.operators.arithmetic.php
          #Reference: Obatined Mortage Loan Payment formualae from this website: https://www.mtgprofessor.com/formulas.htm
          #Mortage Payment Formula: P = L[c(1 + c)^n]/[(1 + c)^n - 1]
      		#Where: L = Loan amount, c=monthly interest rate=Annual Interest Rate/12, P = Monthly payment, n = Month when the balance is paid in full, B = Remaining Balance
      	}
      else {
          $monthlyPayment=0;
        }

        # variable declaration and calculations for the display file
        $loanTbl = $loan;
        $monthlyPaymentTbl = $monthlyPayment;
        $interestTotal=0;
        $interestRateAvg=0;

        #amortization table array initalization
        $array_pmtNo=[];
        $array_loan=[];
        $array_interestRateMonthly=[];
        $array_monthlyPayment=[];
        $array_interest=[];
        $array_principal=[];
        $array_loanBalance=[];

        #loop to load up arrays for amortization table
        for($i = 1; $i<=$loanMonths; $i++)
        {
          #if interest type is fixed, keep interest rate fixed, or else randomly fluctuate between +-1% of entered annual interest rate
          if($interestType=='fixed'){
              $interestRateMonthlyTbl=$interestRateMonthly;
          }
          else {
              $interestRateMonthlyTbl=((rand($interestRate*100+100,$interestRate*100-100))/100/12);
          }
          #loading up arrays using loop variables
          $array_pmtNo[$i]=$i;
          $array_loan[$i]=$loanTbl;
          $array_interestRateMonthly[$i]=Round($interestRateMonthlyTbl,3);
          $array_monthlyPayment[$i]=Round($monthlyPaymentTbl,2);
          $array_interest[$i]=Round(($loanTbl*$interestRateMonthlyTbl/100),2);
          $array_principal[$i]=Round(($monthlyPaymentTbl-($loanTbl*$interestRateMonthlyTbl/100)),2);
          $array_loanBalance[$i]=$loanTbl=Round(($loanTbl-($monthlyPaymentTbl-($loanTbl*$interestRateMonthlyTbl/100))),2);
          $array_interestCumulative[$i]=$array_interest[$i]=Round(($loanTbl*$interestRateMonthlyTbl/100),2);
          #loan total lifetime cost calculations within loop
          $interestTotal=$interestTotal+Round(($loanTbl*$interestRateMonthlyTbl/100),2);
          $interestRateAvg=$interestRateAvg+$interestRateMonthlyTbl;
        }
          #loan total lifetime cost calculations after loop
          $interestRateAvg=$interestRateAvg/$loanMonths;
          $loanTotalCost=$interestTotal+$loan;
        #Reference 1: Formula for Monthly interest calculations: http://homeguides.sfgate.com/calculate-principal-interest-mortgage-2409.html
        #Reference 2: Learned and leveraged this site to understand syntax for number format function. http://php.net/manual/en/function.number-format.php
        #Reference 3: Learned how to access array in Laravel. http://stackoverflow.com/questions/36050266/laravel-accessing-array-data-in-view
        #Reference 4: Learned how to pass array from controller to view in Laravel. http://stackoverflow.com/questions/26251108/form-passing-array-from-controller-to-view-php-laravel


      return view('index')->with([
          'loanDisplay'=>number_format($loan, 2, '.', ','),
          'interestRateDisplay'=>$interestRate,
          'interestRateMonthlyDisplay'=>Round($interestRateMonthly,3),
          'interestTypeDisplay'=>$interestType,
          'loanDurationDisplay'=>$loanDuration,
          'loanMonths'=>$loanMonths,
          'monthlyPaymentDisplay'=>number_format($monthlyPayment, 2, '.', ','),
          'loanTbl'=>$loanTbl,
          'monthlyPaymentTbl'=>$monthlyPaymentTbl,
          'array_pmtNo'=>$array_pmtNo,
          'array_loan'=>$array_loan,
          'array_interestRateMonthly'=>$array_interestRateMonthly,
          'array_monthlyPayment'=>$array_monthlyPayment,
          'array_interest'=>$array_interest,
          'array_principal'=>$array_principal,
          'array_loanBalance'=>$array_loanBalance,
          'interestTotal'=>number_format($interestTotal, 2, '.', ','),
          'interestRateAvg'=>Round($interestRateAvg, 3),
          'loanTotalCost'=>number_format($loanTotalCost, 2, '.', ',')
        ]);
      #}

  }

  #public function amortTbl() {
  #    return view('index');
  #}


}
