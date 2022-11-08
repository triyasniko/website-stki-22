<?php
include "function_tala_stopword.php";
include "function_stemming.php";
include "koneksi.php";
$conn = connect();

$kalimat_awal="Menko Polhukam Mahfud Md menyatakan pengelolaan dana otonomi khusus (otsus) Papua tidak beres. Karenanya, dana otsus dinaikkan menjadi 2,25 persen dari Dana Alokasi Khusus APBN";
echo "<h1> Kalimat Awal </h1>";
echo $kalimat_awal;
echo "<br><br>";
$kalimat=strtolower($kalimat_awal);
$kalimat_remove_karakter=preg_replace("/[^A-Za-z0-9\  ]/", "", $kalimat);
echo "<h1> Tokenizing </h1>";
echo "<h4> Mengecilkan dan menghilangkan karakter khusus </h4>";
var_dump($kalimat_remove_karakter);
echo "<br><br>";

$kalimat_remove_angka=preg_replace('/\d+/u', '', $kalimat_remove_karakter);
echo "<h4> Menghilangkan angka </h4>";
var_dump($kalimat_remove_angka);
echo "<br><br>";
$token_kalimat=explode(' ', $kalimat_remove_angka);
$token_kalimat2=array_filter($token_kalimat, function($value) { return !is_null($value) && $value !== ''; });

// var_dump($kalimat);
// display $token_kalimat as table
echo "<h4> Hasil akhir Tokenisasi</h4>";
echo "<table border='1'>";
echo "<tr><th> No </th><th> Token </th></tr>";
$no=1;
foreach ($token_kalimat2 as $token) {
    echo "<tr><td>".$no."</td><td>".$token."</td></tr>";
    $no++;
}
echo "</table>";

// var_dump($token_kalimat);
echo"<br><br>";

echo "<h1>Filtering</h1>";
$tala_word=tala_stopword();
?>
<h4> Tala Stopword </h4>
<table border='1'>
    <tbody style="height: 100px; overflow-y: scroll;">
    <tr><th> No </th><th> Kata </th></tr>
    <?php
    $no=1;
    foreach ($tala_word as $tw) {
        echo "<tr><td>".$no."</td><td>".$tw."</td></tr>";
        $no++;
    }
    ?>
    </tbody>
</table>
<br><br>
<?php
$kalimat_filtering=array_diff($token_kalimat, $tala_word);
$kalimat_filtering2=array_filter($kalimat_filtering, function($value) { return !is_null($value) && $value !== ''; });
echo "<h4> Hasil Filtering </h4>";
// var_dump($kalimat_filtering);
// display $kalimat_filtering as table
echo "<table border='1'>";
echo "<tr><th> No </th><th> Kata </th></tr>";
$no=1;
foreach ($kalimat_filtering2 as $kf) {
    echo "<tr><td>".$no."</td><td>".$kf."</td></tr>";
    $no++;
}
echo "</table>";

// stemming process from $kalimat_filtering2
echo "<br><br>";
echo "<h1> Stemming </h1>";
$stemming=array();
foreach ($kalimat_filtering2 as $kf) {
    $stemming[]=stem($kf);
}
echo "<h4> Hasil Stemming </h4>";
var_dump($stemming);
// display $stemming as table
echo "<table border='1'>";
echo "<tr><th> No </th><th> Kata </th></tr>";
$no=1;
foreach ($stemming as $st) {
    echo "<tr><td>".$no."</td><td>".$st."</td></tr>";
    $no++;
}
echo "</table>";

?>