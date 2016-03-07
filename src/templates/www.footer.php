<?
//$NC = new Navigation();
$navigation = $this->navigation("main");
?>
	</div>

	<div id="navigation">
		<ul class="navigation">
<?		if($navigation):
			foreach($navigation["nodes"] as $node): ?>
			<?= $HTML->navigationLink($node); ?>
<?			endforeach;
	 	endif; ?>
		</ul>
	</div>

	<div id="footer">
		<p>&lt;aliens&gt;we are all&lt;/aliens&gt;</p>
	</div>

</div>

</body>
</html>