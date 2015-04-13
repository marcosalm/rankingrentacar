<!DOCTYPE html>
<html>
	<head>
		<?php if ( !isset($seo) ) : ?>
		<title><?php echo get_the_title(); ?> | <?php echo get_bloginfo('name'); ?></title>
		<?php wp_head(); else: ?>
		<title><?php echo $seo->title; ?></title>
		<meta name="description" content="<?php echo $seo->description; ?>" />
		<meta name="keywords" content="<?php echo $seo->keywords; ?>" />
		<meta http-equiv="content-type" content="<?php echo get_bloginfo('html_type'); ?>; charset=<?php echo get_bloginfo('charset'); ?>" />
		<?php endif; ?>

		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo APP_WEBROOT; ?>/css/reset.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo APP_WEBROOT; ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo APP_WEBROOT; ?>/css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo APP_WEBROOT; ?>/css/datepicker.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo APP_WEBROOT; ?>/css/selectyze.css" />
		<link rel="stylesheet" type="text/css" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.min.css" />
		<!-- End: CSS -->

		<!-- Javascript -->
		<script type="text/javascript">var base_url = "<?php echo get_bloginfo('wpurl'); ?>/";</script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/bootstrap-datepicker.pt_BR.js" charset="UTF-8"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/jquery.selectyze.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/jquery.keep.min.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/jquery.maskedinput.min.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/jquery.validate.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/jquery.destaque.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/utils.min.js"></script>
		<script type="text/javascript" src="<?php echo APP_WEBROOT; ?>/js/default.js"></script>
		<!-- End: Javascript -->

	</head>
	<body>

		<!-- Google Tag Manager -->
		<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MTL9LQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-MTL9LQ');</script>
		<!-- End: Google Tag Manager -->

		<!-- Menu -->
		<div class="row black"></div>
		<div class="row topo tp-maior">
			<div class="limit">
				<div class="grid g12">
					<div class="container t12 menu">
						<a href="<?php echo get_bloginfo('wpurl'); ?>" class="logo"><img src="<?php echo APP_WEBROOT; ?>/img/logo_ranking.png" alt="Ranking Locações" title="Ranking Locações" /></a>
						<?php echo $this->element('header.menu'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="row topo tp-menor">
			<div class="limit">
				<div class="grid g12">
					<div class="container t12 menu">
						<a href="<?php echo get_bloginfo('wpurl'); ?>" class="logo"><img src="<?php echo APP_WEBROOT; ?>/img/logo_ranking.png" alt="Ranking Locações" title="Ranking Locações" /></a>
						<?php echo $this->element('header.menu'); ?>
					</div>
				</div>
			</div>
		</div>		
		<!-- End: Menu -->

		<!-- Content -->
		<div class="row conteudo">
			<?php echo $content_for_layout; ?>
		</div>
		<!-- End: Content -->

		<!-- Footer -->
		<div class="row bottom">
			<div class="limit">
				<div class="grid g12">
					<div class="container t12 menu-footer">
					<?php echo $this->element('footer.menu'); ?>
					</div>
					<div class="container t12">
						<span><?php echo get_bloginfo('name'); ?> - Todos os direitos reservados</span>
						<a target="_blank" class="right" href="http://www.4ps.com.br"><img src="<?php echo APP_WEBROOT; ?>/img/logo_4ps.png" title="4Ps Soluções" alt="4Ps Soluções"></a>
					</div>
				</div>
			</div>

			<?php wp_footer(); ?>
		</div>
		<!-- End: Footer -->

	</body>
</html>