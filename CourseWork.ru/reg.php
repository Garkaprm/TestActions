<!DOCTYPE html>
<meta charset="utf8">
<html>
    <?php
	date_default_timezone_set('Asia/Yekaterinburg');
        function Visit()
        {
			session_start();
					$con = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
					if (!$con)
					{
						exit('Нет подключения к БД');
					}
			echo "Выберите ФИО из списка (можно начать вводить начальные символы для поиска)";
            $result = mysqli_query($con, "SELECT id, fio FROM usersinfo");
				/*Выпадающий список*/
				echo "<form method='post'>";
				echo "<select name = 'fio'>";
				while($object = mysqli_fetch_object($result)){
				echo "<option value = '$object->id' > $object->fio </option>";
				}
				echo "</select>";
				echo "<br><br>";
			echo "Выберите цель посещения компьютерного класса <br>";	
			$result = mysqli_query($con, "SELECT id, reason FROM reasonwork");
				/*Выпадающий список*/
				echo "<select name = 'reason'>";
				while($object = mysqli_fetch_object($result)){
				echo "<option value = '$object->id' > $object->reason </option>";
				}
				echo "</select>";
				echo "<br><br>";				
				echo "<input type='submit' name='send'/>";
				echo "</form>";
				mysqli_close($con);	
        }
   ?>
    <style>
        content
        {
            background: #c5c5c5;
            display: block;
            box-sizing: content-box;
            width: 90%;
            height: 92%;
            position: absolute;
            right: 0%;
            top: 5%;
			left: 10%;
            text-align: left;
			font-size: 18px;
        }
        leftmenu
        {
            background: #a2a199;
            display: block;
            width: 25%;
            min-height: 100%;
            position: fixed;
            padding-left: 1%;
            left: 0%;
            top: 0%;
        }
        top
        {
            background: #a2a199;
            display: inline-block;
            width: 100%;
            height: 5%;
            position: absolute;
            right: 0%;
        }
        .submit
        {
            background: #a2a199;
            border: 0px;
            padding: 12px 20px;
            float: left;
            font-size: 14px;
        }
        .submit:hover
        {
            background-color: #c5c5c5;
            color: white;
        }
    </style>
    <head>
        <title>Курсовая работа</title>
    </head>
    <body style="margin: 0; overflow-y: scroll; background: #c5c5c5;" >
            <top>
                <div style="text-align:center; URW Chancery L, cursive; color: black; font-weight: 900; font-stretch: expanded; font-style: italic; font-size: 30px"> Для использования браузера введите Ваши данные </div>
            </top>
    
            <content>
				<br><br><br><br><br><br><br>
                <?php
				session_start();
					$conn = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
					if (!$conn)
					{
						exit('Нет подключения к БД');
					}
				Visit();
				if (isset($_POST['send'])) {	
					$fio = $_POST['fio'];
					$reason = $_POST['reason'];
					$currDate = date('d.m.Y H:i:s');
					$date = date('Y.m.d H:i:s');
					$sql= "INSERT INTO visit (UserID, ReasonID, RegTime) VALUES ($fio,$reason,'$date')";
					mysqli_query($conn,$sql);
					header('Location: https://www.google.com/');
					$strCommand ="ChromeHistoryView.exe /sxml history.xml /UseVisitTimeFilter 1 /VisitTimeFilter 1 /sort ~2";
					Exec($strCommand);	
					$xml = simplexml_load_file("C:\Soft\Open Server\OpenServer\domains\CourseWork.ru\history.xml");
					$result = mysqli_query($conn, "SELECT MAX(id)-1 as id FROM visit");
						foreach ($result as $row) {
							$id = $row['id'];
						}		
					$result = mysqli_query($conn, "SELECT RegTime FROM visit WHERE id = $id");
						foreach ($result as $row) {
							$RegTime = $row['RegTime'];
						}
					foreach ($xml as $item) {
						if (preg_match("/https/i", $item->url)) {
							preg_match('@^(?:https://)?([^/]+)@i', $item->url, $matches);
							$host = $matches[1];
						} else {
							preg_match('@^(?:http://)?([^/]+)@i', $item->url, $matches);
							$host = $matches[1];
						}
						$timestamp = date('Y.m.d H:i:s', strtotime($item->visited_on));
						$sql= "INSERT INTO history (adress, VisitTime) VALUES ('$host','$timestamp') ON DUPLICATE KEY UPDATE VisitTime=VisitTime";
						mysqli_query($conn,$sql);
					}
					$sql= "INSERT INTO sites (adress, CountVisit) SELECT h.adress,1 
								FROM history as h where h.VisitTime BETWEEN '$RegTime' and NOW() ON DUPLICATE KEY UPDATE CountVisit=CountVisit+1";
						mysqli_query($conn,$sql);
					$sql= "INSERT INTO siteVisit (visitID,fio,siteID,VisitTime) SELECT v.id, v.UserID, s.id, h.VisitTime 
							FROM visit AS v JOIN history as h ON h.VisitTime BETWEEN v.RegTime and NOW() JOIN sites AS s ON s.adress = h.adress WHERE v.id = $id";
						mysqli_query($conn,$sql);
				};
				mysqli_close($conn);	
				?>
            </content>
    </body>
</html>