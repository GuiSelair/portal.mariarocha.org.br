/*
    CONTROLADOR DE FORMULARIOS DE CADASTRO
*/

function salvaADMIN(){
    let adminValues = []
    let error = false
    let informacoesADMIN = document.querySelectorAll("#cadastra-Admin input")
    informacoesADMIN.forEach((input, index) => {
      if (["nomeADMIN", "sobreADMIN", "loginADMIN", "senhaADMIN", "emailADMIN"].indexOf(input.name) >= 0 && !input.value){
        input.parentElement.classList.add("has-error")
        error = true
      }
      adminValues.push(input.value)
    })

    if (!error){
      $.ajax({
        type: "POST",
        url: "./controllers/salvaCadastro.php",
        datatype: "JSON",
        data: { adminArray: adminValues },
        success: function(response){
          $(".status").html(response)
        },
        error: function(response){
          $(".status").html(response)
        }
      })
    }
  }

function salvaFormulario(){
    const nameFormObrigatorios = ["buscaNome", "buscaSobre", "buscaID"];
    let informacoesCadastro = document.querySelectorAll("#form-cadastro input")
    informacoesCadastro.forEach((input, index) =>{
        if (nameFormObrigatorios.indexOf(input.name) >= 0 && !input.value){
            input.parentElement.classList.add("has-error")
        }
    })
}