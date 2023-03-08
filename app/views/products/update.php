<?php

/**
 * @var array $product
 * @var array $sidebar
 * @var array $error_msg
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
                <form action="" method="post" name="form_update_product">
                    <div class="mb-3">
                        <label class="form-label" for="title">Название</label>
                        <input
                                class="form-control
                                <?php if (!empty($error_msg['title'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                                type="text"
                                name="product[title]"
                                id="title"
                                value="<?= $product['title'] ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Описание</label>
                        <textarea
                                class="form-control
                                <?php if (!empty($error_msg['description'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                                name="product[description]"
                                id="description"
                                cols="30"
                                rows="10"
                        ><?= $product['description']?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cost">Стоимость</label>
                        <input
                                class="form-control
                                <?php if (!empty($error_msg['cost'])) : ?>
                                    is-invalid
                                <?php endif; ?>"
                                type="number"
                                name="product[cost]"
                                id="cost"
                                value="<?= $product['cost'] ?>"
                        >
                    </div>
                    <div>
                        <button
                                type="submit"
                                class="btn btn-primary"
                                name="btn_update_product"
                                value="1"
                        >Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>