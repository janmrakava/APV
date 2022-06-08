<?php
// source: percon.latte

use Latte\Runtime as LR;

class Template6f5fc62221 extends Latte\Runtime\Template
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
		if (isset($this->params['p'])) trigger_error('Variable $p overwritten in foreach on line 18');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Person & address list<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>



<div class="container mt-5">
<table class="table table-striped table-hover">
<tr>
    <th>First name</th>
    <th>Last name</th>
    <th>Address</th>
    <th>Birth day</th>  
    <th>Action</th>    
</tr>
<?php
		$iterations = 0;
		foreach ($percon as $p) {
?>
    <tr>
             <td><?php echo LR\Filters::escapeHtmlText($p['first_name']) /* line 20 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['last_name']) /* line 21 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['place']) /* line 22 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($p['birth_day']) /* line 23 */ ?></td>
            
    </tr>         
<?php
			$iterations++;
		}
?>
</table>







<?php
	}

}
