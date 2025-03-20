<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация юридического лица</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <h1>Регистрация юридического лица</h1>
    <form id="registrationForm">
        <label for="companyName">Название компании:</label>
        <input type="text" id="companyName" name="companyName" required><br><br>

        <label for="inn">ИНН:</label>
        <input type="text" id="inn" name="inn" required><br><br>

        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Зарегистрировать</button>
    </form>

    <div id="message"></div>

    <h2>Зарегистрированные компании</h2>
    <table id="companiesTable">
        <thead>
            <tr>
                <th>Название компании</th>
                <th>ИНН</th>
                <th>Телефон</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</body>

</html>