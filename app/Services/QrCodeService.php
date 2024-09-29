<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;

class QrCodeService 
{
    public function generateQrCode(string $data): string
    {
        $qrCode = new QrCode($data);
        $writer = new PngWriter();

        $result = $writer->write($qrCode);
        $fileName = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $result->getString());

        return 'storage/' . $fileName;
    }
}
