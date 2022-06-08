<?php
// source: newPerson.latte

use Latte\Runtime as LR;

class Template50481dec97 extends Latte\Runtime\Template
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
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>New person form<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
<div class="container">
      <h1>New person</h1>
</div>
<?php
		/* line 10 */
		$this->createTemplate("person-form.latte", ['operation' => 'New'] + $this->params, "include")->renderToContentType('html');
?>


<?php
	}

}
