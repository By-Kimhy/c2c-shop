<?php
namespace App\Services;

class KhqrService
{
    protected function tag(string $id, string $value): string
    {
        $len = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
        return $id . $len . $value;
    }

    /**
     * CRC16-CCITT (False) implementation used by EMV QR
     * poly 0x1021, init 0xFFFF
     */
    protected function crc16(string $data): string
    {
        $crc = 0xFFFF;
        $poly = 0x1021;
        $bytes = unpack('C*', $data);
        foreach ($bytes as $b) {
            $crc ^= ($b << 8);
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) $crc = (($crc << 1) ^ $poly) & 0xFFFF;
                else $crc = ($crc << 1) & 0xFFFF;
            }
        }
        return strtoupper(str_pad(dechex($crc & 0xFFFF), 4, '0', STR_PAD_LEFT));
    }

    /**
     * Build KHQR EMV payload.
     *
     * $merchantInfo keys: gui, merchant_id, merchant_name, merchant_city, mcc
     * $amount decimal, currencyCode '116' for KHR by default
     * $poi '12' dynamic
     * $billNumber optional unique ref
     */
    public function buildPayload(array $merchantInfo, float $amount, string $currencyCode = '116', string $poi = '12', ?string $billNumber = null): string
    {
        $payload = '';

        // Payload Format Indicator (00)
        $payload .= $this->tag('00', '01');

        // Point of Initiation Method (01) - static '11' or dynamic '12'
        $payload .= $this->tag('01', $poi);

        // Merchant Account Info example in tag 30 (provider/trade-specific)
        $ma = '';
        $ma .= $this->tag('00', $merchantInfo['gui'] ?? 'BK'); // GUI (provider id)
        if (!empty($merchantInfo['merchant_id'])) {
            $ma .= $this->tag('01', $merchantInfo['merchant_id']);
        }
        if (!empty($merchantInfo['merchant_name'])) {
            $ma .= $this->tag('02', substr($merchantInfo['merchant_name'], 0, 25));
        }
        $payload .= $this->tag('30', $ma);

        // Merchant Category Code (52)
        $payload .= $this->tag('52', $merchantInfo['mcc'] ?? '0000');

        // Transaction Currency (53)
        $payload .= $this->tag('53', $currencyCode);

        // Transaction Amount (54)
        $payload .= $this->tag('54', number_format($amount, 2, '.', ''));

        // Country Code (58)
        $payload .= $this->tag('58', 'KH');

        // Merchant Name (59) and City (60)
        if (!empty($merchantInfo['merchant_name'])) {
            $payload .= $this->tag('59', substr($merchantInfo['merchant_name'], 0, 25));
        }
        if (!empty($merchantInfo['merchant_city'])) {
            $payload .= $this->tag('60', substr($merchantInfo['merchant_city'], 0, 15));
        }

        // Additional data field (62) - store bill number if present
        $add = '';
        if ($billNumber) {
            $add .= $this->tag('01', $billNumber);
        }
        if ($add) {
            $payload .= $this->tag('62', $add);
        }

        // CRC (63) placeholder then compute CRC over payload + "6304"
        $rawForCrc = $payload . '63' . '04';
        $crc = $this->crc16($rawForCrc);
        $payload .= $this->tag('63', $crc);

        return $payload;
    }
}
