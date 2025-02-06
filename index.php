<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>CRUD приложение</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: auto;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {background-color: #f5f5f5;}
        input[type=text], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        button:hover {
            opacity: 0.8;
        }
        form {
            border: 1px solid #ccc;
            padding: 16px;
            margin: 16px auto;
            width: 40%;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
<?php /*pa([$_SERVER]);*/ ?>
<h1 style="text-align: center;">Список контактов</h1>
<div id="contactForm" style="display:none;">
    <form id="addEditForm">
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name"><br>
        <span class="error" id="nameError"></span>

        <label for="phone">Телефон:</label><br>
        <input type="text" id="phone" name="phone"><br>
        <span class="error" id="phoneError"></span>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email"><br>
        <span class="error" id="emailError"></span>

        <button type="submit" id="saveButton">Сохранить</button>
        <button onclick="closeForm()">Закрыть</button>
    </form>
</div>
<div style="width: 80%; position: relative; left: 10%;">
    <button onclick="f = document.getElementById('contactForm'); f.style.display = f.style.display === 'none' ? '' : 'none'; this.innerHTML = (this.innerHTML === 'Добавить') ? 'Свернуть' : 'Добавить'">Добавить</button>
</div>
<table id="contactTable">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Действия</th>
    </tr>
</table>
<script type="text/javascript" src="script.js"></script>
</body>
</html>