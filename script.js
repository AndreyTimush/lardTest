$(document).ready(function () {
    function validateForm() {
        let errors = [];
        let companyName = $('#companyName').val();
        let inn = $('#inn').val();
        let phone = $('#phone').val();
        let email = $('#email').val();

        if (!companyName) errors.push("Название компании обязательно.");
        if (!inn) errors.push("ИНН обязательно.");
        if (!phone) errors.push("Телефон обязателен.");
        if (!email) errors.push("Email обязателен.");

        if (!inn.match(/^\d{10}$/)) {
            errors.push("ИНН должен состоять из 10 цифр.");
        }

        if (!phone.match(/^8\d{10}$/)) {
            errors.push("Телефон должен начинаться с 8 и содержать 10 цифр.");
        }

        if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            errors.push("Некорректный email.");
        }

        return errors;
    }

    function loadCompanies() {
        $.ajax({
            url: 'process.php',
            method: 'GET',
            success: function (response) {
                let companies = JSON.parse(response);
                let tableBody = $('#companiesTable tbody');
                tableBody.empty();

                companies.forEach(function (company) {
                    tableBody.append(`
                        <tr>
                            <td>${company.company_name}</td>
                            <td>${company.inn}</td>
                            <td>${company.phone}</td>
                            <td>${company.email}</td>
                        </tr>
                    `);
                });
            },
            error: function (xhr, status, error) {
                console.error("Ошибка при загрузке данных: ", error);
            }
        });
    }

    $('#registrationForm').on('submit', function (e) {
        e.preventDefault();

        let errors = validateForm();
        if (errors.length > 0) {
            $('#message').html('<div style="color: red;">' + errors.join('<br>') + '</div>');
        } else {
            console.log("отправка данных на сервер");
            $.ajax({
                url: 'process.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#message').html('<div style="color: green;">Регистрация успешна!</div>');
                    loadCompanies();
                },
                error: function (xhr, status, error) {
                    $('#message').html('<div style="color: red;">Ошибка при регистрации.</div>');
                }
            });
        }
    });

    loadCompanies();
});