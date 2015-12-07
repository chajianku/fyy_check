<?php
/*
Plugin Name: 用户信息检查
Version: 1.6
Plugin URL: http://fyy.l19l.com
Description: 检查用户的绑定情况
Author: FYY
Author Email:fyy@l19l.com
Author URL: http://fyy.l19l.com
For: V3.8+
*/
if (!defined('SYSTEM_ROOT')) { die('Insufficient Permissions'); } 

function fyy_remind_show() {
	global $i;
	global $m;
	?>
<br/>
<input type="button" data-toggle="modal" data-target="#check" class="btn btn-info" value="Let's Check!" >
<div class="modal fade" id="check" tabindex="-1" role="dialog" aria-labelledby="check" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="banuser_title">用户信息检查</h4>
		</div>
		<div class="input-group">
			<?php
				//1.是否绑定百度账号
				$bdusses = $i['user']['bduss'];
				$num = count($bdusses);
				if (empty($num)){
					echo '<br/>　　<font color="red"><span class="glyphicon glyphicon-warning-sign"></span> <b>警告：</b></font>您暂未绑定百度账号，这将导致无法签到，<a href='.SYSTEM_URL.'index.php?mod=baiduid>还不快去？</a>';
				}
				else {
					echo '<br/>　　<font color="green"><span class="glyphicon glyphicon-ok"></span> <b>正常：</b></font>您已成功绑定了'.$num.'个百度帐号，它们分别是：<br/>';
					foreach ($bdusses as $bdid){
						$bdid = getBaiduId($bdid);
						echo '　　　　<b>·</b>';	
						if(empty($bdid)) echo '<font color="red"><b>警告：</b>这一用户BDUSS失效</font>，<a href='.SYSTEM_URL.'index.php?mod=baiduid>重新绑定</a><br/>';
						else echo $bdid.'<br/>';
					}
				}
			?>
		</div>
		<div class="input-group">
			<?php
				//2.是否刷新贴吧列表
				$list = $m->once_fetch_array("SELECT COUNT(*) AS `n` FROM `".DB_PREFIX.TABLE."` WHERE `uid` = '".UID."'");
				if (empty($list['n'])){
					echo '<br/>　　<font color="red"><span class="glyphicon glyphicon-warning-sign"></span> <b>警告：</b></font>您暂未刷新贴吧列表，这将导致无法签到，<a href='.SYSTEM_URL.'index.php?mod=showtb>还不快去？</a><br/><br/>';
				}
				else echo '<br/>　　<font color="green"><span class="glyphicon glyphicon-ok"></span> <b>正常：</b></font>检测到您共有'.$list['n'].'个百度贴吧<br/><br/>';
			?>
		</div>
		<div class="modal-footer">
			插件作者：<a href='http://fyy.l19l.com/'>FYY</a>　　
			<button type="button" class="btn btn-default" data-dismiss="modal">了解！</button>
		</div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<?php
}

addAction('index_3','fyy_remind_show');
?>