<?php
// source: persons.latte

use Latte\Runtime as LR;

class Templateb52f0a4cb3 extends Latte\Runtime\Template
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
		if (isset($this->params['o'])) trigger_error('Variable $o overwritten in foreach on line 42');
		$this->parentName = "layout.latte";
		
	}


	function blockTitle($_args)
	{
		?>Persons list<?php
	}


	function blockBody($_args)
	{
		extract($_args);
?>
<div class="navigation">
<ul>
    <li>
    <form action="<?php
		echo $router->pathFor("search");
?>" method="post">
    <label>Search</label>
    <input class="form_control" type="text" name="person_name" required>
       <button type="submit" class="btn btn3">Search
        <span class="fa fa-search"></span>  
            </button>    
              </form>           
      </li>   
         

      
</ul>   

</div>  
  
         




<div class="container mt-5">
<table class="table table-striped table-hover">
<thead>
<tr>    
    <th>First name</th>
    <th>Last name</th>
    <th>Height</th>
    <th>Gender</th>
    <th colspan="5" class="text-center">Action</th>

</tr>
</thead>
<tbody>
<?php
		$iterations = 0;
		foreach ($persons as $o) {
?>
    <tr>
             <td><?php echo LR\Filters::escapeHtmlText($o['first_name']) /* line 44 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($o['last_name']) /* line 45 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($o['height']) /* line 46 */ ?></td>
             <td><?php echo LR\Filters::escapeHtmlText($o['gender']) /* line 47 */ ?></td>
             <td>
                <a href="<?php
			echo $router->pathFor("person_update");
			?>?id_person=<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($o['id_person'])) /* line 49 */ ?>" class="btn-sm btn-primary">Edit</a>                  
             </td>
             <td>
                   <form method="post" action="<?php
			echo $router->pathFor("person_delete");
			?>?id_person=<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($o['id_person'])) /* line 52 */ ?>"
                   onsubmit="return confirm('Are you sure?')">
                   <button class="btn-sm btn-danger">
                        <span class="fa fa-trash"></span>
                   </form>
               </td>
               <td>    
                 <form method="get"
                      action="<?php
			echo $router->pathFor("relation");
?>">
			<button class="btn-sm btn-primary" type="submit">Add relation</button>
			<input type=hidden name=id value="<?php echo LR\Filters::escapeHtmlAttr($o['id_person']) /* line 62 */ ?>">
                     </form>
               </td>
               <td>
                  <form method="get"
                      action="<?php
			echo $router->pathFor("addMeetingToPerson");
?>">
			<button class="btn-sm btn-primary" type="submit">Add meeting</button>
			<input type=hidden name=id value="<?php echo LR\Filters::escapeHtmlAttr($o['id_person']) /* line 69 */ ?>">
                     </form>
               </td>
               
               <td>
               <form method="get"
                      action="<?php
			echo $router->pathFor("addContact");
?>">
			<button class="btn-sm btn-primary" type="submit">Add contact</button>
			<input type=hidden name=id value="<?php echo LR\Filters::escapeHtmlAttr($o['id_person']) /* line 77 */ ?>">
                     </form>
               </td>
               
              
             
             
    </tr>         
<?php
			$iterations++;
		}
?>
    </tbody>
</table>

</div>
<footer>
<div class="container mt-5">
<?php
		for ($i=0;
		$i< $pocet;
		$i++) {
			if ($i % 10 == 0) {
?>
         <span>
         <a href="<?php
				echo $router->pathFor("persons");
				?>?page=<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($i)) /* line 95 */ ?>"><?php echo LR\Filters::escapeHtmlText($i / 10 +1) /* line 95 */ ?></a>
         </span>
<?php
			}
		}
?>
</div>
</footer>

<?php
	}

}
