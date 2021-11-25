//quando o formulario e submetido para cadastrar beneficio, os dados são inseridos na tabela do datatables
let submitForm = document.querySelector(".form-beneficio");
let seletoresCssCamposForm = ["#descricao-beneficio", "#nomeBeneficio", "#categoriaBeneficio", "#formaAquisicao", "#qtdTotal", "#unidadeMedida", "#qtdPorMedida", "#qtdMaxima", "#qtdMinima"];
//quando formulario de beneficio submetido
submitForm.addEventListener("submit", function(event) {
    try {
        let camposInvalidos = validaCamposForm(seletoresCssCamposForm);
        //não possui campos invalidos no form de beneficio
        if(camposInvalidos.length === 0) {
            //verifica se a um fornecedor ou doador associado
            let fornDoad = obterDadosFornecedorDoador();
            if(fornDoad === false) {
                limpaCamposForm();
                event.preventDefault(); 
            }else{
                let dadosBeneficios = getDadosBeneficioCompleto(obterDadosBeneficio(), obterDadosFornecedorDoador());
                console.log(obterDadosBeneficio());
                console.log(obterDadosFornecedorDoador());
                //add os dados de um beneficio como uma linha da tabela e redesenha
                tabelaBeneficios.row.add(dadosBeneficios).draw();
                //add os dados de um beneficio a um array, cada item do array e um object
                arrayBeneficios.push(dadosBeneficios);
                //limpa form
                limpaCamposForm();
                event.preventDefault();
            }
        }//possui campos invalidos no form de beneficio
        else{
           for(let index = 0; index < camposInvalidos.length; index++) {
               setaEstiloValidacaoCampo(camposInvalidos[index], ".is-invalid"); 
           }
           event.preventDefault(); 
        }     
    } catch (error) {
        event.preventDefault();
        console.error(error);
    }
});

/**
 * Esta função obtem os beneficios que vão ser cadastrados.
 */
 function obterBeneficiosACadastrar() {
    console.log(arrayBeneficios);
}

/**
 * * Esta função unifica dois objetos em um so objeto fazendo a composição de uma entidade completa para o banco de dados, com os dados necessarios
 * @param {*} beneficio 
 * @param {*} fornecedorDoador 
 * @returns 
 */
function getDadosBeneficioCompleto(beneficio = {}, fornecedorDoador = {}) {
    let beneficioCompleto = {
        descricao : beneficio.descricaoBeneficio, 
        nome: beneficio.nomeBeneficio, 
        categoriaId : beneficio.categoriaBeneficio, 
        formaAquisicao : beneficio.formaAquisicao, 
        qtdTotal : beneficio.quantidadeTotal, 
        unidadeMedidaId : beneficio.unidadeMedida, 
        qtdMedida : beneficio.quantidadePorMedida, 
        qtdMinima : beneficio.quantidadeMinima, 
        qtdMaxima: beneficio.quantidadeMaxima, 
        idFornecedorOuDoador : fornecedorDoador.id, 
        nomeFornecedorOuDoador : fornecedorDoador.nome, 
        cnpjOuCpfFornecedorDoador : fornecedorDoador.cnpjOuCpf};    
    return beneficioCompleto;
}