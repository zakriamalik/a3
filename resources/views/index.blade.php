<!DOCTYPE html>
<html lang="en">
  <head>
    <!--head-->
    <title>Mortgage Payment Calculator</title>
    <meta charset="utf-8" />
    <!--referenced css style libs-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="css/mortCalc.css">

  </head>

  <!--start of html body -->
  <body>
    <h2>Mortgage Payment Calculator</h2>
    <!--start of form -->
    <Form method='GET' action='/process' id='formMort'>
          <!--text input box for loan amount entry -->
          <label for='loan'>Loan Amount:</label>
          <input type='number' step='0.01' min='1' name='loan' value={{ isset($_GET['loan']) ? $_GET['loan'] : '' }} {{old('loan')}}><br/>
          <!--Reference: Information leveraged to retain data in textboxes
           https://laracasts.com/discuss/channels/laravel/input-data-not-remaining-after-refresh-using-old?page=1-->

          <!--text input box for interest rate entry -->
          <label for='interestRate'>Interest Rate:</label>
          <input type='number' step='0.001' min='1.01' name='interestRate' value={{ isset($_GET['interestRate']) ? $_GET['interestRate'] : '' }} {{old('interestRate')}}><br/>

          <!--option radio buttons for type of interest rate -->
          <b>Interest Type:</b>
          <label><input type='radio' name='interestType' value='fixed' {{ isset($_GET['interestType']) && $_GET['interestType']=='fixed' ? 'checked' : '' }} {{old('interestType')=='fixed' ? 'checked' : ''}}> Fixed</label>
          <label><input type='radio' name='interestType' value='variable' {{ isset($_GET['interestType']) && $_GET['interestType']=='variable' ? 'checked' : '' }} {{old('interestType')=='variable'  ? 'checked' : ''}}> Variable</label><br/>
          <!--Reference: Information leveraged to retain option boxes checked
          https://laracasts.com/discuss/channels/laravel/sex-radio-input-options-old-input-->

          <!--select downdown for duration of loan in years -->
          <label for='loanDuration'>Select loan duration</label>
          <select name='loanDuration'>
            <option value=''> Select one</option>
            <option value='15' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='15' ? 'Selected' : '' }} {{old('loanDuration')=='15' ? 'Selected' : ''}} > 15 yrs</option>
            <option value='20' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='20' ? 'Selected' : '' }} {{old('loanDuration')=='20' ? 'Selected' : ''}} > 20 yrs</option>
            <option value='25' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='25' ? 'Selected' : '' }} {{old('loanDuration')=='25' ? 'Selected' : ''}} > 25 yrs</option>
            <option value='30' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='30' ? 'Selected' : '' }} {{old('loanDuration')=='30' ? 'Selected' : ''}} > 30 yrs</option>
            <option value='35' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='35' ? 'Selected' : '' }} {{old('loanDuration')=='35' ? 'Selected' : ''}} > 35 yrs</option>
            <option value='40' {{ isset($_GET['loanDuration']) && $_GET['loanDuration']=='40' ? 'Selected' : '' }} {{old('loanDuration')=='40' ? 'Selected' : ''}} > 40 yrs</option>
          </select><br/>

          <!--checkbox to show or hide amortization table -->
          <label><input type='checkbox' name='show_table' value='show_table' {{ isset($_GET['show_table']) ? 'checked' : ''}} {{old('show_table') ? 'checked' : ''}}> Display Amortization Table</label><br/>
          <label><input type='checkbox' name='show_loanCost' value='show_loanCost' {{ isset($_GET['show_loanCost']) ? 'checked' : ''}} {{old('show_loanCost') ? 'checked' : ''}}> Display Loan Cost Lifetime Summary</label><br/>
          <!--Reference: Technique used based on method used on this website:
          http://stackoverflow.com/questions/12541419/php-keep-checkbox-checked-after-submitting-form-->

          <!--submit & reset buttons -->
          <input type='submit' name='submit' class='btn btn-primary btn-small'>
          <input type='button' name='reset' class='btn btn-primary btn-small' onclick="parent.location='index.php'" value='Reset Form'>
          <!--Reference: Technique for reset button, got ideas from Piazza forum and this website:
          http://www.plus2net.com/html_tutorial/button-linking.php -->
    </form>

    {{--{{dump($errors)}}; --}}

    <!--check for validation errors, if found, display and hald calculations, code leveraged from class lecture notes -->
    @if(count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }} </li>
            @endforeach
            Input values preset to previously entered values.
            Please submit form again with preset values or with updated values.
        </ul>
    @endif

    <!--conditional display once GET happens; display of inputs, calculated status, and mortgage payment -->
    {{--if the form is submitted, display results--}}
    @if($_GET && count($errors) == 0)
      <hr></hr>
        <div>
          <h2>Mortgage Information</h2>
          Loan Amount: ${{$loanDisplay}}<br/>
          Interest Rate (Annual): {{$interestRateDisplay}}%<br/>
          Interest Rate (Monthly): {{$interestRateMonthlyDisplay}}%<br/>
          Interest Type: {{$interestTypeDisplay}}<br/>
          Loan Duration : {{$loanDurationDisplay}} ({{$loanMonths}} months)<br/>
          <h4>Estimated Monthly Payment: ${{$monthlyPaymentDisplay}}</h4>
        </div>
    @endif

    <!--conditional display once GET happens check box is checked; display of loan lifetime cost summary -->
    @if(!empty($_GET['show_loanCost']) && $_GET && count($errors) == 0)
      <hr></hr>
        <div>
          <h2>Mortgage Lifetime Cost Summary</h2>
          Loan Amount: ${{$loanDisplay}}<br/>
          Total Interest Paid: ${{$interestTotal}}<br/>
          Average Interest Rate (Monthly): {{$interestRateAvg}}%<br/>
          Total Loan Cost: ${{$loanTotalCost}}<br/>
          Number Payments : {{$loanMonths}}<br/>
        </div>
    @endif

    <!--conditional display of mortgage amortization table, code stored on separate php files that has table display logic (soc)-->
      @if(!empty($_GET['show_table']) && $_GET && count($errors) == 0)
      <hr></hr>
        <div>
          <h2>Mortgage Amortization Schedule</h2>
          @include('amortTbl');
        </div>
      @endif

<body>
</html>
