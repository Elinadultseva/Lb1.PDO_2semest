<?php
$dsn = "mysql:host=localhost;dbname=lb_pdo_goods;charset=utf8";
$user = 'root';
$pass = '';

$vendorName = $_GET["vendorName"] ?? null;
$categoryName = $_GET["categoryName"] ?? null;
$pricerange = $_GET["pricerange"] ?? null;

try {
    $dbh = new PDO($dsn, $user, $pass);

    if ($vendorName) {
        $sqlSELECT = "SELECT id_Vendors, v_name, items.name FROM vendors JOIN items ON id_vendors = fid_vendor WHERE v_name = :vendorName";
        $sth = $dbh->prepare($sqlSELECT);
        $sth->bindValue(":vendorName", $vendorName, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr><th>Номер</th><th>Виробник</th><th>Товари</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($result as $item) {  
            echo "<tr>";
            echo "<td>{$item['id_Vendors']}</td>";  
            echo "<td>{$item['v_name']}</td>";  
            echo "<td>{$item['name']}</td>";  
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } elseif ($categoryName) {
        $sqlSELECT = "SELECT id_category, c_name, items.name FROM category JOIN items ON id_category = fid_category WHERE c_name = :categoryName";
        $sth = $dbh->prepare($sqlSELECT);
        $sth->bindValue(":categoryName", $categoryName, PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr><th>Номер</th><th>Категорія</th><th>Товари</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($result as $item) {  
            echo "<tr>";
            echo "<td>{$item['id_category']}</td>";  
            echo "<td>{$item['c_name']}</td>";  
            echo "<td>{$item['name']}</td>";  
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } elseif ($pricerange) {
        list($minPrice, $maxPrice) = explode("-", $pricerange);

        $sqlSELECT = "SELECT id_items, name, price FROM items WHERE price BETWEEN :minPrice AND :maxPrice ORDER BY price ASC";
        $sth = $dbh->prepare($sqlSELECT);
        $sth->bindValue(":minPrice", (int)$minPrice, PDO::PARAM_INT);
        $sth->bindValue(":maxPrice", (int)$maxPrice, PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr><th>Номер</th><th>Товар</th><th>Ціна</th></tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($result as $item) {  
            echo "<tr>";
            echo "<td>{$item['id_items']}</td>";  
            echo "<td>{$item['name']}</td>";  
            echo "<td>{$item['price']}</td>";  
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
?>
