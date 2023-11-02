<!DOCTYPE html>
<meta charset="utf8">
<html>
    <?php
        session_start();
        $connection = mysqli_connect ('127.0.0.1', 'root', '');
        if (!$connection)
        {
            exit('Нет подключения к БД');
        }
        function menulist ( $val)
        {
            $connection = mysqli_connect ('127.0.0.1', 'root', '', "$val");
            if (!$connection)
            {
                exit('Нет подключения к БД');
            }

            mysqli_query($connection, "USE '$val'");
            $result = mysqli_query($connection, "SHOW TABLES");
            while ($row = mysqli_fetch_row($result))
            {
                foreach($row as $val1)
                {
                    ?><table border="0">
                        <tr>
                            <td style="text-indent: 18px; font-size: 17px">
                                <? print $val1; ?>
                            </td>
                        </tr>
                    </table>
            <?
                }
            }
            mysqli_close($connection);
        }
   ?>
    <style>
        content
        {
            background: #c5c5c5;
            display: block;
            box-sizing: content-box;
            width: 74%;
            height: 90%;
            position: absolute;
            right: 0%;
            top: 10%;
            text-align: center;
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
            width: 74%;
            height: 5%;
            position: absolute;
            right: 0%;
        }
		Menutop
        {
            background: #a2a199;
            display: inline-block;
            width: 74%;
            height: 5%;
            position: absolute;
            right: 0%;
			top: 5%;
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
        .del
        {
            background: #c5c5c5;
            border: 0px;
            padding: 12px 20px;
            float: right;
            font-size: large;
        }
        .del:hover
        {
            background-color: #c5c5c5;
            color: red;
        }
        .db
        {
            background: #c5c5c5;
            border: 0px;
            padding: 12px 20px;
            float: top;
            font-size: 16px;
            display:block;
            position: relative;
            margin:0 auto;
        }
        .db:hover
        {
            background-color: #c5c5c5;
            color: white;
        }
    </style>
    <head>
        <title>8 лабораторная работа</title>
    </head>
    <body style="margin: 0; overflow-y: scroll; background: #c5c5c5;" >
            <top>
                <form method="POST">
                    <input name="DATABASES" type="submit" class="submit" value="Базы данных" formaction="db.php"/>
                    <!--<input name="SQL" type="submit" class="submit" value="  SQL  " formaction="NOsql.php"/>-->
                    <input name="LINK" type="submit" class="submit" value="Информация" formaction="connection.php" />
                </form>
            </top>
			<Menutop>
				<form>
					<input name="TopSites" type="submit" class="submit" value="Топ 10 самых посещаемых сайтов " formaction="TopSites.php"/>
					<input name="InfoToday" type="submit" class="submit" value="Информация о посещениях за сегодняшний день" formaction="InfoToday.php" />
					<input name="AddUser" type="submit" class="submit" value="Добавить пользователя" formaction="AddUser.php" />
					<input name="AddReason" type="submit" class="submit" value="Добавить причину посещения" formaction="AddReason.php" />
				</form>
			</Menutop>
            <leftmenu>
                <table border="0">
                    <tr>
                        <td><a href="index.php"><img src="logo.gif" title="Вернуться на главную страницу"> </a></td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                            <div style="font-size: xx-large; text-align: center">Меню</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                            <form method="post">
                                <input name="create" type="submit" class="submit" style="background: #a2a199; font-size: large" value="Создать базу данных" formaction="create_db.php">
                            </form>
                            <br>
                        </td>
                    </tr>
                    <?php
                    $i = 0;
                    $j = 0;
                    $result = mysqli_query($connection, 'SHOW DATABASES');
                    while ($row = mysqli_fetch_row($result))
                    {
                        $_SESSION[$i] = $row;
                        $i++;
                    }
                    while ($j<$i)
                    {
                        ?>
                        <tr>
                            <td>
                                <details>
                                    <summary style="font-size: large"><?
                                        $_SESSION['tables'] = join('', $_SESSION[$j]);
                                        print join('', $_SESSION[$j]);
                                        ?></summary>
                                    <a>
                                        <?
                                        menulist( join('', $_SESSION[$j]));
                                        ?>
                                    </a>
                                </details>
                            </td>
                        </tr>
                        <?
                        $j++;
                    }?>
                </table>
            </leftmenu>
            <content>
                <br><br><br><br><br>
                <div style="text-align:center; URW Chancery L, cursive; color: black; font-weight: 900; font-stretch: expanded; font-style: italic; font-size: xxx-large">   </div>
                <div style="text-align:center; URW Chancery L, cursive; color: black; font-weight: 900; font-stretch: expanded; font-style: italic; font-size: 90px"> Веб-интерфейс <br> для работы <br> с базами данных </div>
                <br><br><br><br><br><br><br><br><br>
                <div style="text-align:center; URW Chancery L, cursive; color: black; font-weight: 900; font-stretch: expanded; font-style: italic; font-size: x-large"> Выберите базу данных или желаемое действие </div>
            </content>
    </body>
</html>