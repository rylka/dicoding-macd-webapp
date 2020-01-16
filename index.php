<html>

<head>
    <Title>Registration Form</Title>
    <style type="text/css">
        body {
            background-color: #fff;
            /* border-top: solid 10px #000; */
            color: #333;
            font-size: .85em;
            margin: 20;
            padding: 20;
            font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
        }

        h1,
        h2,
        h3 {
            color: #000;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        h1 {
            font-size: 2em;
        }

        h2 {
            font-size: 1.75em;
        }

        h3 {
            font-size: 1.2em;
        }

        table {
            margin-top: 0.75em;
        }

        th {
            font-size: 1.2em;
            text-align: left;
            border: none;
            padding-left: 0;
        }

        td {
            padding: 0.25em 2em 0.25em 0em;
            border: 0 none;
        }

        #input1 {
            margin-left: 50px;
            margin-right: 34px;
        }
    </style>
</head>

<body>
    <h1>Form Input Data Mahasiswa</h1>
    <p>isi NPM, Nama, dan Prodi. Kemudian klik <strong>Submit</strong> untuk input data.</p>
    <form method="post" action="index.php" enctype="multipart/form-data">
        NPM&ensp;&ensp;: <input type="text" name="npm" id="npm" /></br></br>
        Nama&nbsp;&nbsp;: <input type="text" name="nama" id="nama" /></br></br>
        Prodi&ensp;&nbsp;: <input type="text" name="prodi" id="prodi" /></br></br>
        <input id="input1" type="submit" name="submit" value="Submit" />
        <input type="submit" name="load_data" value="Load Data" />
    </form>
    <?php
    $host = "dicoding-macd.database.windows.net";
    $user = "dicodingmacd";
    $pass = "Dcamgnidocid*";
    $db = "dicoding-macd-db";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $npm = $_POST['npm'];
            $nama = $_POST['nama'];
            $prodi = $_POST['prodi'];
            $tgl = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO MahasiswaDB (npm, nama, prodi, tgl) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $npm);
            $stmt->bindValue(2, $nama);
            $stmt->bindValue(3, $prodi);
            $stmt->bindValue(4, $tgl);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Data berhasil di input!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM MahasiswaDB";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll();
            if (count($registrants) > 0) {
                echo "<h2>Data Mahasiswa:</h2>";
                echo "<table>";
                echo "<tr><th>NPM</th>";
                echo "<th>Nama</th>";
                echo "<th>Prodi</th>";
                echo "<th>Tanggal</th></tr>";
                foreach ($registrants as $registrant) {
                    echo "<tr><td>" . $registrant['npm'] . "</td>";
                    echo "<td>" . $registrant['nama'] . "</td>";
                    echo "<td>" . $registrant['prodi'] . "</td>";
                    echo "<td>" . $registrant['tgl'] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>Tidak ada data.</h3>";
            }
        } catch (Exception $e) {
            echo "Failed: " . $e;
        }
    }
    ?>
</body>

</html>