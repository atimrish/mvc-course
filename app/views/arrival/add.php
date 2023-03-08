<?php

/**
 * @var array $sidebar
 * @var array $products
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
                <h3>Добавление прихода товара</h3>
                <form action="" method="post">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Добавить в приход</th>
                                <th scope="col">Название</th>
                                <th scope="col">Количество</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="arrival[<?= $product['product_id'] ?>][included]"
                                            id="item_<?= $product['product_id'] ?>"
                                            aria-label="<?= $product['product_id'] ?>"
                                            value="1"
                                        >
                                    </td>
                                    <td><?= $product['product_title'] ?></td>
                                    <td>
                                        <input
                                            class="form-control-sm"
                                            type="number"
                                            name="arrival[<?= $product['product_id'] ?>][count]"
                                            id="count"
                                            aria-label="count"
                                            min="1"
                                        >
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="mb-3">
                        <button class="btn btn-primary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>