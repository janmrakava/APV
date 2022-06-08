<?php
// source: add-meeting-to-person.latte

use Latte\Runtime as LR;

class Template680297e58e extends Latte\Runtime\Template
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
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 19, 36');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Add meeting to person<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
    <div class="container">  	
	    <div class="container" style="margin-top: 0px">
        <h1>Add meeting</h1> 
	</div>
	
<div class="container" style="margin-top: -25px">

<form method="post" action="<?php
		echo $router->pathFor("newMeetingToPerson");
?>">
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($id) /* line 14 */ ?>" name="id_person">

Meeting

       <select name="m">
<?php
		$iterations = 0;
		foreach ($m as $p) {
			?>                <option value="<?php echo LR\Filters::escapeHtmlAttr($p['id_meeting']) /* line 20 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($p['description']) /* line 20 */ ?>, <?php echo LR\Filters::escapeHtmlText($p['start']) /* line 20 */ ?></option>
<?php
			$iterations++;
		}
?>
</select>   
<button class="btn-sm btn-primary" type="submit">Submit</button>

</form>
<br>
<br>
<br>                                              
<table class="table table-dark table-hover">
<tr>
                <th>Start</th>
                <th>Description</th>
                <th colspan="1">Action</th>
            
            </tr>
<?php
		$iterations = 0;
		foreach ($meetings as $p) {
?>
               <tr>
<td>
<?php echo LR\Filters::escapeHtmlText($p['start']) /* line 39 */ ?>

</td><td>
<?php echo LR\Filters::escapeHtmlText($p['description']) /* line 41 */ ?>

</td><td>
                    <form method="post"
                      action="<?php
			echo $router->pathFor("deleteMeetingToPerson");
?>">
			<button class="btn-sm btn-danger" type="submit">Delete</button>
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p['id_meeting']) /* line 46 */ ?>" name="id_meeting">     
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p['id_person']) /* line 47 */ ?>" name="id_person">     
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
