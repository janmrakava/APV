<?php
// source: meetings.latte

use Latte\Runtime as LR;

class Template07c034657e extends Latte\Runtime\Template
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
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 17');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Location & meeting list<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>


<div class="container mt-5">
<table class="table table-striped table-hover">
<tr>
    <th>Date</th>
    <th>Place</th>
    <th>Description</th>
    <th>Duration</th>  
      
</tr>
<?php
		$iterations = 0;
		foreach ($meetings as $p) {
?>
    <tr>
             <td><?php echo LR\Filters::escapeHtmlText($p['date']) /* line 19 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['place']) /* line 20 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['description']) /* line 21 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['duration']) /* line 22 */ ?></td>
            
    </tr>         
<?php
			$iterations++;
		}
?>
</table>



<?php
	}

}
