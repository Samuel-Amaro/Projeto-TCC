//armazena beneficios, a serem cadastrados, e popula tabela HTML
let arrayBeneficios = [];

let tabelaBeneficios = new DataTable('#dataTablesBeneficio', {
    //opções de inicialização do plugin
    //"scrollX": true,
    "responsive": true,
    "paging": true,
    "language": {
        "emptyTable": "Sem benefícios a serem cadastrados"
    },
    "data": arrayBeneficios, //array com beneficios
    "columns": [
        {data: 'descricaoBeneficio'},
        {data: 'nomeBeneficio'},
        {data: 'categoriaBeneficio'},
        {data: 'formaAquisicao'},
        {data: 'quantidadeTotal'},
        {data: 'unidadeMedida'},
        {data: 'quantidadePorMedida'}
    ]
});

let submitForm = document.querySelector(".form-beneficiario");


submitForm.addEventListener("submit", function(event) {
    try {
        tabelaBeneficios.row.add(obterDadosBeneficio()).draw();
        arrayBeneficios.push(obterDadosBeneficio());
        //console.log(arrayBeneficios);
        limpaCamposForm();
        event.preventDefault();    
    } catch (error) {
        event.preventDefault();
        console.error(error);
    }
});

/**
 * Esta função obtem os dados submitidos do formulario do beneficio
 * @returns json
 */
function obterDadosBeneficio() {
    let beneficio = {
        "descricaoBeneficio" : document.querySelector(".descricao-beneficio").value,
        "nomeBeneficio" : document.querySelector("#nomeBeneficio").value,  
        "categoriaBeneficio" : document.querySelector("#categoriaBeneficio").value, 
        "formaAquisicao" : document.querySelector("#formaAquisicao").value,
        "quantidadeTotal" : document.querySelector("#qtdTotal").value,
        "unidadeMedida" : document.querySelector("#unidadeMedida").value,
        "quantidadePorMedida" : document.querySelector("#qtdPorMedida").value
    };
    return beneficio;
}

/**
 * Esta função limpa campos do formulario
 */
function limpaCamposForm() {
    document.querySelector(".descricao-beneficio").value = '';
    document.querySelector("#nomeBeneficio").value = '';
    document.querySelector("#categoriaBeneficio").options.item(0).selected = true;
    document.querySelector("#formaAquisicao").options.item(0).selected = true;
    document.querySelector("#qtdTotal").value = '';
    document.querySelector("#unidadeMedida").options.item(0).selected = true;
    document.querySelector("#qtdPorMedida").value = '';
}