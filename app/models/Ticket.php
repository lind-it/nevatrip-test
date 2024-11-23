<?php

namespace App\Models;

class Ticket extends Model
{
    public static function generateBarcode()
    {
        $barcodeLength = mt_rand(5, 10);

        while ($barcodeLength > 0) {
            $barcode .= mt_rand(0, 9);
            $barcodeLength--;
        }

        return $barcode;
    }
}