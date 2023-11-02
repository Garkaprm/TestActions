<!DOCTYPE html>
<meta charset="utf8">
<html>
    <?php
		date_default_timezone_set('Asia/Yekaterinburg');
        session_start();
        $connection = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
        if (!$connection)
        {
            exit('Нет подключения к БД');
        }
        function menulist ( $val)
        {
            $connection1 = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
            if (!$connection1)
            {
                exit('Нет подключения к БД');
            }

            mysqli_query($connection1, "USE coursework");
            $result = mysqli_query($connection1, "SHOW TABLES");
            while ($row = mysqli_fetch_row($result))
            {
                foreach($row as $val1)
                {
                    ?><table>
                        <tr>
                            <td style="text-indent: 18px; font-size: 17px">
                                <? print $val1; ?>
                            </td>
                        </tr>
                    </table>
            <?
                }
            }
            mysqli_close($connection1);
        }
        function sql ($query)
        {
            $connection1 = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
            if (!$connection1)
            {
                exit('Нет подключения к БД');
            }
            $result = mysqli_query($connection1, "$query");
            $count = 1;
            while ($row = mysqli_fetch_row($result))
            {
                print '<tr>';
                foreach($row as $val1)
                {
                    print '<td style="padding: 7px; border: 1px solid #a2a199;">';
                    print $val1." ";
                    print '</td>';
                    if ($count == mysqli_num_fields($result))
                    {
                        print '</tr>';
                        $count = 0;
                    }
                    $count++;
                }
            }
            mysqli_close($connection1);
        }
        function field ($query)
        {
            $connection1 = mysqli_connect ('127.0.0.1', 'root', '', 'coursework');
            if (!$connection1)
            {
                exit('Нет подключения к БД');
            }
            $result = mysqli_query($connection1, "$query");
            print '<tr>';
            while ($row = mysqli_fetch_field($result))
            {
                foreach($row as $val1)
                {
                    print '<th style="padding: 7px; border: 1px solid #a2a199; background: #a2a199;">';
                    print $val1;
                    print '</th>';
                    break;
                }
            }
            print '</tr>';
            mysqli_close($connection1);
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
                <form>
                    <input name="DATABASES" type="submit" class="submit" value="Базы данных" formaction="db.php"/>
                    <input name="SQL" type="submit" class="submit" value="  SQL  " formaction="sql.php" />
                    <input name="LINK" type="submit" class="submit" value="Информация" formaction="connection.php"/>
                    <input name="TRIGGER" type="submit" class="submit" value=" Триггеры " formaction="triggers.php" />
                    <input name="VIEW" type="submit" class="submit" value=" Представления " formaction="view.php" />
                    <input name="PROCEDURE" type="submit" class="submit" value="Хранимые процедуры" formaction="procedure.php"/>
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
                                    <summary style="font-size: large"><? print join('', $_SESSION[$j]); ?></summary>
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
                <br>
                <p style="text-align: center"><b>Информация о посещениях сайтов за последние сутки:</b></p><hr><br>
                <?php
						$oldDate = date('Y.m.d H:i:s',strtotime('-1 days'));
                        $sql = "select u.fio as 'ФИО', u.zach as '№ зач.книги', r.reason as 'Цель работы', s.adress as 'Сайт', sv.VisitTime as 'Дата посещения' 
						from SiteVisit as sv join sites as s on s.id = sv.SiteID join usersinfo as u on u.id = sv.fio join visit as vis on vis.id = sv.VisitID 
						join reasonwork as r on r.id = vis.ReasonID where sv.VisitTime > '$oldDate' order by sv.VisitTime desc";
                        $result = mysqli_query($connection, $sql);
                        $count = 1;
                        if ($result != '1')
                        {
                            print '<table style="border-collapse: collapse; margin: auto; ">';
                            field($sql);
                            sql($sql);
                            print '</table>';
                        }
                        else
                        {
                            print "Действие выполнено";
                        }?>
            </content>
    </body>
</html>