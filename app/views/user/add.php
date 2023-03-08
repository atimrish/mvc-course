<?php

/**
 * @var array $error_msg - Ошибки валидации
 * @var array $sidebar
 * @var array $user
 */
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
                <h3 class="mb-5">Добавить пользователя</h3>
                <form action="" method="post" name="form_add_user">
                    <div class="mb-3">
                        <label class="form-label" for="name">Имя</label>
                        <input
                            class="form-control
                                <?php if (!empty($error_msg['name'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                            type="text"
                            name="user[name]"
                            id="name"
                            value="<?= !empty($user['name']) ? $user['name'] : '' ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="login">Логин</label>
                        <input
                            class="form-control
                                <?php if (!empty($error_msg['login'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                            type="text"
                            name="user[login]"
                            id="login"
                            value="<?= !empty($user['login']) ? $user['login'] : '' ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Пароль</label>
                        <input
                            class="form-control
                                <?php if (!empty($error_msg['password'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                            type="password"
                            name="user[password]"
                            id="password"
                            value="<?= !empty($user['password']) ? $user['password'] : '' ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirm">Подтвердите пароль</label>
                        <input
                            class="form-control
                                <?php if (!empty($error_msg['password_confirm'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                            type="password"
                            name="user[password_confirm]"
                            id="password_confirm"
                            value="<?= !empty($user['password_confirm']) ? $user['password_confirm'] : '' ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="is_admin" class="form-label">Это администратор</label>
                        <select name="user[is_admin]" id="is_admin" class="form-select">
                            <option value="0" selected>Нет</option>
                            <option value="1">Да</option>
                        </select>
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            name="btn_add_user"
                            value="1"
                        >Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>