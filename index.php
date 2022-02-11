<html>
<body>
<?php

require 'config.php';
error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$stmt = $conn->prepare("SELECT COUNT(id) FROM owners ");
$stmt->execute();
$stmt->bind_result($totalOwners);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(id) FROM dogs ");
$stmt->execute();
$stmt->bind_result($totalDogs);
$stmt->fetch();
$stmt->close();


$stmt = $conn->prepare("SELECT COUNT(id) FROM events ");
$stmt->execute();
$stmt->bind_result($totalEvents);
$stmt->fetch();
$stmt->close();


echo "<h1>Welcome to Poppleton Dog Show! This year $totalOwners owners entered $totalDogs dogs in $totalEvents events!</h1>";


$sqlTopDogs = "
SELECT dogs.name, dogs.id,breeds.name AS breeds, COUNT(entries.dog_id) , ROUND(AVG(entries.score), 1), owners.name as owners, owners.email
, owners.id as ownID
FROM entries
INNER JOIN dogs ON entries.dog_id = dogs.id
INNER JOIN breeds ON dogs.breed_id = breeds.id
INNER JOIN owners on dogs.owner_id = owners.id
WHERE entries.score >= (SELECT avg(entries.score) FROM entries)
GROUP BY entries.dog_id
HAVING COUNT(entries.dog_id) >1 
ORder BY AVG(entries.score) DESC
LIMIT 10
".$_GET['id'];

$result = mysqli_query($conn, $sqlTopDogs);


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo  "<p align='left'><b> Dogs Name: </b>". $row["name"]. "<b>  Dogs Breed: </b>" .
            $row["breeds"]. "<b>  Score: </b>" . $row["ROUND(AVG(entries.score), 1)"]. " <b> Owners </b>";
        echo "<a href= ownerPage.php?id=$row[ownID]>". $row['owners']. "</a> ";


            echo "<b>Email: </b>" ." <a href='mailto:" . $row['email'] . " '>"  . $row['email']. "</a>" ;

    }
} else {
    echo "0 results";
}
?>
</body>
</html>
