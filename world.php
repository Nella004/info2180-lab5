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
  $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE ?");
  $stmt->execute(["%$country%"]);
  $results = $stmt->fetchAll();
  foreach ($results as $row) {
      echo "<li>" . $row['name'] . " - " . $row['head_of_state'] . "</li>";
  }
}

if (count($results) > 0) {
  echo "<table>
          <thead>
              <tr>
                  <th>Country</th>
                  <th>Continent</th>
                  <th>Year of Independence</th>
                  <th>Head of State</th>
              </tr>
          </thead>
          <tbody>";
  foreach ($results as $row) {
      echo "<tr>
              <td>{$row['name']}</td>
              <td>{$row['continent']}</td>
              <td>{$row['independence_year']}</td>
              <td>{$row['head_of_state']}</td>
          </tr>";
  }
  echo "</tbody>
      </table>";
} else {
  echo "No results found.";
}

if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities' && isset($_GET['country'])) {
  $country = $_GET['country'];
  $stmt = $conn->prepare(
      "SELECT cities.name, cities.district, cities.population 
       FROM cities 
       JOIN countries ON cities.country_code = countries.code 
       WHERE countries.name LIKE ?"
  );
  $stmt->execute(["%$country%"]);
  $results = $stmt->fetchAll();
  
  if (count($results) > 0) {
      echo "<table>
              <thead>
                  <tr>
                      <th>City</th>
                      <th>District</th>
                      <th>Population</th>
                  </tr>
              </thead>
              <tbody>";
      foreach ($results as $row) {
          echo "<tr>
                  <td>{$row['name']}</td>
                  <td>{$row['district']}</td>
                  <td>{$row['population']}</td>
              </tr>";
      }
      echo "</tbody>
          </table>";
  } else {
      echo "No cities found for this country.";
  }
}

?>