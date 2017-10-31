<?php
if(!defined('__ZBXE__') && !defined('__XE__')) exit();
if($called_position == 'before_display_content' && Context::get('module') != 'admin') {

$ai = $addon_info;
$view_checker = 0;

if($ai->until) if(time() > strtotime($ai->until)) $view_checker = 1;

$Member = &getModel('member');
if($Member->isLogged()) {
	$MemberID=$Member->getLoggedUserID();
	if($MemberID) {
		// member ID
		if($ai->but_group != '' || $ai->but_id != '') {
			$MemberSRL=$Member->getMemberSrlByUserID($MemberID);
			$MemberGroups=$Member->getMemberGroups($MemberSRL);
			if($ai->but_id) {
				$but_ids = explode(",",$ai->but_id);
				if(is_array($but_ids)) {
					if(in_array($MemberID, $but_ids) && $MemberID!='') $view_checker = 1;
				}
			}
			if($ai->but_group) {
				// member Group
				$but_groups = explode(",",$ai->but_group);
				if(is_array($MemberGroups)) {
					foreach($MemberGroups as $value) {
						if(in_array($value,$but_groups) && $value!='') $view_checker = 1;
					}
				}
			}
		}
	}
}
if($view_checker == 0 || !$view_checker) {
	header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
<link rel="stylesheet" href="./addons/simple_parking/css/bootstrap.min.css" />
<style>
body, table, input, textarea, select, button{font-family:'NanumGothic','Segoe UI','Malgun Gothic','Apple SD Gothic Neo','Dotum',Tahoma,Geneva,sans-serif !important}
body{background:#eee}
.wrap{margin:50px auto;width:900px}
.container{padding:60px 10px;}
.hero-unit{padding:0}
.hero-unit h1{margin:10px 0;text-shadow:1px 1px #fff;font-size:30px;font-weight:normal;color:#555}
.preview_img{float:left;margin:0 20px 20px 0;background:#fff;-ms-transition:.2s all ease;-moz-transition:.2s all ease;-webkit-transition:.2s all ease;transition:.2s all ease;-webkit-transform:rotate(-1deg);-moz-transform:rotate(-1deg);-ms-transform:rotate(-1deg);transform:rotate(-1deg)}
.preview_img img{width:260px;height:180px;min-width:260px;min-height:180px;max-width:260px;max-height:180px}
.preview_img:hover{-webkit-transform:rotate(-2deg);-moz-transform:rotate(-2deg);-ms-transform:rotate(-2deg);transform:rotate(-2deg)}
.content{color:#777 !important}
.btnArea{text-align:right}
@media (max-width:960px){
	.container{width:auto}
	.hero-unit{margin:0;padding:0}
	.wrap{width:auto;margin:0}
	.btnArea{text-align:left;}
}
<?php if($ai->custom_style) echo $ai->custom_style ?>
</style>
<title><?=$ai->site_name?></title>
</head>
<body>
<div class="container">
	<?php if(!$ai->admin_button) {?>
	<div class="alert alert-danger alert-block">
			<p>심플 공사중 페이지를 구입해주셔서 감사합니다. 애드온 설정 페이지에서 공사중 페이지를 변경해주세요 :)</p>
			<p><a href="<?=getURL('','module','admin','act','dispAddonAdminSetup','selected_addon','simple_parking')?>" class="btn btn-danger btn-mini"><i class="icon-share-alt icon-white"></i> 바로가기</a>
		</div>
	<?php } ?>
	<?php if($ai->custom_top) echo $ai->custom_top ?>
	<div class="hero-unit">
		<?php if($ai->preview_img_use=='yes') { ?>
		<a class="thumbnail preview_img"><img src="<?php $ai->preview_img?>" /></a>
		<?php } ?>
		<h1><? if($ai->site_name){ echo "$ai->site_name"; } else { echo "공사중입니다.";}?></h1>
		<p class="content">
		<? if($ai->content){ echo "$ai->content"; } else { echo "이 사이트는 공사중입니다. 나중에 접속해주시기 바랍니다."; } ?>
		</p>
		<?php if($ai->progress=="yes"){ ?>
			<div class="progress progress-striped <?=$ai->progress_active?>">
				<div class="bar" style="width:<?=$ai->progress_number?>%"></div>
			</div>
		<?php } ?>
		<p class="btnArea">
			<?php if($ai->back_button!='no') { ?><a onclick="history.go(-1)" class="btn"><i class="icon-arrow-left"></i> 뒤로가기</a><?php } ?>
			<?php if($ai->admin_button!='no') { ?><a href="<?=getURL('','module','admin')?>" class="btn"><i class="icon-lock"></i> 관리자</a><?php } ?>
			<?php if($ai->email_button=="yes") { ?><a href="mailto:<?=$ai->admin_email?>" class="btn btn-primary"><i class="icon-envelope icon-white"></i> 연락하기</a><?php } ?>
		</p>
	</div>
	<?php if($ai->custom_bottom) echo $ai->custom_bottom ?>
</div>
</body>
</html>
<?php
exit();
}
}
?>
