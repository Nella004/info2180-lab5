<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$stmt = $conn->query("SELECT * FROM countries");

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['country'])) {
  $country = $_GET['country'];
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
  $stmt->execute(["%$country%"]);
  $results = $stmt->fetchAll();
  foreach ($results as $row) {
      echo "<li>" . $row['name'] . " - " . $row['head_of_state'] . "</li>";
  }
}

echo "<table>
        <tr>
            <th>Country</th>
            <th>Continent</th>
            <th>Year of Independence</th>
            <th>Head of State</th>
        </tr>";
foreach ($results as $row) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['continent']}</td>
            <td>{$row['independence_year']}</td>
            <td>{$row['head_of_state']}</td>
        </tr>";
}
echo "</table>";

if ($_GET['lookup'] === 'cities') {
  $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population
                          FROM cities JOIN countries ON cities.country_code = countries.code
                          WHERE countries.name LIKE ?");
  $stmt->execute(["%$country%"]);
  $results = $stmt->fetchAll();
  echo "<table>
          <tr>
              <th>City</th>
              <th>District</th>
              <th>Population</th>
          </tr>";
  foreach ($results as $row) {
      echo "<tr>
              <td>{$row['name']}</td>
              <td>{$row['district']}</td>
              <td>{$row['population']}</td>
          </tr>";
  }
  echo "</table>";
}

?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
<?php endforeach; ?>
</ul>
