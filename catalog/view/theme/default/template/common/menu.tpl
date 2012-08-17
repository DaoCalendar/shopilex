<?php if ($categories) { ?>
<div id="menu" class="headMenu">
<ul class="mainNav">
	<li class="first"></li>
	<?php foreach ($categories as $category) { ?>
	<li><a class="track" href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
	<?php if ($category['children']) { ?>
	<div class="navMenu"><?php for ($i = 0; $i < count($category['children']);) { ?>
	<div class="subClass">
	<ul class="oneField">
	<?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
	<?php for (; $i < $j; $i++) { ?>
	<?php if (isset($category['children'][$i])) { ?>
		<li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
		<?php } ?>
		<?php } ?>
	</ul>
	</div>
	<?php } ?></div>
	<?php } ?></li>
	<?php } ?>
	<li class="last"></li>
</ul>
</div>
	<?php } ?>
