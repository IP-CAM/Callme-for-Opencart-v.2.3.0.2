
<!----заказзать звонок---->
<div class="callme modal fade hidden-print" id="callme">
  <div class="modal-dialog modal-dialog modal-lg">
    <div class="modal-content">     
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $text_callme; ?></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>   
      <div class="modal-body">
	  <div class="modal-info"><?php echo $text_callme_info;?></div>
        <form class="callme_form" id="callme_form">
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
					<input type="text" name="name" placeholder="<?php echo $input_name ?>*" value="" class="form-control">
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group tel">
					<input type="text" placeholder="+7( )*" name="phone" value="" class="form-control" autocomplete="off">
					</div>
				</div>
				
			</div>
			<div class="row align-items-center">
				<div class="col-12 col-md-6 col-lg-3 text-center text-md-left mb-2 mb-md-0">
					<button type="button" class="btn btn-primary  button" name="submit" value="<?php echo $text_callme_info;?>"><?php echo $button_submit; ?> <i class="icon icon-arrow-left"></i></button>
				</div>
				<div class="col-12 col-md-6 col-lg-9">
					<?php echo $text_policy; ?>
				</div>
			</div>
			<input type="hidden" class="geturl" name="geturl" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
			<input type="hidden" name="subject" value="Заказ обратного звонка">
			<input type="hidden" name="head" value="На вашем сайте <?php echo $_SERVER['HTTP_HOST'];?> оставили заявку на обратный звонок">
			
		</form>
      </div>
	  </div>
  </div>
</div>


<!----Получить консультацию---->
<div class="freeconsul_modal modal fade hidden-print" id="freeconsul_modal">
  <div class="modal-dialog modal-dialog modal-lg">
    <div class="modal-content">     
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $text_freeconsul_title_modal; ?></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>   
      <div class="modal-body">	
        <form class="freeconsul_form" id="freeconsul_form">
			<div class="row">
				<div class="col-12 col-md-4">
					<div class="form-group">
					<input type="text" name="name" placeholder="<?php echo $input_name ?>*" value="" class="form-control">
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="form-group tel">
					<input type="text" placeholder="+7( )*" name="phone" value="" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-12 col-md-4">
					<div class="form-group">
					<input type="text" placeholder="<?php echo $input_email ?>*" name="email" value="" class="form-control" autocomplete="off">
					</div>
				</div>
				<div class="col-12">
					<div class="form-group">
						<textarea placeholder="<?php echo $input_message ?>" name="message" value="" class="form-control" autocomplete="off"></textarea>
					</div>
				</div>
				
			</div>
			<div class="row align-items-center">
				<div class="col-12 col-md-6 col-lg-2 text-center text-md-left mb-2 mb-md-0">
					<button type="button" class="btn btn-primary  button" name="submit" value="<?php echo $text_callme_info;?>"><?php echo $button_submit; ?></button>
				</div>
				<div class="col-12 col-md-6 col-lg-10">
					<?php echo $text_policy; ?>
				</div>
			</div>
			<input type="hidden" name="product" value="">
			<input type="hidden" class="geturl" name="geturl" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
			<input type="hidden" name="subject" value="Заявка с сайта <?php echo $_SERVER['HTTP_HOST']; ?>">			
			<input type="hidden" name="head" value="На вашем сайте <?php echo $_SERVER['HTTP_HOST'];?> оставили заявку на бесплатную консультацию">
			
		</form>
      </div>
	  </div>
  </div>
</div>


<div class="succesform modal  hidden-print" id="succesform">
<div class="modal-dialog modal-lg">
<div class=" modal-content">
	<div class="modal-header">
        <h4 class="modal-title"><?php echo $text_callme; ?></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span></button>
      </div>
<div class="modal-body">
<h5 class="success_call"></h5>
<h5 class="call"></h5>
</div>
</div>
</div>
</div> 




<script type="text/javascript">
$(document).ready(function() {
	
//callme
$(".callme_form .button").on('click',function(e){
var parent_em=$(this).parents('form');
$.ajax({
    url: "/index.php?route=module/callme",
	type: 'post',
	dataType: 'json',
    data: $(parent_em).serialize(),
	beforeSend: function() {
			$(this).attr("disabled",'disabled');
            $(parent_em).find('.error').remove();
		},
	complete: function() {
			$(this).removeAttr("disabled");
		},	

    success: function(json) {
		$('.alert-success, .alert-danger, .alert-info').remove();
		
		if (json['error']) {
			for (let key in json['error']) {				
				$(parent_em).find('[name="' + key +'"]').after('<span class="error">' + json['error'][key] + '</span>');				
			}	
		}	
		
		if (json['success']) {				
				$(parent_em).trigger( 'reset' );
				$('.succesform h4').html('');
				$('.succesform h4').html(json['success']);
				if(json['success_call']){
					$('.succesform h5.success_call').html(json['success_call']);
				}
				if(json['call']){
					$('.succesform h5.call').html(json['call']);
				}
				$('.modal').modal('hide');
				$('.succesform').modal('show');					
				
			}
		}

  });
  e.preventDefault();
});
//другие формы
$(".freeconsul_form .button").on('click',function(e){
var parent_em=$(this).parents('form');
$.ajax({
    url: "/index.php?route=module/callme/write",
	type: 'post',
	dataType: 'json',
    data: $(parent_em).serialize(),
	beforeSend: function() {
			$(this).attr("disabled",'disabled');
            $(parent_em).find('.error').remove();
		},
	complete: function() {
			$(this).removeAttr("disabled");
		},	

    success: function(json) {
		$('.alert-success, .alert-danger, .alert-info').remove();
		
		if (json['error']) {
			for (let key in json['error']) {				
				$(parent_em).find('[name="' + key +'"]').after('<span class="error">' + json['error'][key] + '</span>');				
			}	
		}	
		
		if (json['success']) {				
				$(parent_em).trigger( 'reset' );
				$('.succesform h4').html('');
				$('.succesform h4').html(json['success']);
				if(json['success_call']){
					$('.succesform h5.success_call').html(json['success_call']);
				}
				if(json['call']){
					$('.succesform h5.call').html(json['call']);
				}
				$('.modal').modal('hide');
				$('.succesform').modal('show');					
				
			}
		}

  });
  e.preventDefault();
});


});


</script>

<?php if(isset($session_id)){ ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('form').append('<input name="session_id" type="hidden" value="<?php echo $session_id;?>">');
		});	
	</script>
<?php } ?>