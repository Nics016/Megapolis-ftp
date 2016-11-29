<?php

	$table_price = $table_data['price']; // переменная наименовании цены типо "за метр" и тд
	$table_attrs = unserialize($table_data['attributes']); // а тут имена аттрибутов таблицы
?> 
<table class="table-text-elements" name="<?= $table_data['name']; ?>">
	<tbody id="table-tbody">
	<tr>
		<th data-pos="image"></th>
		<th data-pos="name">Название</th>
		
		<?php for ( $i = 0; $i < count($table_attrs); $i++ ): ?>

			<th data-pos="<?= $i ?>"><?= $table_attrs[$i] ?></th>	
		<?php endfor; ?>

		<th data-pos="price">Цена <span><?= $table_price //наименование цены, вставляй, как хочешь?></span></th>
		<th>Количество</th>
		<th>Сумма</th>
		<th data-pos="action"></th>

	</tr>
	

	<?php 
	for ( $i = 0; $i < count($tovars); $i++ ): 

		$tovar = $tovars[$i]; //тут я сохраняю ассоциативный массив текущей итерации
		$attrs = unserialize($tovar['attributes']); // тут массив аттрибутов они должны выводится строго по порядку
	?>


	<tr data-tovar-id="<?= $tovar['ID'] ?>">
		<td>
			<?php $img_url = $tovar['image_link']; // url картинки товара?>
			<img class="table-text-elements-pic" src="<?php echo $img_url; ?>">
		</td>

		<td>
			<?= $tovar['name'] //вывожу имя ?>
		</td>

		<?php for( $x = 0; $x < count($attrs); $x++ ): ?> 
			<td>
				<span data-table-attr="<?= $x ?>"><?= $attrs[$x] //значение аттрибута?></span>
			</td>
		<?php endfor; ?>

		<td>
			<span data-type="tovar-price"><?= $tovar['price'] ?></span> руб.
		</td>

		<td><input type="number" data-type="tovar-num" class="table-text-elements-num" value="1" min="1" max="10000" step="1"></td>

		<td> <span data-type="tovar-sum"><?= $tovar['price'] ?></span> руб.</td>

		<td>
			<a href="#" data-type="add-cart" class="table-text-elements-cart">
				В корзину
			</a>
		</td>
	</tr>
	
	<?php endfor; ?>

	</tbody>
</table>
