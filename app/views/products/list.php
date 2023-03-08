<?php
/** @var array $sidebar - Меню */
/** @var string $role - Роль пользователя */

/** @var array $products - Список продуктов */

use app\lib\UserOperations;

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
                            <th scope="col">Стоимость</th>
                            <th scope="col">Количество</th>
                            <th scope="col"></th>
                            <?php if ($role === UserOperations::RoleUser) : ?>
                                <th scope="col"></th>
                            <?php endif; ?>
                            <?php if ($role === UserOperations::RoleAdmin) : ?>
                                <th scope="col"></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $product['product_title'] ?></td>
                                <td><?= $product['product_cost'] ?></td>
                                <td><?= $product['product_count'] ?></td>
                                <td><a href="/products/product?id=<?= $product['product_id'] ?>">Подробнее</a></td>

                                <?php if ($role === UserOperations::RoleUser) : ?>
                                    <td>
                                        <?php if (empty($product['in_basket'])) : ?>
                                            <?php if (!empty($product['product_count'])) : ?>
                                                <a href="/basket/add?id=<?= $product['product_id'] ?>">В корзину</a>
                                            <?php else : ?>
                                                <span>Нет на складе</span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <span class="text-muted">В корзине</span>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>

                                <?php if ($role === UserOperations::RoleAdmin) : ?>
                                    <td><a class="red" href="/products/delete?id=<?= $product['product_id'] ?>">Удалить</a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($role === UserOperations::RoleAdmin) : ?>
                <div class="cabinet_sidebar">
                    <div class="menu_box">
                        <ul>
                            <li><a href="/products/add">Добавить</a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
