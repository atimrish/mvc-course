<?php

/**
 * @var array $sidebar
 * @var array $products
 */

$total = 0;

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
                <h3 class="text-center">Продукты</h3>
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Количество</th>
                            <th scope="col">Стоимость</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product ) : ?>
                            <tr>
                                <td><?= $product['product_title'] ?></td>
                                <td>
                                    <form action="/basket/update" method="post" class="d-flex">
                                        <label for="basket_count" class="d-none"></label>
                                        <input
                                                class="form-control-sm w-50"
                                                type="number"
                                                min="1"
                                                max="<?= $product['product_count'] ?>"
                                                name="basket_count"
                                                id="basket_count"
                                                value="<?= $product['in_basket_count'] ?>"
                                        >
                                        <button
                                                type="submit"
                                                value="<?= $product['id'] ?>"
                                                name="update_basket_id"
                                                class="btn btn-sm btn-secondary"
                                        >Изменить</button>
                                    </form>
                                </td>
                                <td><?= $product['product_cost'] ?></td>
                                <td><a href="/products/product?id=<?= $product['product_id'] ?>">К товару</a></td>
                                <td><a class="red" href="/basket/delete?id=<?= $product['id'] ?>">Удалить</a></td>
                            </tr>
                        <?php $total += $product['product_cost'] * $product['in_basket_count']; endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end align-items-center">
                    <div style="margin-right: 20px" class="fs-3">Итого: <?= $total ?></div>
                    <form action="/purchase/form" method="post">
                        <button
                                type="submit"
                                class="btn btn-primary"
                                <?= empty($total) ? 'disabled' : '' ?>
                        >К заказу</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
