<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Subscribe extends BaseController
{
    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index(): void
    {

        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {

            $idusers = session()->get("idusers");

            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");

            if ($history_subs === NULL || $history_subs->status === 'Pending') {

                $data['showSessionMenu'] = false;
                $data['idusers'] = session()->get("idusers");
                $data['nama'] = session()->get("nama");
                $data['role'] = session()->get("role");
                $data['menu'] = $this->request->getUri()->getSegment(1);
                $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

                $def_foto = base_url() . 'front/images/noimg.png';
                $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                if (strlen($foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $foto)) {
                        $def_foto = base_url() . '/uploads/' . $foto;
                    }
                }
                $data['foto_profile'] = $def_foto;

                if ($history_subs !== NULL) {
                    if ($history_subs->status === "Paid") {
                        $data['showSessionMenu'] = true;
                        session()->remove('notification_pending');
                    } else {
                        $notificationMsg = "Complete your payment, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                        session()->setFlashdata('notification_pending', $notificationMsg);


                        $pakethabis = false;
                        if ($history_subs) {
                            try {
                                $today = date("Y-m-d");
                                $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));

                                $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik

                                $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                                if ($diff < 0) {
                                    $pakethabis = true;
                                }
                            } catch (\Exception $e) {
                                // Tangani error jika terjadi masalah
                                echo "Error: " . $e->getMessage();
                            }
                        }


                        $data['pakethabis'] = $pakethabis;

                    }
                }

                $instansi = session()->get("idinstansi");
                $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
                $data['free'] = $instansi === NULL && $history_subs === NULL || $siswaluar_free;
                if ($data['free'] === true) {
                    $notificationMsg = "You are currently using a free account. Please subscribe to access exclusive feature.";
                    session()->setFlashdata('notification_free', $notificationMsg);
                }

                echo view('page/dashboardsiswa/layout/head', $data);
                echo view('page/dashboardsiswa/subscribe', $data);
                echo view('page/dashboardsiswa/layout/foot', $data);
            } else {
                $this->modul->halaman('loginsiswa');
            }
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }


    // public function checkout()
    // {
    //     // Ambil data dari request JSON
    //     $data = $this->request->getJSON(true);

    //     // Pastikan variabel yang dikirim dalam JSON
    //     $paket = $data['paket'];
    //     $sesi = $data['sesi'];
    //     $amount = 0;

    //     // Tentukan jumlah pembayaran berdasarkan paket dan sesi yang dipilih
    //     if ($paket === 'Local Package') {
    //         switch ($sesi) {
    //             case '0':
    //                 $amount = 1000;
    //                 break;
    //             case '1':
    //                 $amount = 63000;
    //                 break;
    //             case '4':
    //                 $amount = 242000;
    //                 break;
    //             case '8':
    //                 $amount = 460000;
    //                 break;
    //             case '15':
    //                 $amount = 811000;
    //                 break;
    //             default:
    //                 $amount = 0;
    //                 break; // Berikan nilai default jika sesi tidak valid
    //         }
    //     } else if ($paket === 'International Package') {
    //         switch ($sesi) {
    //             case '0':
    //                 $amount = 1000;
    //                 break;
    //             case '1':
    //                 $amount = 75000;
    //                 break;
    //             case '4':
    //                 $amount = 288000;
    //                 break;
    //             case '8':
    //                 $amount = 548000;
    //                 break;
    //             case '15':
    //                 $amount = 965000;
    //                 break;
    //             default:
    //                 $amount = 0;
    //                 break; // Berikan nilai default jika sesi tidak valid
    //         }
    //     }

    //     if ($amount > 0) {

    //         $url = base_url('session');
    //         // Siapkan data untuk API Mayar berdasarkan input dari AJAX
    //         $paymentData = [
    //             "idusers" => $data['idusers'],
    //             "name" => $data['name'],
    //             "email" => $data['email'],
    //             "amount" => $amount,
    //             "mobile" => $data['mobile'],
    //             "redirectUrl" => $url,
    //             "description" => $data['description'],
    //             "expiredAt" => $data['expiredAt'],
    //             "paket" => $data['paket'],
    //             "sesi" => $data['sesi'],
    //         ];
    //         $paket = $data["paket"];
    //         $sesi = $data["sesi"];
    //         $idusers = $data["idusers"];

    //         // // Panggil fungsi untuk membuat sesi pembayaran
    //         $response = $this->createPayment($paymentData);

    //         // Proses respons dari API
    //         if ($response) {
    //             if ($response->statusCode === 200) {

    //                 if ($response->messages === "success") {
    //                     // Hitung tanggal beakhir berdasarkan sesi
    //                     $today = date('Y-m-d');
    //                     $tgl_berakhir = $this->calculateEndDate($today, $sesi);

    //                     // Simpan data langganan ke history_subscribe
    //                     $data = [
    //                         'idsubs' => $this->model->autokode("B", "idsubs", "history_subscribe", 2, 7),
    //                         'paket' => $paket,
    //                         'sesi' => $sesi,
    //                         'tgl_langganan' => $today,
    //                         'tgl_berakhir' => $tgl_berakhir,
    //                         'idusers' => $idusers,
    //                     ];

    //                     $simpan = $this->model->add("history_subscribe", $data);

    //                     if ($simpan) {
    //                         return $this->response->setJSON([
    //                             'success' => true,
    //                             'payment_url' => $response->data->link,
    //                             'message' => 'Pembayaran berhasil, langganan ditambahkan.'
    //                         ]);
    //                     } else {
    //                         return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan data langganan.']);
    //                     }
    //                 } else {
    //                     return $this->response->setJSON(['success' => false, 'message' => 'Gagal membuat sesi pembayaran: ' . $response->messages]);
    //                 }
    //             } else {
    //                 return $this->response->setJSON(['success' => false, 'message' => 'Pembayaran Sesi Gagal: ' . $response->messages]);
    //             }
    //         } else {
    //             return $this->response->setJSON(['success' => false, 'message' => 'Pembayaran Gagal.']);
    //         }
    //     } else {
    //         return $this->response->setJSON(['success' => false, 'message' => 'Paket atau sesi tidak valid.']);
    //     }
    // }


    // public function calculateEndDate($startDate, $sesi)
    // {
    //     // Hitung tanggal berakhir berdasarkan sesi
    //     switch ($sesi) {
    //         case '0':
    //             return date('Y-m-d', strtotime($startDate . ' + 1 day'));
    //         case '1':
    //             return date('Y-m-d', strtotime($startDate . ' + 1 week'));
    //         case '4':
    //             return date('Y-m-d', strtotime($startDate . ' + 4 weeks'));
    //         case '8':
    //             return date('Y-m-d', strtotime($startDate . ' + 8 weeks'));
    //         case '15':
    //             return date('Y-m-d', strtotime($startDate . ' + 15 weeks'));
    //         default:
    //             return $startDate; // Jika sesi tidak valid, tetapkan tanggal mulai
    //     }
    // }
    // public function createPayment($paymentData)
    // {
    //     // Inisialisasi cURL
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.mayar.id/hl/v1/payment/create',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => json_encode($paymentData),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiIxNDc5Mzc4Ni1lN2YxLTRlYjQtOGFlZC1lZTgzOWQ5ZTllMWYiLCJhY2NvdW50SWQiOiI4NmYzNDM5Zi0zMmU5LTRjZDktYmE5Mi0wZDRkODc4NGQxMmEiLCJjcmVhdGVkQXQiOiIxNzI5MTU2NDM4MzE3Iiwicm9sZSI6ImRldmVsb3BlciIsInN1YiI6ImhxQGxlYXBzdXJhYmF5YS5zY2guaWQiLCJuYW1lIjoiTGVhcCBFbmdsaXNoIGFuZCBEaWdpdGFsIENsYXNzIiwibGluayI6ImxlYXAtaHEiLCJpc1NlbGZEb21haW4iOm51bGwsImlhdCI6MTcyOTE1NjQzOH0.jinCaMVsHPYcyosOi2rm5x-AAoNEu3ArfUY-d-5LHbUJQxi3WnR_reXxQteite-kYT6TzKYiNOLPs-30CN3DmHd4HtABOS8XHtHdrV3hgHys8hQ6n6lNpiY7yICVjn2yNkcrY_ziyUBmaZlmWyCfV66nFncGeMdH0z9mFe5BAF9vgtrY2SOQMG-Zo9aE-jYjRnP21WctmlKOk3x3VHASH3CwRbIgesejkZDVMAXHz0jdnXNY0xSsE1FN2A13sqsDMCZWRPzHwBCKoRXo1UsWML66lv0EjxyUu6VPzGG6tivH0StcFB95wdFI95spegLjbqoVGwQcswuh4OQIRqYkPQ', // Ganti dengan API Key Anda
    //             'Content-Type: application/json'
    //         ),
    //     ));

    //     $response = curl_exec($curl);
    //     $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Dapatkan kode status HTTP

    //     curl_close($curl);

    //     // Jika terjadi kesalahan dengan cURL
    //     if (curl_errno($curl)) {
    //         log_message('error', 'CURL Error: ' . curl_error($curl));
    //     }

    //     if ($httpCode === 200) {
    //         return json_decode($response);
    //     } else {
    //         // Log untuk kesalahan
    //         log_message('error', 'Payment API Error: ' . $response . ' - HTTP Code: ' . $httpCode);
    //         return null;
    //     }
    // }
}