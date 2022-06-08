<?php
// source: layout.latte

use Latte\Runtime as LR;

class Template0c4f3d1e43 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="utf-8">
    <title><?php
		$this->renderBlock('title', $this->params, 'html');
?></title>
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 6 */ ?>/css/bootstrap/css/bootstrap.min.css">        
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 7 */ ?>/css/font-awesome/css/all.min.css"> 
   
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */ ?>/css/custom.css">
    <script type="text/javascript" src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 10 */ ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 11 */ ?>/css/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
		if (isset($this->blockQueue["meta"])) {
			$this->renderBlock('meta', $this->params, 'html');
		}
?>

</head>
<body>
<nav>
        <ul>
        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 19 */ ?>">Home</a></li>     
        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 20 */ ?>/persons">Persons</a></li>        
        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 21 */ ?>/percon">Per & Add</a></li>
        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 22 */ ?>/meetings">Meetings</a></li>
        <li><a href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 23 */ ?>/persons/new">Add new person</a></li> 
        <li><a href="<?php
		echo $router->pathFor("addMeeting");
?>">Add meeting</a>
        
      
        
        
        
        
        </ul>
    </nav>

<?php
		$this->renderBlock('body', $this->params, 'html');
?>
</body>
</html>


 <!-- V basePath ulozena cela adresa projektu   -->
<?php
		return get_defined_vars();
	}

}
