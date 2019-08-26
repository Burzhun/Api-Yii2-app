<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

/**
 * @var $colsUser User
 * @var $colsCheck Connection
 */

use common\models\localRecord\User;
use yii\mongodb\Connection;

?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Кол-во пользователей</h2>

                <h3><?= $colsUser ?></h3>


            </div>
            <div class="col-lg-4">
                <h2>Кол-во чеков</h2>

                <h3><?= $colsCheck ?></h3>


            </div>
        </div>
		
		<div class="row">
            <div class="col-lg-8">
                <span><h3>Акция действует с  <input class="update" type="date" id="dateFrom" value="<?=$event['dateFrom']?>" /> по <input class="update" type="date" id="dateTo" value="<?=$event['dateTo']?>" /> </h3></span>



            </div>
        </div>
		<div class="row">
            <div class="col-lg-8">
                <span><h3>Ограничение по сумме <input class="update" type="text" id="limit" value="<?=$event['limit']?>" /></h3></span>                

            </div>
        </div>
		<div class="row">
            <div class="col-lg-8">
                <span><h3>Количество дней на регистрацию чека<input class="update" type="text" id="days" value="<?=$event['days']?>" /></h3></span>                

            </div>
        </div>
		<div class="row">
            <div class="col-lg-8">
				<button id="save">Сохранить</button>                

            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$("#save").click(function(){
			$("input.update").each(function(){
				var value = $(this).val();
				var name = $(this).attr('id');
				$.post('',{value:value,name:name},function(){});
			});
		});
		
	});
</script>
