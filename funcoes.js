function formatar_mascara(src, mascara) {

	var campo = src.value.length;
    var saida = mascara.substring(0,1);
    var texto = mascara.substring(campo);
    
	if(texto.substring(0,1) != saida) {
		src.value += texto.substring(0,1);
    }
    
}

function formataTel(evt) {

    var obj;
    
    if (navigator.appName.indexOf("Netscape") != -1) {
	obj = evt.target;
    }
    else {
	obj = evt.srcElement;
    }
    
    qtd = obj.value.length;
    
    if (qtd == 2) obj.value = "("+obj.value+") ";
    if (qtd == 9) obj.value = obj.value+"-";
    if (qtd == 12 && evt.keyCode == 8) {
	character = tiraChar(obj.value, "-");
	obj.value = character.substring(0,7)+"-"+character.substring(7,12);
    }
	
    if (qtd == 13) {
	character = tiraChar(obj.value, "-");
	obj.value = character.substring(0,8)+"-"+character.substring(8,12);
    }
	
  }

function validaserie() {

    f = document.frmCadastro;

    //Valida Descrição
    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }

    f.submit();
    
}
  
function validacategoria() {

    f = document.frmCadastro;

    //Valida Descrição
    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }

    f.submit();
    
}

function validacampeonato() {

	f = document.frmCadastro;

    //Valida Descrição
    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }
    
    if (f.CATEGORIA.value == "0") {
	alert("O campo Categoria deve ser preenchido!");
	f.CATEGORIA.focus();
	return false;
    }
    
    if (f.GENERO.value == "") {
	alert("O campo Gênero deve ser preenchido!");
	f.GENERO.focus();
	return false;        
    }

    f.submit();
    
}

function validagrupo() {
	
	f = document.frmCadastro;

    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }
    
    if (f.SERIE.value == "0") {
	alert("O campo Série deve ser preenchido!");
	f.SERIE.focus();
	return false;
    }
    
    f.submit();
    
}

function validausuario() {

	f = document.frmCadastro;

    //Valida Descrição
    if (f.NOME.value == "") {
	alert("O campo Nome deve ser preenchido!");
	f.NOME.focus();
	return false;
    }
    
    if (f.EMAIL.value == "") {
	alert("O campo E-mail deve ser preenchido!");
	f.EMAIL.focus();
	return false;
    }
    
    if (f.SENHA.value == "") {
	alert("O campo Senha deve ser preenchido!");
	f.SENHA.focus();
	return false;
    }

    f.submit();
    
}

function validalogin() {

    f = document.frm_login;

    //Valida Login
    if (f.login.value == "") {
	alert("O campo Login deve ser preenchido!");
	f.login.focus();
	return false;
    }

    //Valida Senha
    if (f.senha.value == "") {
	alert("O campo Senha deve ser preenchido!");
	f.senha.focus();
	return false;
    }

    f.submit();
	
}

function validaconfronto() {
    
    f = document.frmCadastro;
    
    //Valida Descrição
    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }
    
    f.submit();
    
}

function validapartida() {
    
    f = document.frmCadastro;
    
    if (f.TIME_MANDANTE.value == 0) {
	alert("O campo Time Mandante deve ser preenchido!");
	f.TIME_MANDANTE.focus();
	return false;
    }
    
    if (f.TIME_VISITANTE.value == 0) {
	alert("O campo Time Visitante deve ser preenchido!");
	f.TIME_VISITANTE.focus();
	return false;
    }     
    
    if (f.GRUPO.value == 0) {
	alert("O campo Grupo deve ser preenchido!");
	f.GRUPO.focus();
	return false;
    }      

    if (f.CONFRONTO.value == 0) {
	alert("O campo Confronto deve ser preenchido!");
	f.CONFRONTO.focus();
	return false;
    }
    
    if (f.DATA.value == "") {
	alert("O campo Data deve ser preenchido!");
	f.CONFRONTO.focus();
	return false;
    } else {
        verifica_data_hora();
    }
    
    
    if (f.TIME_MANDANTE.value == f.TIME_VISITANTE.value) {
	alert("Time mandante não pode ser igual ao time visitante!");
	f.TIME_VISITANTE.focus();
	return false;        
    }
    
    f.submit();
    
}

function validatime() {
    
    f = document.frmCadastro;
    
    //Valida Descrição
    if (f.NOME.value == "") {
	alert("O campo Nome deve ser preenchido!");
	f.NOME.focus();
	return false;
    }
    
    f.submit();
    
}

function ativacampeonato() {
    
    f = document.campeonato;
    f.submit();
    
}

function contacaracter(field, countfield, maxlimit) {
  
    if (field.value.length > maxlimit) {
    field.value = field.value.substring(0, maxlimit);
  }
  else {
    countfield.value = maxlimit - field.value.length;
  }
  
}

function enviaInsere(url, metodo, modo)
{
    f = document.frmCadastro;
    
    var email = f.EMAIL.value;
    remoto  = new ajax();
    xmlhttp = remoto.enviar(url + "?emailUsuario=" + email, metodo, modo );
    
    if(xmlhttp) {
	alert("Esse e-mail de usuário já está cadastrado no sistema!");
	f.EMAIL.focus();
	return false;
    }    
}

function enviaAltera(url, metodo, modo, chave)
{
    f = document.frm_cadastro;
    
    var email = f.EMAIL.value;
    remoto  = new ajax();
    xmlhttp = remoto.enviar(url + "?emailUsuario=" + email + "&chaveUsuario=" + chave, metodo, modo );
    
    if(xmlhttp) {
	alert("Esse e-mail de usuário já está cadastrado no sistema!");
	f.EMAIL.focus();
	return false;
    }
}

function mostrarJogadores(time) {
    var display = document.getElementById(time).style.display;

    if(display == "none")
        document.getElementById(time).style.display = 'block';
    else
        document.getElementById(time).style.display = 'none';
}

function mascara_data_hora(data_hora){ 
    var mydata = ''; 
    mydata = mydata + data_hora; 
    
    if (mydata.length == 2){ 
        mydata = mydata + '/'; 
        document.frmCadastro.DATA.value = mydata; 
    } 
    if (mydata.length == 5){ 
        mydata = mydata + '/'; 
        document.frmCadastro.DATA.value = mydata; 
    } 
    if (mydata.length == 13){ 
        mydata = mydata + ':'; 
        document.frmCadastro.DATA.value = mydata; 
    }     
    if (mydata.length == 16){ 
        verifica_data_hora(); 
    }    
} 

function mascara_data_hora(data_hora){ 
    var mydata = ''; 
    mydata = mydata + data_hora; 
    
    if (mydata.length == 2){ 
        mydata = mydata + '/'; 
        document.frmCadastro.DATA.value = mydata; 
    } 
    if (mydata.length == 5){ 
        mydata = mydata + '/'; 
        document.frmCadastro.DATA.value = mydata; 
    } 
    if (mydata.length == 13){ 
        mydata = mydata + ':'; 
        document.frmCadastro.DATA.value = mydata; 
    }     
    if (mydata.length == 16){ 
        verifica_data_hora(); 
    }    
} 

function validahistoria() {
    
    f = document.frmCadastro;
    
    //Valida Titulo
    if (f.TITULO.value == "") {
	alert("O campo Título deve ser preenchido!");
	f.TITULO.focus();
	return false;
    }

    //Valida SubTitulo
    if (f.SUBTITULO.value == "") {
	alert("O campo Subtítulo deve ser preenchido!");
	f.SUBTITULO.focus();
	return false;
    }
    
    //Valida Titulo
    var texto = tinyMCE.get('TEXTO').getContent();
    
    //if (f.TEXTO.value == "") {
    if (texto == "") {
	alert("O campo Texto da história deve ser preenchido!");
	f.TEXTO.focus();
	return false;
    }
    
    f.submit();
    
}

function validanoticia() {
    
    f = document.frmCadastro;
    
    //Valida Titulo
    if (f.TITULO.value == "") {
	alert("O campo Título deve ser preenchido!");
	f.TITULO.focus();
	return false;
    }

    //Valida SubTitulo
    if (f.SUBTITULO.value == "") {
	alert("O campo Subtítulo deve ser preenchido!");
	f.SUBTITULO.focus();
	return false;
    }
    
    //Valida Texto
    //if (f.TEXTO.value == "") {
    

    var texto = tinyMCE.get('TEXTO').getContent();
    
    if (texto == "") {
        //alert(f.TEXTO.value);
	alert("O campo Texto da notícia deve ser preenchido! " + f.TEXTO.value);
	f.TEXTO.focus();
	return false;
    }

    f.submit();
    
}

function validaestadio() {

    f = document.frmCadastro;

    //Valida Descrição
    if (f.DESCRICAO.value == "") {
	alert("O campo Descrição deve ser preenchido!");
	f.DESCRICAO.focus();
	return false;
    }

    f.submit();
    
}
