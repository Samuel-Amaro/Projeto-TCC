/**
 * * Esta Função Mostra o modal
 */
 function mostraModalAlterarCategoria() {
    let elementoModal = document.querySelector("#modalCategoria");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

/**
 * * ESTA FUNÇÃO MOSTRA O MODAL DE EXCLUIR CATEGORIA
 */
function mostraModalExcluirCategoria(id_categoria) {
    Swal.fire({
        title: 'Realmente deseja deletar esta categoria?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: 'Sim',
        denyButtonText: 'Não',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
    }).then((result) => {
        //sim deseja deletar
        if (result.isConfirmed) {
            if(makeRequestCategoria("../controller/ControllerCategoriaBeneficio.php", id_categoria, "excluir")) {
                //faz alteração 
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Categoria não foi deletado. tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde.',
                    footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                });
            }
        }else if(result.isDenied) {
            //não deseja deletar  
            //Swal.fire('Fornecedor ou doador não sera deletado.', '', 'info');
        }
    });
}

function carregaDadosModalAlterarCategoria(data) {
    let nome = document.querySelector(".mdNomeCategoria");
    let descricao = document.querySelector(".mdDescricaoCategoria");
    let id = document.querySelector("#idCategoria");
    id.value = data.id_categoria;
    //console.log("CARREGA DADOS ID: " + data.id_categoria);
    nome.value = data.nome;
    descricao.value = data.descricao;
}

function obterDadosModalAlterarCategoria() {
    let nomeForm = document.querySelector(".mdNomeCategoria").value;
    let descricaoForm = document.querySelector(".mdDescricaoCategoria").value;
    let idForm = document.querySelector("#idCategoria").value;
    //console.log(idForm);
    let categoria = {id : idForm, nome : nomeForm, descricao : descricaoForm};
    return categoria;
}