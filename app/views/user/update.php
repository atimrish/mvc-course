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
                <h3 class="mb-5">Редактировать пользователя</h3>
                <form action="" method="post" name="form_update_user">
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
                            value="<?= $user['name'] ?>"
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
                            value="<?= $user['login'] ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Новый пароль</label>
                        <input
                            class="form-control
                                <?php if (!empty($error_msg['password'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                            type="password"
                            name="user[password]"
                            id="password"
                            value=""
                        >
                    </div>
                    <div class="mb-3">
                        <label for="is_admin" class="form-label">Это администратор</label>
                        <select name="user[is_admin]" id="is_admin" class="form-select">
                            <option value="0" <?= $user['is_admin'] == '0' ? 'selected' : '' ?>>Нет</option>
                            <option value="1" <?= $user['is_admin'] == '1' ? 'selected' : '' ?>>Да</option>
                        </select>
                    </div>
                    <div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            name="btn_update_user"
                            value="1"
                        >Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>