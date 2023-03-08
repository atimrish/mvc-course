<?php

/**
 * @var array $error_msg
 * @var array $sidebar
 */
echo '<pre>';
print_r($_POST);
print_r($error_msg);
echo '</pre>';

?>
<div class="page">
    <div class="container">
        <div class="cabinet_wrapped">
            <div class="cabinet_sidebar">
                <?php if (!empty($sidebar)) : ?>
                    <div class="menu_box">
                        <ul>
                            <?php foreach ($sidebar as $link) : ?>
                                <li>
                                    <a href="<?= $link['link'] ?>"><?= $link['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="cabinet_content">
                <h3 class="mb-5">Оформление заказа</h3>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="surname" class="form-label">Фамилия</label>
                        <input
                                type="text"
                                class="form-control <?= !empty($error_msg['surname']) ? 'is-invalid' : '' ?>"
                                name="purchase[surname]"
                                id="surname"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input
                                type="text"
                                class="form-control <?= !empty($error_msg['name']) ? 'is-invalid' : '' ?>"
                                name="purchase[name]"
                                id="name"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="patronymic" class="form-label">Отчество</label>
                        <input
                                type="text"
                                class="form-control <?= !empty($error_msg['patronymic']) ? 'is-invalid' : '' ?>"
                                name="purchase[patronymic]"
                                id="patronymic"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                                type="email"
                                class="form-control <?= !empty($error_msg['email']) ? 'is-invalid' : '' ?>"
                                name="purchase[email]"
                                id="email"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input
                                type="tel"
                                class="form-control <?= !empty($error_msg['phone']) ? 'is-invalid' : '' ?>"
                                name="purchase[phone]"
                                id="phone"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Адрес</label>
                        <input
                                type="text"
                                class="form-control <?= !empty($error_msg['address']) ? 'is-invalid' : '' ?>"
                                name="purchase[address]"
                                id="address"
                        >
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" name="btn_purchase" value="1">Оформить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

