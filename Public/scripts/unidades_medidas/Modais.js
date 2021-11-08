function mostraModalAlterar() {
    let elementoModal = document.querySelector("#modalUnidadeMedida");
    let objectBoostrap = new bootstrap.Modal(elementoModal);
    objectBoostrap.show();
}

function mostraModalExcluir(id) {
    Swal.fire({
        title: 'Realmente deseja deletar esta unidade de medida?',
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
            if(makeRequestUnidadesMedidas("../controller/ControllerUnidadeMedida.php", id, "excluir")) {
                //faz alteração 
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Unidade de medida não foi deletado. tivemos um problema interno em nosso servidor, por favor tente novamente mais tarde.',
                    footer: '<a href="#">Clique aqui se precisa de ajuda!</a>'
                });
            }
        }else if(result.isDenied) {
            //não deseja deletar  
            //Swal.fire('Fornecedor ou doador não sera deletado.', '', 'info');
        }
    });
}

function carregarDadosModalAlterar(data) {
    let siglaCampo = document.querySelector(".mdSilga");
    let descricaoCampo = document.querySelector(".mdDescricaoUnidadeMedida");
    let idCampo = document.querySelector("#idUm");
    siglaCampo.value = data.sigla;
    descricaoCampo.value = data.descricao;
    idCampo.value = data.id_unidade;
}


function validaCamposModal() {
    let siglaValue = document.querySelector(".mdSilga").value;
    let descricaoValue = document.querySelector(".mdDescricaoUnidadeMedida").value;
    if((siglaValue.length === 0 || !siglaValue.trim()) || (descricaoValue.length === 0 || !descricaoValue.trim())) {
        return false;
    }else{
        return true;
    }   
}

function obterDadosModalAlterar() {
    let siglaCampo = document.querySelector(".mdSilga").value;
    let descricaoCampo = document.querySelector(".mdDescricaoUnidadeMedida").value;
    let idCampo = document.querySelector("#idUm").value;
    let unidadeMedida = {id : idCampo, sigla : siglaCampo, descricao : descricaoCampo};
    return unidadeMedida;
}