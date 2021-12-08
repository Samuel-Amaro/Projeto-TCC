//quando o formulario e submetido para cadastrar beneficio, os dados são inseridos na tabela do datatables
let submitForm = document.querySelector(".form-beneficio");
//quando formulario de beneficio submetido
submitForm.addEventListener("submit", function(event) {
    try {
        if(validaCamposForm()) {
            //verifica se a um fornecedor ou doador associado
            let fornDoad = obterDadosFornecedorDoador();
            if(fornDoad === false) {
                limpaCamposForm();
                event.preventDefault(); 
            }else{
                let beneficioCompleto = getDadosBeneficioCompleto(obterDadosBeneficio(), obterDadosFornecedorDoador());
                //console.log(obterDadosBeneficio());
                //console.log(obterDadosFornecedorDoador());
                //add os dados de um beneficio como uma linha da tabela e redesenha
                tabelaBeneficios.row.add(beneficioCompleto).draw();
                //add os dados de um beneficio a um array, cada item do array e um object
                arrayBeneficios.push(beneficioCompleto);
                //limpa form
                limpaCamposForm();
                event.preventDefault();
            }
        }else{
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor, preencha corretamente os campos do formulário inserir beneficio, para poder concluir a operação de cadastro do novo benefício.'
            }); 
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
        "descricao" : beneficio.descricaoBeneficio, 
        "idTipeBeneficio" : beneficio.idTipoBeneficio, 
        "idTipoAquisicao" : beneficio.idTipoAquisicao, 
        "quantidade" : beneficio.quantidade,  
        "idFornecedorDoador" : fornecedorDoador.id, 
        "nomeFornecedorOuDoador" : fornecedorDoador.nome, 
        "cnpjOuCpfFornecedorDoador" : fornecedorDoador.cnpjOuCpf};    
    return beneficioCompleto;
}