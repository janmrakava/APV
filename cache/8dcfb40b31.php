<?php
// source: relation.latte

use Latte\Runtime as LR;

class Template8dcfb40b31 extends Latte\Runtime\Template
{
	public $blocks = [
		'title' => 'blockTitle',
		'body' => 'blockBody',
	];

	public $blockTypes = [
		'title' => 'html',
		'body' => 'html',
	];


	function main()
	{
		extract($this->params);
?>

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('title', get_defined_vars());
?>

<?php
		$this->renderBlock('body', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['q'])) trigger_error('Variable $q overwritten in foreach on line 17, 24, 56');
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 44');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Add relation<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
    <div class="container">	
	    <div class="container" style="margin-top: 0px">
        <h1>Add relation</h1>   
        
        	</div>
	
<div class="container" style="margin-top: -25px">
<form method="post" action="<?php
		echo $router->pathFor("addRelationToPerson");
?>">
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($id) /* line 14 */ ?>" name="id">  
			<input type="text" placeholder="description" name="d">  
<select name="pe">
<?php
		$iterations = 0;
		foreach ($pe as $q) {
?>
			
                <option value="<?php echo LR\Filters::escapeHtmlAttr($q['id_person']) /* line 19 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($q['nickname']) /* line 19 */ ?></option>
<?php
			$iterations++;
		}
		?>			<?php echo LR\Filters::escapeHtmlText($q = "") /* line 21 */ ?>

</select>			
<select name="t">
<?php
		$iterations = 0;
		foreach ($m as $q) {
?>
			
                <option value="<?php echo LR\Filters::escapeHtmlAttr($q['id_relation_type']) /* line 26 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($q['name']) /* line 26 */ ?></option>
<?php
			$iterations++;
		}
		?>			<?php echo LR\Filters::escapeHtmlText($q = "") /* line 28 */ ?>

</select>
<button class="btn-sm btn-primary" type="submit">Submit</button>
</form>

</div>
<br>
<div class="container" style="margin-top: 0px">

<table class="table table-dark table-hover">
   <tr>
                <th>Name</th>
                <th>Type</th>
                <th colspan="2" class="text-center">Action</th>
            
            </tr>
<?php
		$iterations = 0;
		foreach ($r as $p) {
?>
<tr>
<td>
<?php echo LR\Filters::escapeHtmlText($p['nickname']) /* line 47 */ ?>

</td>
<td>
<form method="post" action="<?php
			echo $router->pathFor("editRelation");
?>">
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($id) /* line 51 */ ?>" name="id">     
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p['id_person']) /* line 52 */ ?>" name="id_person">  
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p["id_relation"]) /* line 53 */ ?>" name="id_relation">  
<select name="t">
<option value="">Choose</option>
<?php
			$iterations = 0;
			foreach ($m as $q) {
?>
			
                <option <?php
				if ($q['id_relation_type']==$p["id_relation_type"]) {
					?> selected <?php
				}
				?> value="<?php echo LR\Filters::escapeHtmlAttr($q['id_relation_type']) /* line 58 */ ?>"><?php echo LR\Filters::escapeHtmlText($q['name']) /* line 58 */ ?></option>
<?php
				$iterations++;
			}
			?>			<?php echo LR\Filters::escapeHtmlText($q = "") /* line 60 */ ?>

</select>
</td>
<td>
<button class="btn-sm btn-primary" type="submit">Submit</button>
</td>
</form>

<td>
<form method="post" action="<?php
			echo $router->pathFor("deleteRelation");
?>">
<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p["id_relation"]) /* line 70 */ ?>" name="id_relation">  
<button class="btn-sm btn-danger" type="submit">Delete</button>
</form>
</td>
</tr>
<?php
			$iterations++;
		}
?>
</table>


</div>



<?php
	}

}
