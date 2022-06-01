<?php
	// header("Content-Type: application/vnd.openxmlformats officedocument.spreadsheetml.sheet");
	// header("Content-Dispotition: attachment; filename=".$title.".xls");
	// header("Pragma: no-cache");
	// header("Expires: 0");
header("Content-type: application/vnd.openxmlformats officedocument.spreadsheetml.sheet");

header("Content-Disposition: attachment; filename=$title.xls");

header("Pragma: no-cache");

header("Expires: 0");
?>

<style type="text/css">
.table-data{
 width: 100%;
 border-collapse: collapse;
 }
 .table-data tr th,
 .table-data tr td{
 border:1px solid black;
font-size: 11pt;
 font-family:Verdana;
 padding: 10px 10px 10px 10px;
 }
 .table-data th{
 background-color:grey;
 }
 h3{
 font-family:Verdana;
 }
</style>

<h3><center>Laporan Data Anggota</center></h3>
    <br/>
    <table class="table-data" border="1">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col" nowrap>Member Sejak</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = 1;
                foreach ($anggota as $a) { ?>
                    <tr>
                        <th scope="row"><?= $i++; ?></th>
                            <td><?= $a['nama']; ?></td>
                            <td><?= $a['email']; ?></td>
                            <td><?= date('d F Y', $a['tanggal_input']); ?></td>
                        <td>
                            <?= $a['image']; ?>
                        </td>
                    </tr>
            <?php
            }
            ?>
        </tbody>
    </table>