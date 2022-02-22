<?php 
  require_once ('header.php'); 
  require_once ('barra.php');
  include_once("FUNCOES/CONNECTION/connect.php");

  $id_session = $_SESSION['id'];

  $queryuser = mysqli_query($conn, "SELECT * FROM usuarios WHERE id_usuario = '$id_session';");
  $w = mysqli_fetch_object($queryuser);

  $querycor = mysqli_query($conn, "SELECT u.id_usuario, u.id_cor, c.* FROM usuarios as u INNER JOIN cor as c ON u.id_cor = c.id WHERE u.id_usuario = '$id_session';");
  $x = mysqli_fetch_object($querycor);

  $querysexo = mysqli_query($conn, "SELECT u.id_usuario, u.id_sexo, s.* FROM usuarios as u INNER JOIN sexo as s ON u.id_sexo = s.id WHERE u.id_usuario = '$id_session';");
  $z = mysqli_fetch_object($querysexo);

  $queryesci = mysqli_query($conn,"SELECT u.id_usuario, u.id_estCivil, es.* FROM usuarios as u INNER JOIN estado_civil as es ON u.id_estCivil = es.id WHERE u.id_usuario = '$id_session';");
  $b = mysqli_fetch_object($queryesci);

  $querytps = mysqli_query($conn, "SELECT u.id_usuario, u.id_sangue, ts.* FROM usuarios as u INNER JOIN tipo_sangue as ts ON u.id_sangue = ts.id WHERE u.id_usuario = '$id_session';");
  $e = mysqli_fetch_object($querytps);

  $queryfum = mysqli_query($conn, "SELECT u.id_usuario, u.id_fumante, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_fumante = o.id WHERE u.id_usuario = '$id_session';");
  $g = mysqli_fetch_object($queryfum);

  $queryal = mysqli_query($conn, "SELECT u.id_usuario, u.id_alcool, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_alcool = o.id WHERE u.id_usuario = '$id_session';");
  $h = mysqli_fetch_object($queryal);

  $queryt = mysqli_query($conn, "SELECT u.id_usuario, u.id_tatuagem, o.* FROM usuarios as u INNER JOIN opcoes as o ON u.id_tatuagem = o.id WHERE u.id_usuario = '$id_session';");
  $i = mysqli_fetch_object($queryt);

  $query1 = mysqli_query($conn, "SELECT * FROM sexo;");
  $query2 = mysqli_query($conn, "SELECT * FROM estado_civil;");
  $query3 = mysqli_query($conn, "SELECT * FROM cor;");
  $query4 = mysqli_query($conn, "SELECT * FROM tipo_sangue;");
  $query5 = mysqli_query($conn, "SELECT * FROM opcoes;");
  $query6 = mysqli_query($conn, "SELECT * FROM opcoes;");
  $query7 = mysqli_query($conn, "SELECT * FROM opcoes;");
?>
<section class="conteudo">
  <h1>Editar Informações</h1>
  <p class="min-center">Mantenha suas informações sempre atualizadas</p>

  <section class="cadastro-form">
  	<form method="POST" action="FUNCOES/att_perfil.php" enctype="multipart/form-data">
      <label for="nome">Nome:
        <input type="text" name="nome" required="required" value="<?php echo $w->nome; ?>">
      </label>

      <label for="sobrenome">Sobrenome:
        <input type="text" name="sobrenome" required="required" value="<?php echo $w->sobrenome; ?>">
      </label>

      <label for="email">Email:
        <input type="text" name="email" required="required" value="<?php echo $w->email; ?>">
      </label>

      <label for="telefone">Telefone:
        <input type="text" name="telefone" maxlength="11" value="<?php echo $w->telefone; ?>">
      </label>

      <label for="desc">Data de Nascimento:
        <input type="date" name="dtnasc" required="required" value="<?php echo date("Y-m-d", strtotime($w->dt_nasc)); ?>">
      </label>

      <label for="sexo">Sexo:
        <select name="sexo" class="select">
          <?php  if ($w->id_sexo == NULL | $w->id_sexo == "" | $w->id_sexo == 0) { ?>
            <option value="">Selecione seu sexo</option>
          <?php }else{ ?>
            <option value="<?php echo $z->id_sexo; ?>">Atual: <?php echo $z->sexo; ?></option>
          <?php } ?>
          <?php while($a = mysqli_fetch_object($query1)){ ?>
            <option value="<?php echo $a->id; ?>"><?php echo $a->sexo; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="estCivil">Estado Civil:
        <select name="estCivil" class="select">
          <?php  if ($w->id_estCivil == NULL | $w->id_estCivil == "" | $w->id_estCivil == 0) { ?>
            <option value="">Selecione seu estado civil</option>
          <?php }else{  ?>
            <option value="<?php echo $b->id; ?>">Atual: <?php echo $b->estado; ?></option>
          <?php } ?>
          <?php while($c = mysqli_fetch_object($query2)){ ?>
            <option value="<?php echo $c->id; ?>"><?php echo $c->estado; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="cor">Cor:
        <select name="cor" class="select">
          <?php if ($w->id_cor == NULL | $w->id_cor == "" | $w->id_cor == 0) { ?>
            <option value="">Selecione sua cor</option>
          <?php }else{ ?>
            <option value="<?php echo $x->id_cor; ?>">Atual: <?php echo $x->cor; ?></option>
          <?php } ?>
          <?php while($d = mysqli_fetch_object($query3)){ ?>
            <option value="<?php echo $d->id; ?>"><?php echo $d->cor; ?></option>
          <?php } ?>
        </select>
      </label>

      <label>CPF:
        <input type="text" name="cpf" required="required" readonly maxlength="11" value="<?php echo $w->cpf; ?>" disabled>
      </label>

      <label>RG:
        <input type="text" name="rg" maxlength="10" value="<?php echo $w->rg; ?>">
      </label>

      <label>Cartão do SUS:
        <input type="text" name="sus" maxlength="15" value="<?php echo $w->sus; ?>">
      </label>

      <label for="alergia">Alergia:
        <textarea name="alergia" placeholder="Digite aqui todas as suas alergias, separadas por vírgula."><?php echo $w->alergia; ?></textarea>
        <div style="clear: both;"></div>
      </label>

      <label for="doencas">Doenças:
        <textarea name="doencas" placeholder="Caso possua, digite aqui todas as doenças, separadas por vírgula."><?php echo $w->doencas; ?></textarea>
        <div style="clear: both;"></div>
      </label>
      
      <br>

      <label for="tpSangue">Tipo Sanguíneo:
        <select name="tpSangue" class="select">
          <?php if ($w->id_sangue == NULL | $w->id_sangue == "" | $w->id_sangue == 0) { ?>
            <option value="">Selecione seu tipo sanguíneo</option>
          <?php }else{  ?>
            <option value="<?php echo $e->id_sangue; ?>">Atual: <?php echo $e->sangue; ?></option>
          <?php } ?>
          <?php while($f = mysqli_fetch_object($query4)){ ?>
            <option value="<?php echo $f->id; ?>"><?php echo $f->sangue; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="fum">Fumante?  
        <select name="fum" class="select">
          <?php if ($w->id_fumante == NULL | $w->id_fumante == "" | $w->id_fumante == 0) {  ?>
            <option value="">Selecione seu estado de fumante</option>
          <?php }else{  ?>
            <option value="<?php echo $g->id_fumante; ?>">Atual: <?php echo $g->opcao; ?></option>
          <?php }  ?>
          <?php while($j = mysqli_fetch_object($query5)){ ?>
            <option value="<?php echo $j->id; ?>"><?php echo $j->opcao; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="drink">Consome bebida alcoólica?   
        <select name="drink" class="select">
          <?php if ($w->id_alcool == NULL | $w->id_alcool == "" | $w->id_alcool == 0) { ?>
            <option value="">Selecione se você consome bebida alcoólica</option>
          <?php }else{ ?>
            <option value="<?php echo $h->id_alcool; ?>">Atual: <?php echo $h->opcao; ?></option>
          <?php } ?>
          <?php while($k = mysqli_fetch_object($query6)){ ?>
            <option value="<?php echo $k->id; ?>"><?php echo $k->opcao; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="tatu">Possui Tatuagem?  
        <select name="tatu" class="select">
          <?php if ($w->id_tatuagem == NULL | $w->id_tatuagem == "" | $w->id_tatuagem == 0) { ?>
            <option value="">Selecione se você consome bebida alcoólica</option>
          <?php }else{ ?>
            <option value="<?php echo $i->id_tatuagem; ?>">Atual: <?php echo $i->opcao; ?></option>
          <?php } ?>
          <?php while($l = mysqli_fetch_object($query7)){ ?>
            <option value="<?php echo $l->id; ?>"><?php echo $l->opcao; ?></option>
          <?php } ?>
        </select>
      </label>

      <label for="totTatuagem">Quantas?
        <input name="totTatuagem" maxlength="3" placeholder="Caso tenha tatuagens, escreva aqui a quantidade..." value="<?php echo $w->quant_tatuagem; ?>">
      </label>

      <label>Cep:
        <input name="cep" type="text" id="cep" maxlength="9" value="<?php echo $w->cep; ?>">
      </label>

      <label>Rua:
        <input name="rua" type="text" id="rua" value="<?php echo $w->rua; ?>"/>
      </label>

      <label>Nº:
        <input name="num" type="text" id="rua" value="<?php echo $w->numero; ?>"/>
      </label>

      <label>Bairro:
        <input name="bairro" type="text" id="bairro" value="<?php echo $w->bairro; ?>" />
      </label>

      <label>Cidade:
        <input name="cidade" type="text" id="cidade" value="<?php echo $w->cidade; ?>"/>
      </label>

      <label>Estado:
        <input name="uf" type="text" id="uf" value="<?php echo $w->estado; ?>"/>
      </label>

      <label for="obs">Observações:
        <textarea name="obs" placeholder="Digite aqui as observações necessárias sobre você."><?php echo $w->obs; ?></textarea>
        <div style="clear: both;"></div>
      </label>

      <input type="submit" name="enviar" class="btn-form" value="Atualizar">
    </form>

    <br style="margin-top: 5em;">
    
  </section>
  <?php
    if(isset($_SESSION['msg'])){
      echo $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
  ?>
</section>
  <!--JQuery e Javascript para o endereço automatico de acordo com o cep-->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

  <script type="text/javascript" >
    $(document).ready(function() {
      function limpa_formulário_cep() {
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
        $("#ibge").val("");
      }

    $("#cep").blur(function() {
      var cep = $(this).val().replace(/\D/g, '');
      if (cep != "") {
        var validacep = /^[0-9]{8}$/;
        if(validacep.test(cep)) {
          $("#rua").val("...");
          $("#bairro").val("...");
          $("#cidade").val("...");
          $("#uf").val("...");
          $("#ibge").val("...");

          $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
            if (!("erro" in dados)) {
              $("#rua").val(dados.logradouro);
              $("#bairro").val(dados.bairro);
              $("#cidade").val(dados.localidade);
              $("#uf").val(dados.uf);
              $("#ibge").val(dados.ibge);
            }else{
              limpa_formulário_cep();
              alert("CEP não encontrado.");
            }
          });
        }else {
          limpa_formulário_cep();
          alert("Formato de CEP inválido.");
        }
      }else{
        limpa_formulário_cep();
      }
    });
    });
  </script>
  <?php
    include ('footer.php');
  ?>
  <script>
    $("input[name='telefone']").mask("(99) 99999-9999");
    $("input[name='cpf']").mask("999.999.999-99");
    $("input[name='rg']").mask("99.999.999");
    $("input[name='cep']").mask("99.999-999");
  </script>