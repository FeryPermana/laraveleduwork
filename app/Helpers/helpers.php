<?php
function format_tanggal($value)
{
    return date('d M Y', strtotime($value));
}


function hitungRangeTanggal($tanggalAwal, $tanggalAkhir)
{
    $tanggalAwal = new DateTime($tanggalAwal);
    $tanggalAkhir = new DateTime($tanggalAkhir);

    $selisih = $tanggalAwal->diff($tanggalAkhir);

    return $selisih->format('%R%a hari');
}

function cekTanggalKembaliTerlambat($tanggalKembali, $name)
{
    // Tanggal hari ini
    $tanggalHariIni = new DateTime();

    // Membuat objek DateTime untuk tanggal kembali
    $tanggalKembaliObj = new DateTime($tanggalKembali);

    // Menghitung selisih hari antara tanggal kembali dan tanggal hari ini
    $selisih = $tanggalHariIni->diff($tanggalKembaliObj);

    // Mengonversi selisih hari menjadi bilangan bulat
    $selisihHari = $selisih->days;

    return "$name melewati batas waktu $selisihHari hari.";
}
