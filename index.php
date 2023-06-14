<?php

class NumberToWordsConverter
{
    private $number;

    public array $ones = [
        '',
        'ONE',
        'TWO',
        'THREE',
        'FOUR',
        'FIVE',
        'SIX',
        'SEVEN',
        'EIGHT',
        'NINE',
        'TEN',
        'ELEVEN',
        'TWELVE',
        'THIRTEEN',
        'FOURTEEN',
        'FIFTEEN',
        'SIXTEEN',
        'SEVENTEEN',
        'EIGHTEEN',
        'NINETEEN'
    ];

    public array $tens = [
        '',
        '',
        'TWENTY',
        'THIRTY',
        'FORTY',
        'FIFTY',
        'SIXTY',
        'SEVENTY',
        'EIGHTY',
        'NINETY'
    ];

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function convert()
    {
        $wholeNumber = $this->getWholeNumber();
        $decimalNumber = $this->getDecimalNumber();

        $convertedWords = $this->convertWholeNumberToWords($wholeNumber) . 'DOLLARS ';
        $convertedWords .= $this->covertDecimalNumberToWords($decimalNumber);

        return $convertedWords;
    }

    private function getWholeNumber()
    {
        return floor($this->number);
    }

    private function getDecimalNumber()
    {
        $decimalNumber = $this->number - floor($this->number);
        return round($decimalNumber, 2);
    }

    private function convertWholeNumberToWords($number)
    {
        if ($number < 20) {
            return $this->ones[$number] . ' ';
        }

        if ($number < 100) {
            return $this->tens[floor($number / 10)] . ' ' . $this->ones[$number % 10] . ' ';
        }

        if ($number < 1000) {
            return $this->ones[floor($number / 100)] . ' HUNDRED ' . $this->convertWholeNumberToWords($number % 100);
        }

        if ($number < 1000000) {
            return $this->convertWholeNumberToWords(floor($number / 1000)) . 'THOUSAND ' . $this->convertWholeNumberToWords($number % 1000);
        }

        if ($number < 1000000000) {
            return $this->convertWholeNumberToWords(floor($number / 1000000)) . 'MILLION ' . $this->convertWholeNumberToWords($number % 1000000);
        }

        return '';
    }

    private function covertDecimalNumberToWords($decimalNumber)
    {
        $words = '';

        if ($decimalNumber > 0) {
            $cents = floor($decimalNumber * 100);
            $words .= 'AND ' . $this->convertWholeNumberToWords($cents) . 'CENTS';
        }

        return $words;
    }
}

$number = 10002005.77;
$converter = new NumberToWordsConverter(123.45);
$result = $converter->convert();

echo $result;
?>
