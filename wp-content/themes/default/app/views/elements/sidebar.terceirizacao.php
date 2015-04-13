<div class="container t4 sidebar">
	<span class="ponta left"></span>
	<form class="left" method="post" action="<?php echo get_bloginfo('wpurl'); ?>/contato/terceirizacao-frotas.html">
		<h2>solicite <strong>sua frota</strong></h2>
		<div class="line white"><span></span></div>
		<label for="nome">Nome*</label>
		<input class="need" data-title="Nome" id="nome" name="nome" type="text" />
		<label for="email">E-mail*</label>
		<input class="need" data-title="E-Mail" id="email" name="email" type="text" />
		<label for="telefone">Telefone*</label>
		<input class="phone need" data-title="Telefone" id="telefone" name="telefone" type="text" />
		<label for="empresa">Empresa*</label>
		<input class="need" data-title="Empresa" id="empresa" name="empresa" type="text">
		<label for="frota">Escolha o seu tipo de frota</label>
		<div class="medio">
			<select id="frota" name="frota" class="selectyze" style="width:50px;">
				<option value="Terceirização de frota com mão de obra">Com mão de obra</option>
				<option value="Terceirização de frota sem mão de obra">Sem mão de obra</option>
				<option value="Aluguel diário">Aluguel diário</option>
			</select>
		</div>
		<label for="obs">Observações</label>
		<textarea name="obs" id="obs" rows="5"></textarea>
		<button class="right"><i class="bl"></i><span>Enviar</span> <i class="br"></i><i class="bg-amarelo"></i> </button>
	</form>
</div>