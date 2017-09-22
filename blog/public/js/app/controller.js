
var boot = {
	init: function(){
		layer.config({
		 	extend: 'extend/layer.ext.js'
		});

		$(document).on('click','.js-del-article', function() {
			var art_id = $(this).attr('values');
			layer.open({
			    type: 1, 
			    skin: 'layer-default',
			    title: '删除文章',
			    content: $('.delConfirm'), //这里content是一个普通的String
			    area: ['350px'],
			    closeBtn: 2,
			    btn: ['确定', '取消'],
			    yes: function(index, layero) {
					$.ajax({
						url: 'del',
						type: 'POST',
						dataType: 'JSON',
						data: {'id':art_id},
						success: function(data) {
							if(data.code == 1)
							{
								location.reload();
							}else{
								
							}
						}
					});
			    },cancel: function(index){ 
					//alert('不删除');
			    }
			});
		}).on('click','.js-updown', function() {
			$(this).parent().find('.sub-class-list').slideToggle();
		}).on('blur', '#userName', function() {
			var nameVal = $(this).val();
			var token = $("#token").val();
			var $tips = $(this).next();
			if (nameVal == "")
			{
				$tips.text('用户名不能为空');
			} else {
				$.ajax({
					url: 'admin/check_account',
					type: 'POST',
					dataType: 'JSON',
					data: {'name':nameVal, '_token':token},
					success:function(data) {
						if(data.code == 1)
						{
							$tips.text('用户存在');
							// $('.js-login').attr('enabled','true');
							$('.js-login').attr('disabled', false);
						}else{
							$tips.text('用户名错误');
							$('.js-login').attr('disabled','disabled');
						}
					}
				});
			}
		}).on('click', '.js-login', function() {
			var nameVal = $('#userName').val();
			var pswVal = $('#userPsw').val();
			var token = $("#token").val();
			if (nameVal && pswVal)
			{
				$.ajax({
					url: 'admin/login',
					type: 'POST',
					dataType: 'JSON',
					data: {'name':nameVal, 'password':pswVal, '_token':token},
					success: function(data) {
						if (data.code == -1)
						{
							$('#userPsw').next().text('密码错误');
						} else {
							$('#userPsw').next().text('');
							location.href = data.url;
						}
					}
				});
			}
		});


		var arcContent = $('.art-content');
        arcContent.each(function(index, value) {
         	$clamp(arcContent[index], {clamp: 10, useNativeClamp: false});
        });
	}
};

boot.init();
