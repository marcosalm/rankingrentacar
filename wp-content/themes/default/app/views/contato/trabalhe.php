<div class="row dstk interna">
	<div class="slide-dstk"></div>
</div>
<div class="row faixa"></div>
<div class="row cont-int reserve">
	<div class="limit">
		<div class="grid g12">
			<div class="container t6">
				<div class="titulo">
					<h1>Trabalhe Conosco</h1>
				</div>
				<?php if ( isset($message) ) : ?>
				<div class="alert <?php echo $class; ?>"><?php echo $message; ?></div>
				<?php endif; ?>
				<div class="fale_conosco">
					<h2>Contato</h2>
					<form action="<?php echo get_bloginfo('wpurl'); ?>/contato/trabalhe-conosco.html" method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="nome">Nome*</label>
								<input data-title="Nome" class="tam1 need" id="nome" name="nome" type="text" />
							</li>
							<li class="left">
								<label for="email">E-mail*</label>
								<input data-title="E-mail" type="text" id="email" name="email" class="email need" />
							</li>
							<li class="right">
								<label for="telefone">Telefone</label>
								<input type="text" id="telefone" name="telefone" class="phone telefone" />
							</li>
							<li class="left">
								<label for="curriculum">Currículo*</label>
								<input data-title="Curriculum" type="file" id="curriculum" name="curriculum" class="file need" />
							</li>
						</ul>
						<button class="right"><i class="bl"></i><span>Enviar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
					</form>
				</div>
			</div>
			<div class="container t6">
				<div class="faixa3"></div>	
				<?php
				$social   = get_option('config_social');
				$facebook = isset($social['facebook']) ? $social['facebook'] : false;
				if ($facebook) : 
				?>
				<div class="endereco">
					<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2F<?php echo $facebook; ?>%3Ffref%3Dts&amp;width=300&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;header=false&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:258px;" allowTransparency="true"></iframe>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>