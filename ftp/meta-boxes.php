<?php
// подключаем функцию активации мета блока (table_field)
add_action('add_meta_boxes', 'table_field', 1);



function table_field() 
{
	add_meta_box( 'table_field', 'Таблицы товаров', 'table_field_view', ['post', 'page'], 'side', 'high'  );
}

// код блока

function table_field_view($post)
{
?>
	<label for="#product_tables_ids">ID таблиц</label>
	<br><br>
	<input type="text" id="product_tables_ids" name="product_tables_ids" value="<?php echo get_post_meta($post->ID, 'product_tables_ids', true); ?>">

	<input type="hidden" name="table_field_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

//сохрание метаполей
add_action('save_post', 'table_field_update', 0);

function table_field_update($post_id)
{
	if ( !isset($_POST['table_field_nonce']) || !wp_verify_nonce($_POST['table_field_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['product_tables_ids']) ) return false; 

	//все проверили, погнали сохранять

	//для начала заменим все символы кроме цифр на разделитель :
	$data_str = preg_replace('/[^0-9]+/', ':', $_POST['product_tables_ids']);

	//после этого переформируем строчку в массив, если ввели не цифры получим пустоту
	$data = explode(':', $data_str);

	//переберем массив с конца до начала, чтобы ни пропустить ни 1 пустого индекса массива
	for ( $i = count($data) - 1; $i >= 0; $i-- )
	{
	    if ( $data[$i] == '')
	        array_splice($data, $i, 1);
	}

	//если в массиве есть числа, то сохраним
	if ( !empty($data) )
	{
		$data_str = implode(',', $data);
		update_post_meta($post_id, 'product_tables_ids', $data_str);
	}
	//иначе сотрем значение метаполя
	else
		delete_post_meta($post_id, 'product_tables_ids');
}


//метаполя для категорий
$taxname = 'category';

// Поля при добавлении элемента таксономии
add_action("{$taxname}_add_form_fields", 'add_new_custom_fields');
// Поля при редактировании элемента таксономии
add_action("{$taxname}_edit_form_fields", 'edit_new_custom_fields');

// Сохранение при добавлении элемента таксономии
add_action("create_{$taxname}", 'save_custom_taxonomy_meta');
// Сохранение при редактировании элемента таксономии
add_action("edited_{$taxname}", 'save_custom_taxonomy_meta');

function edit_new_custom_fields( $term ) {
	?>
<tr class="form-field">
	<td>
		<label for="#product_tables_ids">ID таблиц</label>
	</td>

	<td>
		<input type="text" id="product_tables_ids" name="product_tables_ids" value="<?php echo get_term_meta($term->term_id, 'product_tables_ids', true); ?>">

		<input type="hidden" name="table_field_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	</td>
</tr>
	<?php
}

function add_new_custom_fields( $taxonomy_slug ){
	?>

	<label for="#product_tables_ids">ID таблиц</label>
	<input type="text" id="product_tables_ids" name="product_tables_ids" value="">

	<?php
}

function save_custom_taxonomy_meta( $term_id ) {

if( !isset($_POST['product_tables_ids']) ) return false; 

	//все проверили, погнали сохранять

	//для начала заменим все символы кроме цифр на разделитель :
	$data_str = preg_replace('/[^0-9]+/', ':', $_POST['product_tables_ids']);

	//после этого переформируем строчку в массив, если ввели не цифры получим пустоту
	$data = explode(':', $data_str);

	//переберем массив с конца до начала, чтобы ни пропустить ни 1 пустого индекса массива
	for ( $i = count($data) - 1; $i >= 0; $i-- )
	{
	    if ( $data[$i] == '')
	        array_splice($data, $i, 1);
	}

	//если в массиве есть числа, то сохраним
	if ( !empty($data) )
	{
		$data_str = implode(',', $data);
		update_term_meta($term_id, 'product_tables_ids', $data_str);
	}
	//иначе сотрем значение метаполя
	else
		delete_term_meta($term_id, 'product_tables_ids');

}
