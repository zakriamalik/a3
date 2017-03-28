<!DOCTYPE html>
<html lang="en">
  <head>
    <!--head-->
    <title>Mortgage Payment Calculator</title>
    <meta charset="utf-8" />
    <!--referenced css style libs-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">

  </head>

<!--start of html body -->
  <body>
    <h2>Mortgage Payment Calculator</h2>
    <!--start of form -->
    <Form method='GET' action='/index.php'>
          <!--text input box for loan amount entry -->
          <label for='loan'>Loan Amount:</label>
          <input type='number' step='0.01' min='1' name='loan' value='{{ $loan or '' }}'><br/>

          <!--text input box for interest rate entry -->
          <label for='interestRate'>Interest Rate:</label>
          <input type='number' step='0.001' min='1.01' name='interestRate' value='{{ $interestRate or '' }}'><br/>

          <!--option radio buttons for type of interest rate -->
          <b>Interest Type:</b>
          <label><input type='radio' name='interestType' value='{{ ($interestType='fixed') ? 'CHECKED' : '' }}'> Fixed</label>
          <label><input type='radio' name='interestType' value='{{ ($interestType='variable') ? 'CHECKED' : '' }}'> Variable</label><br/>

          <!--select downdown for duration of loan in years -->
          <label for='loanDuration'>Select loan duration</label>
          <select name='loanDuration'>
            <option value='select_one'>Select one</option>
            <option value='{{($loanDuration = '15 yrs') ? 'SELECTED' : '' }}'>15 yrs</option>
            <option value='{{($loanDuration = '20 yrs') ? 'SELECTED' : '' }}'>20 yrs</option>
            <option value='{{($loanDuration = '25 yrs') ? 'SELECTED' : '' }}'>25 yrs</option>
            <option value='{{($loanDuration = '30 yrs') ? 'SELECTED' : '' }}'>30 yrs</option>
            <option value='{{($loanDuration = '35 yrs') ? 'SELECTED' : '' }}'>35 yrs</option>
            <option value='{{($loanDuration = '40 yrs') ? 'SELECTED' : '' }}'>40 yrs</option>
          </select><br/>

          <!--checkbox to show or hide amortization table -->

          <!--submit & reset buttons -->
          <input type='submit' name='submit' class='btn btn-primary btn-small'>
          <input type='button' name='reset' class='btn btn-primary btn-small' onclick="parent.location='index.php'" value='Reset Form'>
          <!--Technique for reset button, got ideas from Piazza forum and this website:  http://www.plus2net.com/html_tutorial/button-linking.php -->

          <!--check for validation errors, if found, display and hald calculations, code leveraged from class lecture notes -->

    </form>

    <?php if($_GET): ?>
      <hr></hr>
        <div>
          <h2>Mortgage Information</h2>
          Loan Amount:  <br/>
        </div>
    <?php endif; ?>

    <!--conditional display of entry/input values and some converted values based on formulae in logice (so -->

    <!--conditional display of mortgage amortization table, code stored on separate php files that has table display logic (soc)-->


<body>
</html>
