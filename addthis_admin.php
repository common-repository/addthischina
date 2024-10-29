<?php if (realpath(@$_SERVER['SCRIPT_FILENAME']) == realpath(__FILE__)) exit("Access Denied"); ?>

<style type="text/css">
.addList2{ margin:0; padding:0; list-style:none; line-height:20px;}
.addList2 li{ width:186px; height:22px; margin:0 8px 1px 3px; float:left; display:inline;}
.addList2 li a{ margin:0 0 0 2px; padding:0 0 0 20px;}
.addList2 li a.onpadd{ padding:0;}
.addList2 li input{ float:left; margin-right:5px;}
.addList2 li.on{ width:184px; height:20px; background:#ECF4F7; border:#B4D0DA solid 1px;}
.addthis_code_hide{ display:none;}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<script type="text/javascript" src="http://china-addthis.googlecode.com/svn/trunk/addthis.js"></script>
<div class="wrap">
<h2>分享家：AddThis中文收藏分享按钮</h2>
<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>
	<input type="hidden" name="addthis_code" value="<?php echo htmlspecialchars(get_option('addthis_code')); ?>" />
	<div class="addthis_code_hide"></div>
	<table class="form-table">
	<tr valign="top">
	<th scope="row">选择按钮</th>
	<td><ul class="btnList addList2"></ul>
	<input name="selectall" type="checkbox" value="" checked="checked" />全选
	<br style="clear:both;" />
	</td>
	</tr>
	<tr valign="top">
	<th scope="row">选择样式</th>
	<td>
	<ul class="addList2">
		<li><input name="style" type="radio" value="a1.gif" checked="checked" /><img src="<?php echo $addthis_plugin_url ?>/a1.gif" alt="" /></li>
		<li><input name="style" type="radio" value="a2.gif" /><img src="<?php echo $addthis_plugin_url ?>/a2.gif" alt="" /></li>
		<li><input name="style" type="radio" value="a3.gif" /><img src="<?php echo $addthis_plugin_url ?>/a3.gif" alt="" /></li>
		<li><input name="style" type="radio" value="a4.gif" /><img src="<?php echo $addthis_plugin_url ?>/a4.gif" alt="" /></li>
		<li><input name="style" type="radio" value="a5.gif" /><img src="<?php echo $addthis_plugin_url ?>/a5.gif" alt="" /></li>
	</ul>
	<div style="clear:both;">
	<input name="style" class="radioTxt" type="radio" value="" />文字<input name="styleTxt" value="" type="text" size="8" maxlength="20" /> &nbsp; 
	边框颜色 <input type="text" value="#" size="8" name="abordercolor" id="abordercolor" /> &nbsp;
	标题栏背景色 <input type="text" value="#" size="8" name="aheadbgcolor" id="aheadbgcolor" />
	</div>
	</td>
	</tr>
	<tr valign="top">
	<th scope="row">事件绑定</th>
	<td>
	<input name="event" type="radio" value="mouseover" checked="checked" />mouseover（放上鼠标即显示）&nbsp; &nbsp; 
	<input name="event" type="radio" value="click" />click（鼠标点击显示）
	</td>
	</tr>
	<tr valign="top">
	<th scope="row">显示位置</th>
	<td>
	<input type="checkbox" name="addthis_show[]" value="home" <?php addthis_checked_place("home", true); ?> />在首页显示 &nbsp; <input type="checkbox" name="addthis_show[]" value="page" <?php addthis_checked_place("page", true); ?> />在Page页显示 &nbsp; <input type="checkbox" name="addthis_show[]" value="category" <?php addthis_checked_place("category", true); ?> />在分类页显示 &nbsp; <input type="checkbox" name="addthis_show[]" value="archive" <?php addthis_checked_place("archive", true); ?> />在存档页显示 <br />
	<input type="checkbox" name="addthis_show[]" value="search" <?php addthis_checked_place("search", true); ?> />在搜索页显示 &nbsp; <input type="checkbox" name="addthis_show[]" value="feed" <?php addthis_checked_place("feed", true); ?> />在Feed页显示(可能无法显示js内容，但不影响收藏操作)。
	</td>
	</tr>
	<tr valign="top">
	<th scope="row">预览</th>
	<td>
	<div class="addthisPreview"></div>
	</td>
	</tr>
	</table>
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="addthis_code,addthis_show" />
	<p class="submit">
	<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
	</p>
</form>
</div>
<script type="text/javascript">
$(function(){
	$(".addthis_code_hide").html($("input[name='addthis_code']").val());
	var atObj = $(".addthis_code_hide .addthis_org_cn a");
	
	var btnsHtml='';
	for(var key in $$addthis.favs){
		if ($$addthis.favs[key].id>=0) {
			btnsHtml+='<li><input name="item" type="checkbox" value="'+ $$addthis.favs[key].id +'"';
			if (!atObj.attr("i") || ('|'+atObj.attr("i")+'|'.indexOf('|'+$$addthis.favs[key].id+'|')>=0)) {
				btnsHtml+=' checked="checked"';
			}
			btnsHtml+=' /><a class="add_'+ $$addthis.favs[key].id +'" item="'+ $$addthis.favs[key].id +'" href="#">'+ $$addthis.favs[key].name +'</a></li>'
		}
	}
	$(".btnList").html(btnsHtml);
	
	if (atObj.find("img").length>0){
		$("input[name='style']").each(function(){
			if (atObj.find("img").attr("src").indexOf($(this).val())>0) {
				$(this).attr("checked","checked");
			} else {
				$(this).removeAttr("checked");
			}
		});
		$("input.radioTxt").removeAttr("checked");
	} else {//属于文字
		$("input[name='style']").removeAttr("checked");
		$("input.radioTxt").attr("checked","checked");
		$("input.radioTxt").val(atObj.html());
		$("input[name='styleTxt']").val(atObj.html());
	}
	
	$("input[name='event']").each(function(){
		if (atObj.attr("e")==$(this).val()) {
			$(this).attr("checked","checked");
		} else if (atObj.attr("e")) {
			$(this).removeAttr("checked");
		}
	});
	
	
	
	$("input[name='selectall']").click(function(){
		if ($(this).attr("checked")) {
			$("input[name='item']").attr("checked","checked");
		} else {
			$("input[name='item']").removeAttr("checked");
		}
	});
	getCode();
	$("input[name='item']").click(getCode);
	$("input[name='style']").click(getCode);
	$("input[name='styleTxt']").change(function(){$("input.radioTxt").val($(this).val()); getCode();});
	$("input[name='selectall']").click(getCode);
	$("input[name='event']").click(getCode);
	$("input#abordercolor").change(getCode);
	$("input#aheadbgcolor").change(getCode);
});

function getCode(){
	var i='';
	if ($("input[name='item']:not(:checked)").length>0) {
		$("input:checked[name='item']").each(function(){ i=="" ? i+=$(this).val().toString() : i+="|"+$(this).val().toString();});
	}
	var img = $("input:checked[name='style']").val();
	if (img.indexOf(".gif")>0) {
		img = "<img src='<?php echo $addthis_plugin_url ?>/"+ img +"' alt='分享家:Addthis中国' align='absmiddle' />";
	}
	var abordercolor = $("input#abordercolor").val();
	if (abordercolor=="#") abordercolor="";
	var aheadbgcolor = $("input#aheadbgcolor").val();
	if (aheadbgcolor=="#") aheadbgcolor="";
	var e = $("input:checked[name='event']").val();
	var str = '';
	str += "<span class='addthis_org_cn'><a href='http://addthis.org.cn/share/'"+ (i=="" ? "" : " i='"+ i +"'") + (abordercolor ? ' abordercolor="'+ abordercolor +'"':'') + (aheadbgcolor ? ' aheadbgcolor="'+ aheadbgcolor +'"':'') + (e=="click" ? " e='"+ e +"'":"") +" title='收藏-分享'>"+ img +"</a></span>"; 
	$(".addthisPreview").html(str);
	$("input[name='addthis_code']").val(str);
	$$addthis.rebind();
}


function  HTMLEnCode(str)  
{  
	 var    s    =    "";  
	 if    (str.length    ==    0)    return    "";  
	 s    =    str.replace(/&/g,    "&gt;");  
	 s    =    s.replace(/</g,        "&lt;");  
	 s    =    s.replace(/>/g,        "&gt;");  
	// s    =    s.replace(/ /g,        "&nbsp;");  
	 s    =    s.replace(/\'/g,      "&#39;");  
	 s    =    s.replace(/\"/g,      "&quot;");  
	// s    =    s.replace(/\n/g,      "<br>");  
	 return    s;  
   } 
</script>

