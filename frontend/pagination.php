<section id='pagination'>
	<div class='pagination'>
		<ul>
			<?php if ($page > 1) { ?>
				<li><a href='?page=1'><i class="fa-solid fa-angles-left"></i></a></li>
				<li><a href='?page=<?=$page - 1;?>'><?=$page - 1?></a></li>
			<?php } ?>
			<li>
				<input id='pagination_number' type='number' min='1'
				max='<?=$page_count?>' pattern='[0-9]*' value='<?=$page?>'>
			</li>
			<?php if ($page < $page_count) { ?>
				<li><a href='?page=<?=$page + 1;?>'><?=$page + 1?></a></li>
				<li><a href='?page=<?=$page_count;?>'><i class="fa-solid fa-angles-right"></i></a></li>
			<?php } ?>
		</ul>
	</div>
</section>
<script src='js/pagination.js'></script>
