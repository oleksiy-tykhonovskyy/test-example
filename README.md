## Abstract

Okay. this project was made to show difference in test case required to test all the possible cases.
There are 2 implementations of the same businessflow - with final classes and with regular one.


## Businessflow
I want to process a payment messages we got form some resource. Message should contains 2 elements (at least): 
currency and amount.

There are some requirements:
1 - we process only 2 currencies: USD and EUR. 
2 - we should pay in PLN, so, we should convert USD and EUR to PLN.
3 - in case we try to pay more than some quota, we should reject the payment.


## How to run
1. Clone the project
2. Run `composer install`
3. Run `composer dump-autoload`

## Limitations
This is not real production app. So, external calls are mocked with some constant values.

## testcases
Happy path:

1 - pay small amount in USD
1 - pay small amount in EUR


Business rule limitations:

1 - pay huge amount in USD
1 - pay huge amount in EUR
1 - pass wrong message (4 cases)
1 - pass wrong currency

## Test classic approach

run `./vendor/bin/phpunit tests/Classic/`

## Test final approach

run `./vendor/bin/phpunit tests/Final/`

## Results
Usage of the final classes requires more tests, as tests from nested classes should be added in the class use it. 
We can see that some branched of the code are not used in the higher level classes. It will reduce the number of tests,
but it still require more tests. Additionally we add knowledge of the implementation of the used classes into the tests of 
the higher level classes (otherwise we cannot emulate all possible returns of the nested classes). 