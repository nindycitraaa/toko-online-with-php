<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <style type="text/css">
        * {
            font-family: "Trebuchet MS";
        }

        h1 {
            text-transform: uppercase;
            color: black;
        }

        table {
            border: solid 1px #DDEEEE;
            border-collapse: collapse;
            border-spacing: 0;
            width: 80%;
            margin: 10px auto 10px auto;
        }

        table thead th {
            background-color: black;
            border: solid 1px #DDEEEE;
            color: white;
            padding: 10px;
            text-align: left;
            text-decoration: none;
        }

        table tbody td {
            border: solid 1px #DDEEEE;
            color: #333;
            padding: 10px;
            background-color: white;
        }

        a {
            background-color: black;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-size: 12px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
</head>

<body>
    <?php
    // Rupiah Format
    function rupiah($angka)
    {
        $hasil = 'Rp ' . number_format($angka, 0, ",", ".");
        return $hasil;
    }
    //Untuk Memanggil Navbar
    include "navbar.php";
    ?>
    <center>
        <h1 class="mt-4">Data Penjualan</h1>
        <center>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Nama Pelanggan</th>
                        <th>Qty</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "koneksi.php";
                    $qry_detail_transaksi = mysqli_query($koneksi, "select * from detail_transaksi");
                    $qry_penjualan = mysqli_query($koneksi, "select sum(subtotal) as total from detail_transaksi");
                    $data_penjualan = mysqli_fetch_array($qry_penjualan);
                    while ($data_detail_transaksi = mysqli_fetch_array($qry_detail_transaksi)) {
                        $qry_produk = mysqli_query($koneksi, "select * from produk where id_produk = '" . $data_detail_transaksi['id_produk'] . "'");
                        $data_produk = mysqli_fetch_array($qry_produk);
                        $qry_transaksi = mysqli_query($koneksi, "select * from transaksi where id_transaksi = '" . $data_detail_transaksi['id_transaksi'] . "'");
                        $data_transaksi = mysqli_fetch_array($qry_transaksi);
                        $qry_pelanggan = mysqli_query($koneksi, "select * from pelanggan where id_pelanggan = '" . $data_transaksi['id_pelanggan'] . "'");
                        $data_pelanggan = mysqli_fetch_array($qry_pelanggan);
                    ?>
                        <tr>
                            <td><?= $data_produk['nama_produk'] ?></td>
                            <td><?= $data_pelanggan['nama'] ?></td>
                            <td><?= $data_detail_transaksi['qty'] ?></td>
                            <td><?= rupiah($data_detail_transaksi["subtotal"]) ?></td>
                        </tr>
                    <?php //untuk nomor urut terus bertambah 1
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>TOTAL PENDAPATAN</th>
                        <th><?= rupiah($data_penjualan["total"]) ?></th>
                    </tr>
                </tfoot>
            </table>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>