var barra = document.getElementById("barra");
var open = document.getElementById("open");
var close = document.getElementById("close");
var topo_barra = document.getElementById("topo-barra");
var menu = document.getElementById("menu");
var overlay = document.getElementById("overlay");
var crianca = document.getElementById("crianca");
var adolescente = document.getElementById("adolescente");
var adulto = document.getElementById("adulto");
var idoso = document.getElementById("idoso");
var gestante = document.getElementById("gestante");
var indigena = document.getElementById("indigena");
var frequencia = document.getElementById("frequencia");
var diariamente = document.getElementById("diariamente");
var semanalmente = document.getElementById("semanalmente");
var inthoras = document.getElementById("inthoras");
var intdias = document.getElementById("intdias");
var intoutro = document.getElementById("intoutro");

function openCronograma(){
	overlay.classList.remove("oc-ov");
	fadein();
}
function openModal(){
	overlay.classList.remove("oc-ov");
	fadein();
}

function abrir_menu(){
	barra.classList.remove("barra_min");
	barra.classList.add("barra_min_pad");
	open.classList.add("oc-ov");
	close.classList.remove("oc-ov");
	topo_barra.classList.remove("oc-uv");
	menu.classList.remove("oc-uv");
	fadeinmenu();
}
function fechar_menu(){
	topo_barra.classList.add("oc-uv");
	menu.classList.add("oc-uv");
	barra.classList.remove("barra_min_pad");
	open.classList.remove("oc-ov");
	close.classList.add("oc-ov");
	barra.classList.add("barra_min");
}

function fadein() {
    var op = 0.1;  // initial opacity
    overlay.style.display = 'block';
    var timer = setInterval(function () {
    	if (op >= 1){
    		clearInterval(timer);
    	}
    	overlay.style.opacity = op;
    	overlay.style.filter = 'alpha(opacity=' + op * 100 + ")";
    	op += op * 0.3;
    }, 10);
}
function fadeinmenu() {
    var op = 0.01;  // initial opacity
    var timer = setInterval(function () {
    	if (op >= 1){
    		clearInterval(timer);
    	}
    	topo_barra.style.opacity = op;
    	menu.style.opacity = op;
    	topo_barra.style.filter = 'alpha(opacity=' + op * 50 + ")";
    	menu.style.filter = 'alpha(opacity=' + op * 10 + ")";
    	op += op * 0.2;
    }, 10);
}

function closeCronograma(){
	fadeout();
	overlay.classList.add("oc-ov");
}
function closeModal(){
	fadeout();
	window.location.reload();
	overlay.classList.add("oc-ov");
}

function fadeout(){
	var op = 1;  // initial opacity
	var timer = setInterval(function () {
		if (op <= 0.1){
			clearInterval(timer);
			overlay.style.display = 'none';
		}
		overlay.style.opacity = op;
		overlay.style.filter = 'alpha(opacity=' + op * 100 + ")";
		op -= op * 0.2;
	}, 50);
}

function dcrianca(){
	adolescente.classList.add("bx2");
	adulto.classList.add("bx3");
	idoso.classList.add("bx4");
	gestante.classList.add("bx5");
	indigena.classList.add("bx6");

	crianca.classList.remove("bx1");
}

function dadolescente(){
	crianca.classList.add("bx1");
	adulto.classList.add("bx3");
	idoso.classList.add("bx4");
	gestante.classList.add("bx5");
	indigena.classList.add("bx6");

	adolescente.classList.remove("bx2");
}

function dadulto(){
	crianca.classList.add("bx1");
	adolescente.classList.add("bx2");
	idoso.classList.add("bx4");
	gestante.classList.add("bx5");
	indigena.classList.add("bx6");

	adulto.classList.remove("bx3");
}

function didoso(){
	crianca.classList.add("bx1");
	adolescente.classList.add("bx2");
	adulto.classList.add("bx3");
	gestante.classList.add("bx5");
	indigena.classList.add("bx6");

	idoso.classList.remove("bx4");
}

function dgestante(){
	crianca.classList.add("bx1");
	adolescente.classList.add("bx2");
	adulto.classList.add("bx3");
	idoso.classList.add("bx4");
	indigena.classList.add("bx6");

	gestante.classList.remove("bx5");
}

function dindigena(){
	crianca.classList.add("bx1");
	adolescente.classList.add("bx2");
	adulto.classList.add("bx3");
	idoso.classList.add("bx4");
	gestante.classList.add("bx5");

	indigena.classList.remove("bx6");
}

// Frequencia Medicamentos
frequencia.addEventListener('change', function(){
    if (this.value == 1) {
    	semanalmente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");

    	diariamente.classList.remove("oc-ov");
    }else if(this.value == 2){
    	diariamente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");

    	semanalmente.classList.remove("oc-ov");
	}else if (this.value == 3){
		diariamente.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");
    	semanalmente.classList.add("oc-ov");

    	inthoras.classList.remove("oc-ov");
	}else if (this.value == 4){
		diariamente.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");
    	semanalmente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");

    	intdias.classList.remove("oc-ov");
	}else if (this.value == 5){
		diariamente.classList.add("oc-ov");
    	semanalmente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");

    	intoutro.classList.remove("oc-ov");
	}else if (this.value == 6){
		diariamente.classList.add("oc-ov");
    	semanalmente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");
	}else if (this.value == ""){
		diariamente.classList.add("oc-ov");
    	semanalmente.classList.add("oc-ov");
    	inthoras.classList.add("oc-ov");
    	intdias.classList.add("oc-ov");
    	intoutro.classList.add("oc-ov");
	}
});