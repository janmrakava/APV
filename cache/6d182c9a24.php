<?php
// source: person-form.latte

use Latte\Runtime as LR;

class Template6d182c9a24 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<div class="container"  style="margin-top: -25px">

    
    <form method="post">
          <div class="form-row"  >
               <div class="col-sm-4 form-group">
                    <label for="first_name">First name</label>
                    <input class="form-control" type="text" name="first_name" placeholder="First name" required value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['first_name']) /* line 8 */ ?>">
                    
               </div>  
               <div class="col-sm-4 form-group">
                    <label for="last_name">Last name</label>
                    <input class="form-control" type="text" name="last_name" placeholder="Last name" required value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['last_name']) /* line 13 */ ?>">
                    
               </div>
               <div class="col-sm-4 form-group">       <!--Stranka ma 12 oddilu, rozdeliu na 4-->
                    <label for="nickname">Nickname</label>
                    <input class="form-control" type="text" name="nickname" placeholder="Nickname" required value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['nickname']) /* line 18 */ ?>">                             
               </div>   
               
                     <div class="col-sm-4 form-group">       <!--Stranka ma 12 oddilu, rozdeliu na 4-->
                        <label for="heigt">Height</label>
                        <input class="form-control" type="number" name="height" placeholder="Height" value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['height']) /* line 23 */ ?>">                             
                    </div>       
               <div class="col-sm-4 form-group">       <!--Stranka ma 12 oddilu, rozdeliu na 4-->
                    <label for="gender">Gender</label>
                    <select class="form-control" name="gender">
                         <option value="female" <?php
		if ($formData['gender']=='female') {
			?>selected<?php
		}
?>>Female</option>
                        <option value="male" <?php
		if ($formData['gender']=='male') {
			?>selected<?php
		}
?>>Male</option>
                       
                    </select>                                          
               </div>   
               <div class="col-sm-4 form-group">       <!--Stranka ma 12 oddilu, rozdeliu na 4-->
                    <label for="birth_date">Date of birth</label>
                    <input class="form-control" type="date" name="birth_day" placeholder="Date of birth" value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['birth_day']) /* line 35 */ ?>">                             
               </div>   
                  
               
          </div>
          <div class="form-row">
            <div class="col-sm-4 form-group">
                <label for="city">City</label>
                <input class="form-control" type="text" name="city" placeholder="City" value="<?php echo LR\Filters::escapeHtmlAttr($formData['city']) /* line 43 */ ?>">
             </div>
             
             <div class="col-sm-4 form-group">
                <label for="street_name">Street name</label>
                <input class="form-control" type="text" name="street_name" placeholder="Street name" value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['street_name']) /* line 48 */ ?>">
             </div>
             
             <div class="col-sm-2 form-group">
                <label for="street_number">Street number</label>
                <input class="form-control" type="number" name="street_number" placeholder="Street number" value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['street_number']) /* line 53 */ ?>">
             </div>
             <div class="col-sm-2 form-group">
                <label for="zip">Zip</label>
                <input class="form-control" type="text" name="zip" placeholder="Street number" value="<?php
		echo LR\Filters::escapeHtmlAttr($formData['zip']) /* line 57 */ ?>">
             </div>
        </div> 
          
          <br>
          <button type="submit" class="btn btn-primary">Submit</button>
          
          
    
    </form>
    


</div><?php
		return get_defined_vars();
	}

}
