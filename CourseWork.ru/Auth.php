 <?php

/*Соединяеся с базой и делаем выборку из таблицы*/

$db = mysqli_connect("127.0.0.1", "root", "", "coursework");
$result_select = mysqli_query($db, "SELECT city from work.Adresses");

/*Выпадающий список*/

echo "<select name = ''>";
while($object = mysqli_fetch_object($result_select)){

echo "<option value = '$object->city' > $object->city </option>";

}

echo "</select>";

?>