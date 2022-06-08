<?php
// source: add-contact.latte

use Latte\Runtime as LR;

class Template9f487983b7 extends Latte\Runtime\Template
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
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 16, 34');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Add contact<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
    <div class="container">

	    <div class="container" style="margin-top: 0px">
        <h1>Add contact</h1>
        
		</div>
		    <div class="container" style="margin-top: -25px">
		    <form method="post" action="<?php
		echo $router->pathFor("addContact");
		?>?id_person=<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($id)) /* line 13 */ ?>">
        <input type="text" name="c">
       <select name="type">
<?php
		$iterations = 0;
		foreach ($type as $p) {
			?>                <option value="<?php echo LR\Filters::escapeHtmlAttr($p['id_contact_type']) /* line 17 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($p['name']) /* line 17 */ ?></option>
<?php
			$iterations++;
		}
?>
</select>
        <button class="btn-sm btn-primary" type="submit">Submit</button>
    </form>


	</div>
	
<div class="container" style="margin-top: -25px">
<table class="table table-dark table-hover">
   <tr>
                <th>Contact</th>
                <th>Type</th>
                <th colspan="1">Action</th>
            
            </tr>
<?php
		$iterations = 0;
		foreach ($contact as $p) {
?>
         
               <tr>
<td>
<?php echo LR\Filters::escapeHtmlText($p['contact']) /* line 38 */ ?>

</td><td>
<?php echo LR\Filters::escapeHtmlText($p['name']) /* line 40 */ ?>

</td><td>
                    <form method="post"
                      action="<?php
			echo $router->pathFor("addContact");
?>">
			<button class="btn-sm btn-danger" type="submit">Delete</button>
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p['id_contact']) /* line 45 */ ?>" name="id_contact">               
                </form>
</td>
</tr>

<?php
			$iterations++;
		}
?>

</table>
</div>
</div>



<?php
	}

}
