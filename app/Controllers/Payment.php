<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class Payment extends BaseController
{
    private $model;
    private $modul;
    public function __construct()
    {
        Configuration::setXenditKey("xnd_development_5yXT3xm16WVGn5twBL7AlJHKcLDYCJAFsBgBEIQWlwPJKXsH0aDqvaJoM3fUc");
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }


    public function createInvoice()
    {

        // menggunakan post
        $paket = $this->request->getPost('paket');

        $sesi = $this->request->getPost('sesi');
        $idusers = $this->request->getPost('idusers');
        $amount = $this->determineAmount($paket, $sesi);
        $description = "Payment " . $paket . ", " . $sesi . " Session";
        $email = $this->request->getPost('email');
        $name = $this->request->getPost('name');
        $mobile = $this->request->getPost('mobile');


        if ($amount > 0) {
            // Inisialisasi Xendit dengan API key

            $apiInstance = new InvoiceApi();
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => 'invoice_' . time(),
                'description' => $description,
                'amount' => $amount,
                'customer' => array(
                    'given_names' => $name,
                    'email' => $email,
                    'mobile_number' => $mobile,
                ),
                'customer_notification_preference' => array(
                    'invoice_created' => ['email', 'whatsapp'],
                    'invoice_reminder' => ['email', 'whatsapp'],
                    'invoice_paid' => ['email', 'whatsapp'],
                ),
                'success_redirect_url' => base_url('payment/success'),
                'failure_redirect_url' => base_url('payment/failure'),
            ]);

            try {
                $result = $apiInstance->createInvoice($createInvoiceRequest);
                $today = date('Y-m-d');
                $tgl_berakhir = $this->calculateEndDate($today, $sesi);

                // Simpan data langganan ke history_subscribe
                $data = [
                    'idsubs' => $this->model->autokode("B", "idsubs", "history_subscribe", 2, 7),
                    'external_id' => $result['external_id'],
                    'checkout_link' => $result['invoice_url'],
                    'status' => 'Pending',
                    'paket' => $paket,
                    'sesi' => $sesi,
                    'amount' => $amount,
                    'tgl_langganan' => $today,
                    'tgl_berakhir' => $tgl_berakhir,
                    'idusers' => $idusers,
                ];

                $this->model->add("history_subscribe", $data);
                return $this->response->setJSON([
                    'error' => false,
                    'invoice_url' => $result['invoice_url']
                ]);
            } catch (\Xendit\XenditSdkException $e) {
                echo 'Exception when calling InvoiceApi->createInvoice: ', $e->getMessage(), PHP_EOL;
                echo 'Full Error: ', json_encode($e->getFullError()), PHP_EOL;
            }

        } else {
            return $this->response->setJSON(['error' => 'Invalid amount']);
        }


    }

    public function webhook()
    {
        // Token Verifikasi Webhook dari Xendit
        $getToken = $this->request->getHeaderLine('X-Callback-Token');
        $callbackToken = 'zdqtX5VrLFKZ9vHTInKLxdi7E6XtMoOPh6I9S1wViiibmH1Y';



        try {
            // Mendapatkan external_id dari payload
            $payload = $this->request->getJSON(true);
            $externalId = $payload['external_id'] ?? null; // Pastikan external_id ada di payload
            $status = $payload['status'] ?? null;

            if (!$externalId || !$status) {
                return $this->response->setJSON([
                    'message' => 'Invalid payload',
                    'payload' => $payload
                ])->setStatusCode(400); // Bad request jika payload tidak valid
            }

            // Cek apakah `external_id` ditemukan di database
            $order = $this->model->getAllQR("SELECT * FROM history_subscribe WHERE external_id = '" . $externalId . "'");

            // Verifikasi token jika diperlukan
            if ($getToken !== $callbackToken) {
                return $this->response->setJSON([
                    'message' => 'Invalid token',
                    'token' => $getToken,
                    'callbackToken' => $callbackToken
                ])->setStatusCode(403); // Forbidden status jika token tidak sesuai
            }

            if ($order) {
                if ($status === 'PAID') {
                    // Update status menjadi Completed
                    $this->model->getAllQR("UPDATE history_subscribe SET status = 'Paid' WHERE external_id = '" . $externalId . "'");
                } else {
                    // Update status menjadi Failed
                    $this->model->getAllQR("UPDATE history_subscribe SET status = 'Failed' WHERE external_id = '" . $externalId . "'");
                }
            } else {
                return $this->response->setJSON([
                    'message' => 'Order not found'
                ])->setStatusCode(404); // Not found jika `external_id` tidak ada
            }

            // Response sukses
            return $this->response->setJSON([
                'message' => 'Success',
                'token' => $getToken,
                'callbackToken' => $callbackToken
            ]);
        } catch (\Xendit\XenditSdkException $e) {
            // Tangani error dari Xendit
            return $this->response->setJSON([
                'message' => 'Error when calling Xendit API',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }


    // public function notification($externalId)
    // {
    //     // Inisialisasi instance API Xendit
    //     $apiInstance = new InvoiceApi();

    //     try {
    //         // Mengambil status invoice berdasarkan external_id dari Xendit
    //         $result = $apiInstance->getInvoices($externalId);

    //         // Mengambil data invoice dari database menggunakan query custom
    //         $invoice = $this->model->getAllQR("SELECT * FROM history_subscribe WHERE external_id = '" . $externalId . "';");

    //         if (empty($invoice)) {
    //             return $this->response->setStatusCode(404)->setJSON(['message' => 'Invoice not found']);
    //         }

    //         // Cek jika status sudah settled, artinya pembayaran telah berhasil
    //         if ($invoice[0]['status'] === 'settled') {
    //             return $this->response->setJSON(['message' => 'Payment anda telah berhasil di proses']);
    //         }

    //         // Update status invoice di database berdasarkan status dari Xendit
    //         $newStatus = $result['data'][0]['status']; // Ambil status dari hasil API
    //         $this->model->getAllQR("UPDATE history_subscribe SET status = '" . $newStatus . "' WHERE external_id = '" . $externalId . "';");

    //         return $this->response->setJSON(['message' => 'Success']);
    //     } catch (\Xendit\XenditSdkException $e) {
    //         // Menangani error saat memanggil API Xendit
    //         return $this->response->setStatusCode(500)->setJSON(['message' => 'Error processing request', 'error' => $e->getMessage()]);
    //     }
    // }


    public function success()
    {

        session()->remove('notification_free');

        return redirect()->to(base_url('session'));

    }


    public function failure()
    {
        $this->modul->halaman('error');
        // return $this->response->setJSON(['error' => 'Invalid payment']);
    }

    private function determineAmount($paket, $sesi)
    {
        $amount = 0;

        if ($paket === 'Local Package') {
            switch ($sesi) {
                case '0':
                    $amount = 1000;
                    break;
                case '1':
                    $amount = 63000;
                    break;
                case '4':
                    $amount = 242000;
                    break;
                case '8':
                    $amount = 460000;
                    break;
                case '15':
                    $amount = 811000;
                    break;
                default:
                    $amount = 0;
                    break;
            }
        } elseif ($paket === 'International Package') {
            switch ($sesi) {
                case '0':
                    $amount = 1000;
                    break;
                case '1':
                    $amount = 75000;
                    break;
                case '4':
                    $amount = 288000;
                    break;
                case '8':
                    $amount = 548000;
                    break;
                case '15':
                    $amount = 965000;
                    break;
                default:
                    $amount = 0;
                    break;
            }
        }

        return $amount;
    }

    public function calculateEndDate($startDate, $sesi)
    {
        // Hitung tanggal berakhir berdasarkan sesi
        switch ($sesi) {
            case '0':
                return date('Y-m-d', strtotime($startDate . ' + 1 day'));
            case '1':
                return date('Y-m-d', strtotime($startDate . ' + 1 week'));
            case '4':
                return date('Y-m-d', strtotime($startDate . ' + 4 weeks'));
            case '8':
                return date('Y-m-d', strtotime($startDate . ' + 8 weeks'));
            case '15':
                return date('Y-m-d', strtotime($startDate . ' + 15 weeks'));
            default:
                return $startDate; // Jika sesi tidak valid, tetapkan tanggal mulai
        }
    }
}