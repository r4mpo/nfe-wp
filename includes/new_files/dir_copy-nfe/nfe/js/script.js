function apenasNumeros(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /^[0-9.]+$/;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

window.onload = function () {
    viaCep('CEP_C13', 'xBairro_C09', 'xMun_C11', 'UF_C12', 'xLgr_C06');
    viaCep('CEP_E13', 'xBairro_E09', 'xMun_E11', 'UF_E12', 'xLgr_E06');

    camposMoeda = Array.prototype.slice.call(document.getElementsByClassName('currency'), 0);

    camposMoeda.forEach(element => {
        formatarMoeda(element.id);
    });
}

window.onmouseover = function () {
    definirValorOutrasDespesas();
}

function definirValorOutrasDespesas() {
    let frete = document.getElementById('vFrete_W08').value;
    let seguro = document.getElementById('vSeg_W09').value;

    frete = frete.replace('R$ ', '');
    seguro = seguro.replace('R$ ', '');

    if (!frete) {
        frete = 0;
    }

    if (!seguro) {
        seguro = 0;
    }

    let outrasDespesas = document.getElementById('vOutro_W15').value = parseFloat(seguro) + parseFloat(frete);
}

function somarOutrasDespesasNoValorTotalNfe() 
{
    let valorTotalDosProdutos = document.getElementById('vProd_W07').value;
    let valorTotalOutrasDespesas = document.getElementById('vOutro_W15').value;
    let valorASerPago = document.getElementById('valorASerPago').value;
    
    valorASerPago = valorASerPago.replace('R$ ', '');
    valorTotalDosProdutos = valorTotalDosProdutos.replace('R$ ', '');
    
    let valorTotalNfe = parseFloat(valorTotalDosProdutos) + parseFloat(valorTotalOutrasDespesas);
    let valorTotalASerPago = parseFloat(valorASerPago) + parseFloat(valorTotalOutrasDespesas);
    
    document.getElementById('vPag_YA03').value = 'R$ ' + valorTotalASerPago;
    document.getElementById('vNF_W16').value = 'R$ ' + valorTotalNfe;

}


const viaCep = async (cep, bairro, municipio, estado, logradouro) => {
    if (document.getElementById(cep).value.length == 8) {
        const response = await fetch(`https://viacep.com.br/ws/${document.getElementById(cep).value}/json/`)
        const data = await response.json();

        if (data != null) {
            document.getElementById(bairro).value = data.bairro;
            document.getElementById(municipio).value = data.localidade;
            document.getElementById(estado).value = data.uf;
            document.getElementById(logradouro).value = data.logradouro;
        }
    }
}

function formatarMoeda(el) {

    var element_html = document.getElementById(el);
    var coin = element_html.value;

    coin = coin + '';
    coin = parseInt(coin.replace(/[\D]+/g, ''));
    coin = coin + '';
    coin = coin.replace(/([0-9]{2})$/g, ".$1");

    if (coin == 'NaN') {
        coin = 0;
    }

    if (coin < 1 && coin > 0) {
        coin = '0' + coin
    }

    valorReal = 'R$ ' + coin;
    element_html.value = valorReal;
}