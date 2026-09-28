<!DOCTYPE html>
<html>

<head>
    <title>Book Details</title>

    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 30px auto;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: lightgray;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

<h2>Book Details</h2>

<?php

$xml = simplexml_load_file(__DIR__ . "/books.xml")
       or die("Error: Cannot load XML file.");

echo "<table>";

echo "<tr>";
echo "<th>Title</th>";
echo "<th>Author</th>";
echo "<th>Year</th>";
echo "<th>Price</th>";
echo "</tr>";

foreach ($xml->book as $book) {

    echo "<tr>";

    echo "<td>" . $book->title . "</td>";
    echo "<td>" . $book->author . "</td>";
    echo "<td>" . $book->year . "</td>";
    echo "<td>" . $book->price . "</td>";

    echo "</tr>";
}

echo "</table>";

?>

</body>

</html>