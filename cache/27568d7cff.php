<?php
// source: add-meeting.latte

use Latte\Runtime as LR;

class Template27568d7cff extends Latte\Runtime\Template
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
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 36, 55');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Add meeting<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
    <div class="container">
	
	    <div class="container" style="margin-top: 0px">
        <h1>Add meeting</h1> 
	</div>    
    
    
<div class="container"  style="margin-top: -25px"> 
<form method="post" action="<?php
		echo $router->pathFor("newMeeting");
?>">
  <div class="form-row"  >

<div class="col-sm-4 form-group">
<label for="z">Start</label>  
<input type="datetime-local" name="z" required> 
</div>

<br>
<div class="col-sm-4 form-group">    
<label for="d">Description</label>  
<input type="text" name="d" required>
</div>
<br>
<div class="col-sm-4 form-group">
<label for="de">Length</label> 
<input type="time" name="de" required> 
 </div>
<br>
 <div class="col-sm-4 form-group">
<label for="m">Place</label>   
       <select name="m">
<?php
		$iterations = 0;
		foreach ($m as $p) {
			?>                <option value="<?php echo LR\Filters::escapeHtmlAttr($p['id_location']) /* line 37 */ ?>"><?php
			echo LR\Filters::escapeHtmlText($p['city']) /* line 37 */ ?> <?php echo LR\Filters::escapeHtmlText($p['street_name']) /* line 37 */ ?> <?php
			echo LR\Filters::escapeHtmlText($p['street_number']) /* line 37 */ ?>, <?php echo LR\Filters::escapeHtmlText($p['name']) /* line 37 */ ?></option>
<?php
			$iterations++;
		}
?>
</select>

<button class="btn-sm btn-primary" type="submit">Submit</button>
 </div>
   </div>
</form>
<br>
<br>
<br>
<table class="table table-dark table-hover">
 <tr>
                <th>Start</th>
                <th>Description</th>
                <th colspan="1" class="text-center">Action</th>
            
            </tr>
<?php
		$iterations = 0;
		foreach ($meetings as $p) {
?>
               <tr>
<td>
<?php echo LR\Filters::escapeHtmlText($p['start']) /* line 58 */ ?>

</td><td>
<?php echo LR\Filters::escapeHtmlText($p['description']) /* line 60 */ ?>

</td><td>
                    <form method="post"
                      action="<?php
			echo $router->pathFor("deleteMeeting");
?>">
			<button class="btn-sm btn-primary" type="submit">Delete</button>
			<input type="hidden" value="<?php echo LR\Filters::escapeHtmlAttr($p['id_meeting']) /* line 65 */ ?>" name="id_meeting">                   </form>
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
