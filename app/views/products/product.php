<?php
/**
 * @var array $product - Продукт
 * @var string $role - Роль пользователя
 * @var array $sidebar - Меню
 */

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
                <h3 class="text-center"><?= $product['title'] ?></h3>
                <div>
                    <h4>Описание</h4>
                    <p><?= $product['description'] ?></p>
                </div>
                <div><span class="text-muted">Стоимость:</span> <b><?= $product['cost'] ?></b></div>
                <div><span class="text-muted">Количество:</span> <b><?= $product['count'] ?></b></div>
            </div>
            <?php if ($role === UserOperations::RoleAdmin) : ?>
                <div class="cabinet_sidebar">
                    <div class="menu_box">
                        <ul>
                            <li><a href="/products/update?id=<?= $_GET['id'] ?>">Изменить</a></li>
                            <li><a href="/products/delete?id=<?= $_GET['id'] ?>">Удалить</a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>


</div>
