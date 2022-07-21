<div class='pagination'>
	<ul>
		<?php if ($page > 1) { ?>
			<li><a href='?page=1'><i class="fa-solid fa-angles-left"></i></a></li>
			<li><a href='?page=<?=$page - 1;?>'><?=$page - 1?></a></li>
		<?php } ?>
		<li><a href='?page=<?=$page?>' class='active'><?=$page?></a></li>
		<?php if ($page < $page_count) { ?>
			<li><a href='?page=<?=$page + 1;?>'><?=$page + 1?></a></li>
			<li><a href='?page=<?=$page_count;?>'><i class="fa-solid fa-angles-right"></i></a></li>
		<?php } ?>
	</ul>
</div>
