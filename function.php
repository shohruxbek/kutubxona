<?php
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}







function fonts($font){
switch ($font) {
    case '1':    $vb = '1.php'; $vn = '1'; break;
    case '2':    $vb = '2.php'; $vn = '2'; break;
    case '3':    $vb = '3.php'; $vn = '3'; break;
    case '4':    $vb = '4.php'; $vn = '4'; break;
    case '5':    $vb = '5.php'; $vn = '5'; break;
    case '6':    $vb = '6.php'; $vn = '6'; break;
    case '7':    $vb = '7.php'; $vn = '7'; break;
    case '8':    $vb = '8.php'; $vn = '8'; break;
    case '9':    $vb = '9.php'; $vn = '9'; break;
    case '10':    $vb = '10.php'; $vn = '10'; break;
    case '11':    $vb = '11.php'; $vn = '11'; break;
    case '12':    $vb = '12.php'; $vn = '12'; break;
    case '13':    $vb = '13.php'; $vn = '13'; break;
    case '14':    $vb = '14.php'; $vn = '14'; break;
    case '15':    $vb = '15.php'; $vn = '15'; break;
    case '16':    $vb = '16.php'; $vn = '16'; break;
    case '17':    $vb = '17.php'; $vn = '17'; break;
    case '18':    $vb = '18.php'; $vn = '18'; break;
    case '19':    $vb = '19.php'; $vn = '19'; break;
    case '20':    $vb = '20.php'; $vn = '20'; break;
    case '21':    $vb = '21.php'; $vn = '21'; break;
    case '22':    $vb = '22.php'; $vn = '22'; break;
    case '23':    $vb = '23.php'; $vn = '23'; break;
    case '24':    $vb = '24.php'; $vn = '24'; break;
    case '25':    $vb = '25.php'; $vn = '25'; break;
    case '26':    $vb = '26.php'; $vn = '26'; break;
    case '27':    $vb = '27.php'; $vn = '27'; break;
    case '28':    $vb = '28.php'; $vn = '28'; break;
    case '29':    $vb = '29.php'; $vn = '29'; break;
    case '30':    $vb = '30.php'; $vn = '30'; break;
    case '31':    $vb = '31.php'; $vn = '31'; break;
    case '32':    $vb = '32.php'; $vn = '32'; break;
    case '33':    $vb = '33.php'; $vn = '33'; break;
    case '34':    $vb = '34.php'; $vn = '34'; break;
    case '35':    $vb = '35.php'; $vn = '35'; break;
    default :    $vb = '4003.php';    $vn = '4003';   break;
}
$s = ["$vb","$vn"];
return $s;
}


function getToken($length)
{
    $token = "";
    /*    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";*/
    $codeAlphabet= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}


function finish($chat_id,$tanlov,$ism,$infotext,$avtor,$font,$ismfont,$link){


 require('fpdf182/fpdf.php');
 require('textbox.php');

 $ism=htmlspecialchars_decode($ism);
 $infotext=htmlspecialchars_decode($infotext);
 $avtor=htmlspecialchars_decode($avtor);
 $ism=str_replace("&#39;", "'", $ism);
 $infotext=str_replace("&#39;", "'", $infotext);
 $avtor=str_replace("&#39;", "'", $avtor);



$resismfont = fonts($ismfont);
$resfont = fonts($font);


    $pdf=new PDF_TextBox();

     
      if($tanlov==12){
       $pdf->AddPage(L);
        $pdf->Image("diplom/$tanlov.jpg",0,0,297,210);
        $pdf->AddFont($resismfont[1],'',$resismfont[0]);
        $pdf->SetFont($resismfont[1],'',60);
         $pdf->SetTextColor(0,0,0);
        $pdf->Cell(330,150,"$ism",0,0,'C');

        $pdf->AddFont($resfont[1],'',$resfont[0]);
        $pdf->SetFont($resfont[1],'',20);

        $pdf->SetXY(65,20);
        $pdf->drawTextBox("$infotext", 220, 200, 'C', 'M');
        $kun = date('d.m.Y');


        $pdf->SetXY(102,174);
        $pdf->SetFont($resfont[1],'',20);
        $pdf->Write(5,"$kun - yil");

        $pdf->SetXY(200,174);
        $pdf->Write(5,"$avtor");

$id = time();
//file_get_contents("https://it.loc/qr/index.php?text=$link&id=$id");

        $pdf-> Image("qr/temp/1625077840.png",8,12,30,30);
    }     

     
    $fi = $chat_id.time();
    $filename="file/{$fi}.pdf";
    $pdf->Output($filename,'F');

}
// /function finish($chat_id,$tanlov,$ism,$infotext,$avtor,$menu,$naqd,$font,$ismfont){
finish(1,12,"Shohruxbek Aralov","Salom sen diplom olding, xursand bo'lmaysanmi?","It park Samaqand",5,6,"https://zeroday.uz/diplom/file/upload/php?id=15");
?>