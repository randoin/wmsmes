<?php
function ngitunghari($tgldatang,$tglambil)
{
	$thndatang = substr($tgldatang,0,4);
	$blndatang = substr($tgldatang,5,2);
	$tgldatang = substr($tgldatang,8,2);

	$thnambil = substr($tglambil,0,4);
	$blnambil = substr($tglambil,5,2);
	$tglambil = substr($tglambil,8,2);

	$totalharipinjam=(mktime(0,0,0,$blnambil,$tglambil,$thnambil) - mktime(0,0,0,$blndatang,$tgldatang,$thndatang))/86400;

	$totalhari=floor($totalharipinjam);
     return $totalhari;
}

function increment_tgl($n,$tgl)
{
	$t_bln=substr($tgl,5,2);$t_tgl=substr($tgl,8,2);$t_thn=substr($tgl,0,4);
	$total = mktime (0,0,0,$t_bln ,$t_tgl+$n,$t_thn);
	return date("d/m/Y", $total);
}

function nopos($no)
{
	$tgl=date("Y-m-d");
	$jam = date("H:i:s");
	$thn1 = substr($tgl,2,2);
	$bln1 = substr($tgl,5,2);
	$tgl1= substr($tgl,8,2);
	$jam1 = substr($jam,0,2);
	$men1 = substr($jam,3,2);
	$sec1= substr($jam,6,2);
	$my="$thn1$bln1$tgl1$jam1$men1$sec1$no";
	return $my;
}
	
function kekata($x) {

    $x = abs($x);
   $angka = array("", "satu", "dua", "tiga", "empat", "lima",
   "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }      
        return $temp;
}

function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }      
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }      
    return $hasil;
}

function format_awb($a)
{
	
$c = substr($a,7,4);
$b = substr($a,3,4);
$a= substr($a,0,3);
$my="$a-$b $c";
return $my;
}

function format_nopos($a)
{
	
$c = substr($a,12,10);
$b = substr($a,6,6);
$a= substr($a,0,6);
$my="$a-$b $c";
return $my;
}


function format_uld($a)
{
$b = substr($a,3,15);
$a= substr($a,0,3);
$my="$a-$b";
return $my;
}

function format_flown($a)
{
$a= substr($a,0,3);
$my="$a";
return $my;
}

function ymd2dmy3($tanggal)
{
$thn1 = substr($tanggal,2,2);
$bln1 = substr($tanggal,5,2);
$tgl1= substr($tanggal,8,2);
$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
switch($bln1){
	case '01':
	$bln='Jan';break;
	case '02':
	$bln='Peb';break;
	case '03':
	$bln='Mar';break;
	case '04':
	$bln='Apr';break;
	case '05':
	$bln='May';break;
	case '06':
	$bln='Jun';break;
	case '07':
	$bln='Jul';break;
	case '08':
	$bln='Aug';break;
	case '09':
	$bln='Sep';break;
	case '10':
	$bln='Oct';break;	
	case '11':
	$bln='Nop';break;
	case '12':
	$bln='Dec';break;	}

$tanggalnya="$tgl1-$bln-$thn1";
return $tanggalnya;
}


function my2date($tglku)
{
$tgl1 = substr($tglku,0,2);
$bln1 = substr($tglku,3,2);
$thn1= substr($tglku,6,4);
$my="$thn1-$bln1-$tgl1";
return $my;
}
function ymd2dmy($tanggal)
{
$thn1 = substr($tanggal,0,4);
$bln1 = substr($tanggal,5,2);
$tgl1= substr($tanggal,8,2);
$tanggalnya="$tgl1-$bln1-$thn1";
return $tanggalnya;
}


$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");
										
								
?>
<?php
function trimString($input, $string){
        $input = trim($input);
        $startPattern = "/^($string)+/i";
        $endPattern = "/($string)+$/i";
        return trim(preg_replace($endPattern, '', preg_replace($startPattern,'',$input)));
}
?>