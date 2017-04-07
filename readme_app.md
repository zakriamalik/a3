# Assignment 3
# This assignment includes building a Mortgage Payment Calculator in Laravel. The key objective of this Laravel application is to provide a utility to a user to help determine estimated mortgage payment upon entry of certain required inputs like loan amount, duration, interest rate, and interest type.
# Additional, option is provided to find the statistics for the life of the loan such as cost of loan, avg rate, etc.
# Another feature provided is the Mortgage Amortization Schedule. This is a table that helps determines the loan payment schedule with visibility into the components of mortgage payment (interest and principal) and a burn-down table from start of initial loan amount down to zero loan amount. The table includes a month field that helps identify the month of the payment. The underlying assumption is that the first payment occurs in next month.  
# Specifications & Conditions:
# 1) The Loan amount is a numerical entry with a range set from $1 to $100 million
# 2) The interest rate is also a numerical entry with a range from 1% to 25%, fractions up to three decimal spaces are accepted
# 3) The loan duration is from 15 yrs to 40 yrs term, with 5 yr increments offered via dropdown
# 4) If the interest rate type is fixed, calculator would use the entered interest rate as fixed throughout the amortization schedule.
# 5) If the interest rate type is variable, calculator would use the entered interest rate as a seed to determine random interest rates +-1% as entered.
# 6) In this calculator, the type of interest rate does not impact the monthly payments which are set to be fixed by design, however the type of interest rate impacts the amortization schedule such that if interest rate type is variable, the interest rate changes from month to month, thus impacting the amounts of interest and principal applied towards the loan balance. This results in either paying loan early or paying a large lump sum residual in the last payment.
# 7) Checkboxes are provided in order to show the loan life time summary and amortization schedule in conjunction with submit button
# 8) Reset button is provided to clear all entries and begin entries from scratch
# 9) Validation is in place, both client side as well as severer side, to determine if the input entries are valid and be used for mathematical calculations
