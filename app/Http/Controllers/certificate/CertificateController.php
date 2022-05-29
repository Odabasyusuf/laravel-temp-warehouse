<?php

namespace App\Http\Controllers\certificate;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CertificateController extends Controller
{
    public function index(){
        header('content-type:image/jpeg');

        $font1= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/BRUSHSCI.ttf";
        $font2= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/AGENCYR.ttf";
        $image=imagecreatefromjpeg("/Users/odabas/PhpstormProjects/asd123/public/assets/images/certificate.jpg"); // http://127.0.0.1:8000/assets/images/certificate.jpg

        $color=imagecolorallocate($image,19,21,22);
        $name="Mehmet Akif";
        imagettftext($image,50,0,370,420,$color,$font1,$name);
        $date="27.05.2022";
        imagettftext($image,20,0,450,595,$color,$font2,$date);
        imagejpeg($image);
        imagedestroy($image);

//        return "ok";
        return view('certificate.index');
    } // Koordinatlı

    public function index2(){
        header('content-type:image/jpeg');

        $font1= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/BRUSHSCI.ttf";
        $font2= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/AGENCYR.ttf";
        $image=imagecreatefromjpeg("/Users/odabas/PhpstormProjects/asd123/public/assets/images/certificate.jpg"); // http://127.0.0.1:8000/assets/images/certificate.jpg

        $color=imagecolorallocate($image,19,21,22);
        $name="Mehmet Akif Karagüllü";
//        imagettftext($image,50,0,370,420,$color,$font1,$name);
//        $date="27.05.2022";
//        imagettftext($image,20,0,450,595,$color,$font2,$date);

        // Get image dimensions
        $width = imagesx($image);
        $height = imagesy($image);
// Get center coordinates of image
        $centerX = $width / 2;
        $centerY = $height / 2;
// Get size of text
        list($left, $bottom, $right, , , $top) = imageftbbox(50, 0, $font1, $name);
// Determine offset of text
        $left_offset = ($right - $left) / 2;
        $top_offset = ($bottom - $top) / 2;
// Generate coordinates
        $x = $centerX - $left_offset;
        $y = $centerY + $top_offset;
// Add text to image
        imagettftext($image, 50, 0, $x, $y, $color, $font1, $name);

        imagejpeg($image);
        imagedestroy($image);

//        return "ok";
        return view('certificate.index');
    } // Koordinatlı - Ortalı

    public function index3(){
        header('content-type:image/jpeg');

        $font1= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/BRUSHSCI.ttf";
        $font2= "/Users/odabas/PhpstormProjects/asd123/public/assets/fonts/AGENCYR.ttf";
        //Arkaplan resmi
        $image=imagecreatefromjpeg("/Users/odabas/PhpstormProjects/asd123/public/assets/images/certificate.jpeg"); // http://127.0.0.1:8000/assets/images/certificate.jpg
        //imzalar
        $imza1= imagecreatefrompng("/Users/odabas/PhpstormProjects/asd123/public/assets/images/signature.png");
        $imza_w_1 = imagesx($imza1);
        $imza_h_1 = imagesy($imza1);

        $imza2= imagecreatefrompng("/Users/odabas/PhpstormProjects/asd123/public/assets/images/signature2.png");
        $imza_w_2 = imagesx($imza2);
        $imza_h_2 = imagesy($imza2);


        $color=imagecolorallocate($image,19,21,22);
        $name="Ad Soyad";
        $date="27.05.2022";
        $signature_1_name = "Kaan Gülten";
        $signature_1_status = "CEO at Webtures";;
        $signature_2_name = "Yusuf Odabas";
        $signature_2_status = "Software Developer at Webtures";


        // Arkaplanın Genişlik ve Yükseklik Bilgisi
        $width = imagesx($image);
        $height = imagesy($image);

        // Arkaplanın Tam Orta Noktası
        $centerX = $width / 2;
        $centerY = $height / 2;

        // İsim Alanı
        list($left, $bottom, $right, , , $top) = imageftbbox(50, 0, $font1, $name);

        $left_offset = ($right - $left) / 2;
        $top_offset = ($bottom - $top) / 2;

        $x = $centerX - $left_offset;
        $y = $centerY + $top_offset;

        imagettftext($image, 50, 0, $x, $y-50, $color, $font1, $name);
        // isim alanı son

        // Tarih alanı
        imagettftext($image,20,0,460,420,$color,$font2,$date);

        // 1.imza alanı
        imagettftext($image,18,0,185,480,$color,$font2,$signature_1_name);
        imagettftext($image,10,0,185,500,$color,$font2,$signature_1_status);
        imagecopy($image, $imza1, 160, 520, 0, 0, $imza_w_1, $imza_h_1);

        // 1.imza alanı
        imagettftext($image,18,0,740,480,$color,$font2,$signature_2_name);
        imagettftext($image,10,0,740,500,$color,$font2,$signature_2_status);
        imagecopy($image, $imza1,  720, 520, 0, 0, $imza_w_1, $imza_h_1);

        $slugName = Str::slug($name,'');
        if (!is_dir(public_path('certificates'))) File::makeDirectory('certificates'); //certificates klasörü yoksa yeni klasör oluştur.
        // if (!is_dir(public_path('certificates/kurs'))) File::makeDirectory('certificates/kurs'); //kurs dizini yoksa yeni oluştur.
        imagejpeg($image, public_path('certificates/'.$slugName.'.jpg') );

        imagedestroy($image);

        $pdf = PDF::loadFile(public_path('certificates/'.$slugName.'.jpg'));
        return $pdf->download('invoice.pdf');

//        return "Sertifika Oluşturuldu. <br/>". public_path('certificates/'.$slugName.'.jpg');
//        return view('certificate.index');
    }

}
