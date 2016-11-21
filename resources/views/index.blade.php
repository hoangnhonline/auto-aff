<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">
    <head>
        <title>Mua hàng tặng thẻ cào</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="robots" content="noindex,nofollow"/>
        <meta http-equiv="content-language" content="vi"/>
        <meta name="description" content="Mua hàng tặng thẻ cào"/>
        <meta name="keywords" content="Mua hàng tặng thẻ cào"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
       <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script   src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body class=home>
    
    
	<div class="field" id="searchform">
	  <input type="text" id="txtUrl" placeholder="Vui lòng nhập link sản phẩm" />
	  <button type="submit" id="btnSearch" data-url="{{ route('crawler') }}">Tìm</button>
	</div>
	
	<div id="data" style="text-align:center;width:500px;margin:auto;height:auto;background-color:#FFF;border-radius:5px; display:none;padding:10px">

	</div>
	{{ csrf_field() }}
<script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<style type="text/css">
	@import url(http://fonts.googleapis.com/css?family=Montserrat+Alternates);

	* {
	    margin:0;
	    padding:0;
	    font:12pt Arial;
	}

	body {
	  background-color:#34495e;
	}

	.field {
	  display:flex;
	  position:realtive;
	  margin:5em auto;
	  width:60%;
	  flex-direction:row;
	  box-shadow:
	   1px 1px 0 rgb(22, 160, 133),
	   2px 2px 0 rgb(22, 160, 133),
	   3px 3px 0 rgb(22, 160, 133),
	   4px 4px 0 rgb(22, 160, 133),
	   5px 5px 0 rgb(22, 160, 133),
	   6px 6px 0 rgb(22, 160, 133),
	   7px 7px 0 rgb(22, 160, 133)
	  ;
	}

	.field>input[type=text],
	.field>button {
	  display:block;
	  font:1.2em 'Montserrat Alternates';
	}

	.field>input[type=text] {
	  flex:1;
	  padding:0.6em;
	  border:0.2em solid rgb(26, 188, 156);
	}

	.field>button {
	  padding:0.6em 0.8em;
	  background-color:rgb(26, 188, 156);
	  color:white;
	  border:none;
	}
	#btnSearch{
		cursor: pointer;
	}
</style>
<script type="text/javascript">

	$(document).ready(function(){
		$('#txtUrl').keypress(function(e) {
		    if(e.which == 13) {
				$('#btnSearch').click();        
		    }
		});
		$('#btnSearch').click(function(){
			var obj = $(this);
			var url = $.trim($('#txtUrl').val());
			var urlSubmit = obj.data('url');
			if(url != ''){
				$.ajax({
					url : urlSubmit, 
					type : 'POST',
					data : {
						url : url,
						_token : $('input[name=_token]').val()
					},
					beforeSend : function(){
						obj.html('<i class="fa fa-spin fa-spinner"></i>');
					},
					success : function(data){
						$('div#data').html(data).show();
						obj.html('Tìm');
					}
				})
			}
		});
	});

</script>
 </body>
</html>